<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function createOrder(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Check stock
        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi'
            ], 400);
        }

        // Generate unique order ID
        $orderId = 'ORDER-' . strtoupper(Str::random(10));

        // Calculate total
        $totalAmount = $product->price * $request->quantity;

        // Create order
        $order = Order::create([
            'order_id' => $orderId,
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price,
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        // Prepare transaction details for Midtrans
        $transactionDetails = [
            'order_id' => $order->order_id,
            'gross_amount' => (int) $totalAmount,
        ];

        $itemDetails = [
            [
                'id' => $product->id,
                'price' => (int) $product->price,
                'quantity' => $request->quantity,
                'name' => $product->name,
            ]
        ];

        $customerDetails = [
            'first_name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'phone' => Auth::user()->phone ?? '08123456789',
        ];

        $transaction = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
        ];

        try {
            // Get Snap Token from Midtrans
            $snapToken = Snap::getSnapToken($transaction);

            // Save snap token to order
            $order->update(['snap_token' => $snapToken]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $order->order_id,
            ]);
        } catch (\Exception $e) {
            // Delete order if failed to get snap token
            $order->delete();

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $order = Order::where('order_id', $request->order_id)->first();

            if ($order) {
                // Update order status based on transaction status
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    $order->update([
                        'status' => 'paid',
                        'payment_type' => $request->payment_type,
                        'paid_at' => now(),
                        'midtrans_response' => json_encode($request->all()),
                    ]);

                    // Update product stock
                    $product = $order->product;
                    $product->decrement('stock', $order->quantity);
                } elseif ($request->transaction_status == 'pending') {
                    $order->update([
                        'status' => 'pending',
                        'midtrans_response' => json_encode($request->all()),
                    ]);
                } elseif ($request->transaction_status == 'deny' || $request->transaction_status == 'expire' || $request->transaction_status == 'cancel') {
                    $order->update([
                        'status' => 'failed',
                        'midtrans_response' => json_encode($request->all()),
                    ]);
                }
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function success(Request $request)
    {
        $orderId = $request->order_id;
        $order = Order::where('order_id', $orderId)->with('product')->first();

        return view('orders.success', compact('order'));
    }

    public function pending(Request $request)
    {
        $orderId = $request->order_id;
        $order = Order::where('order_id', $orderId)->with('product')->first();

        return view('orders.pending', compact('order'));
    }

    public function failed(Request $request)
    {
        $orderId = $request->order_id;
        $order = Order::where('order_id', $orderId)->with('product')->first();

        return view('orders.failed', compact('order'));
    }
}
