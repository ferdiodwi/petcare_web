<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Get all orders
     */
    public function index(Request $request)
    {
        try {
            $query = Order::with(['items.product']);

            // Filter berdasarkan customer_name jika diperlukan
            if ($request->has('customer_name') && $request->customer_name) {
                $query->where('customer_name', 'like', '%' . $request->customer_name . '%');
            }

            // Filter berdasarkan status jika diperlukan
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            // Urutkan berdasarkan tanggal terbaru
            $orders = $query->orderBy('created_at', 'desc')->get();

            // Transform data untuk response
            $ordersData = $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'customer_name' => $order->customer_name,
                    'address' => $order->address,
                    'total_amount' => $order->total_amount,
                    'status' => $order->status,
                    'payment_proof_path' => $order->payment_proof_path,
                    'created_at' => $order->created_at->toDateTimeString(),
                    'updated_at' => $order->updated_at->toDateTimeString(),
                    'items' => $order->items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'product_id' => $item->product_id,
                            'product_name' => $item->product->name ?? 'N/A',
                            'quantity' => $item->quantity,
                            'price_at_purchase' => $item->price_at_purchase,
                        ];
                    }),
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Orders retrieved successfully',
                'orders' => $ordersData
            ], 200);

        } catch (\Exception $e) {
            Log::error('Failed to retrieve orders:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve orders',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single order by ID
     */
    public function show($id)
    {
        try {
            $order = Order::with(['items.product'])->find($id);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            $orderData = [
                'id' => $order->id,
                'customer_name' => $order->customer_name,
                'address' => $order->address,
                'total_amount' => $order->total_amount,
                'status' => $order->status,
                'payment_proof_path' => $order->payment_proof_path,
                'created_at' => $order->created_at->toDateTimeString(),
                'updated_at' => $order->updated_at->toDateTimeString(),
                'items' => $order->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name ?? 'N/A',
                        'quantity' => $item->quantity,
                        'price_at_purchase' => $item->price_at_purchase,
                    ];
                }),
            ];

            return response()->json([
                'success' => true,
                'message' => 'Order retrieved successfully',
                'order' => $orderData
            ], 200);

        } catch (\Exception $e) {
            Log::error('Failed to retrieve order:', ['error' => $e->getMessage(), 'order_id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:pending,paid,processing,shipped,completed,canceled'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $order = Order::find($id);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            $order->update([
                'status' => $request->status
            ]);

            Log::info('Order status updated:', [
                'order_id' => $order->id,
                'old_status' => $order->getOriginal('status'),
                'new_status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
                'order' => [
                    'id' => $order->id,
                    'status' => $order->status,
                    'updated_at' => $order->updated_at->toDateTimeString()
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Failed to update order status:', [
                'error' => $e->getMessage(),
                'order_id' => $id
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        Log::info('Order request received:', $request->all());

        $validator = Validator::make($request->all(), [
            'cartItems' => 'required|json', // String JSON dari cartItems
            'address' => 'required|string|max:1000',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // File gambar
        ]);

        if ($validator->fails()) {
            Log::error('Order validation failed:', $validator->errors()->toArray());
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cartItems = json_decode($request->input('cartItems'), true); // Decode string JSON
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($cartItems)) {
             Log::error('CartItems JSON decoding error or not an array');
             return response()->json(['error' => 'Invalid cartItems format.'], 400);
        }


        DB::beginTransaction();
        try {
            $totalAmount = 0;
            foreach ($cartItems as $item) {
                $product = Product::find($item['id'] ?? ($item['product_id'] ?? null)); // Cek 'id' atau 'product_id'
                if (!$product) {
                    DB::rollBack();
                    Log::error('Product not found for item:', $item);
                    return response()->json(['error' => 'Product not found: ' . ($item['name'] ?? 'Unknown')], 404);
                }
                // Validasi harga jika perlu, atau ambil harga terbaru dari DB
                // $totalAmount += $product->price * $item['quantity']; // Gunakan harga dari DB
                $totalAmount += (float) $item['price'] * (int) $item['quantity']; // Gunakan harga dari cart (sesuai Flutter)
            }

            $paymentProofPath = null;
            if ($request->hasFile('payment_proof')) {
                $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
            }

            $order = Order::create([
                'customer_name' => $request->input('customer_name', 'Guest User'), // Ambil dari request atau default
                'address' => $request->input('address'),
                'total_amount' => $totalAmount,
                'status' => 'pending', // Status awal
                'payment_proof_path' => $paymentProofPath,
            ]);

            foreach ($cartItems as $item) {
                $product = Product::find($item['id'] ?? ($item['product_id'] ?? null));
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price_at_purchase' => $item['price'], // Harga dari cart saat itu
                ]);

                // Kurangi stok produk jika perlu
                // $product->decrement('stock', $item['quantity']);
            }

            DB::commit();
            Log::info('Order created successfully:', ['order_id' => $order->id]);
            return response()->json(['message' => 'Order created successfully!', 'order_id' => $order->id], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Failed to create order. ' . $e->getMessage()], 500);
        }
    }
}
