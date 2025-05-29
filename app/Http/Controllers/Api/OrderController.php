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
