<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Get orders for authenticated customer (untuk StatusPage Flutter)
     */
    public function getCustomerOrders(Request $request): JsonResponse
    {
        try {
            // Get authenticated customer
            $customer = Auth::guard('api')->user();

            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer not authenticated'
                ], 401);
            }

            // Get orders for this customer
            $orders = Order::where('customer_id', $customer->id)
                          ->with('orderItems')
                          ->orderBy('created_at', 'desc')
                          ->get();

            // Transform data for response
            $ordersData = $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number, // Menggunakan accessor dari model
                    'customer_name' => $order->customer_name,
                    'address' => $order->address,
                    'total_amount' => (float) $order->total_amount,
                    'status' => $order->status,
                    'status_label' => $order->status_label, // Menggunakan accessor dari model
                    'status_color' => $order->status_color, // Menggunakan accessor dari model
                    'payment_proof_path' => $order->payment_proof_path,
                    'items' => $order->orderItems ? $order->orderItems->map(function ($item) {
                        return [
                            'product_name' => $item->product_name ?? 'Unknown Product',
                            'quantity' => $item->quantity,
                            'price' => (float) ($item->price_at_purchase ?? $item->price ?? 0),
                            'subtotal' => (float) (($item->price_at_purchase ?? $item->price ?? 0) * $item->quantity)
                        ];
                    }) : [],
                    'created_at' => $order->created_at->format('d M Y H:i'),
                    'updated_at' => $order->updated_at->format('d M Y H:i')
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Orders retrieved successfully',
                'data' => $ordersData
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error retrieving customer orders:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error retrieving orders: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single order details
     */
    public function getOrderDetails(Request $request, $orderId): JsonResponse
    {
        try {
            $customer = Auth::guard('api')->user();

            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer not authenticated'
                ], 401);
            }

            $order = Order::where('id', $orderId)
                         ->where('customer_id', $customer->id)
                         ->with('orderItems')
                         ->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            $orderData = [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'customer_name' => $order->customer_name,
                'address' => $order->address,
                'total_amount' => (float) $order->total_amount,
                'status' => $order->status,
                'status_label' => $order->status_label,
                'status_color' => $order->status_color,
                'payment_proof_path' => $order->payment_proof_path,
                'items' => $order->orderItems->map(function ($item) {
                    return [
                        'product_name' => $item->product_name ?? 'Unknown Product',
                        'quantity' => $item->quantity,
                        'price' => (float) ($item->price_at_purchase ?? $item->price ?? 0),
                        'subtotal' => (float) (($item->price_at_purchase ?? $item->price ?? 0) * $item->quantity)
                    ];
                }),
                'created_at' => $order->created_at->format('d M Y H:i'),
                'updated_at' => $order->updated_at->format('d M Y H:i')
            ];

            return response()->json([
                'success' => true,
                'message' => 'Order details retrieved successfully',
                'data' => $orderData
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error retrieving order details:', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error retrieving order details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create new order (Updated version of your store method)
     */
    public function store(Request $request): JsonResponse
    {
        Log::info('Order request received:', $request->all());

        $validator = Validator::make($request->all(), [
            'cartItems' => 'required', // Bisa string JSON atau array
            'address' => 'required|string|max:1000',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'customer_name' => 'sometimes|string|max:255', // Optional jika ada auth
        ]);

        if ($validator->fails()) {
            Log::error('Order validation failed:', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Handle cartItems (bisa string JSON atau sudah array)
        $cartItems = $request->input('cartItems');
        if (is_string($cartItems)) {
            $cartItems = json_decode($cartItems, true);
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($cartItems)) {
                Log::error('CartItems JSON decoding error or not an array');
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid cartItems format.'
                ], 400);
            }
        }

        DB::beginTransaction();
        try {
            // Get authenticated customer (jika ada)
            $customer = Auth::guard('api')->user();

            $totalAmount = 0;
            foreach ($cartItems as $item) {
                $product = Product::find($item['id'] ?? ($item['product_id'] ?? null));
                if (!$product) {
                    DB::rollBack();
                    Log::error('Product not found for item:', $item);
                    return response()->json([
                        'success' => false,
                        'message' => 'Product not found: ' . ($item['name'] ?? 'Unknown')
                    ], 404);
                }
                $totalAmount += (float) $item['price'] * (int) $item['quantity'];
            }

            // Handle payment proof upload
            $paymentProofPath = null;
            if ($request->hasFile('payment_proof')) {
                $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
            }

            // Create order
            $order = Order::create([
                'customer_id' => $customer ? $customer->id : null,
                'customer_name' => $request->input('customer_name', $customer ? $customer->name : 'Guest User'),
                'address' => $request->input('address'),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_proof_path' => $paymentProofPath,
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                $product = Product::find($item['id'] ?? ($item['product_id'] ?? null));
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name, // Simpan nama produk
                    'quantity' => $item['quantity'],
                    'price' => $item['price'], // Atau gunakan price_at_purchase
                ]);

                // Optional: Kurangi stok produk
                // $product->decrement('stock', $item['quantity']);
            }

            DB::commit();
            Log::info('Order created successfully:', ['order_id' => $order->id]);

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully!',
                'data' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'status' => $order->status
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update order status (Admin only - optional)
     */
    public function updateStatus(Request $request, $orderId): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $order = Order::findOrFail($orderId);
            $order->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
                'data' => [
                    'order_id' => $order->id,
                    'status' => $order->status,
                    'status_label' => $order->status_label
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error updating order status:', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error updating order status: ' . $e->getMessage()
            ], 500);
        }
    }
}
