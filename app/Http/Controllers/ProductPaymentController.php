<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PhpParser\Error;

class ProductPaymentController extends Controller
{
    public function createPayment(Request $request, Product $product)
    {
        try {
            // Validasi input - hanya notes yang required dari form
            $validated = $request->validate([
                'quantity' => 'required|integer|min:1|max:' . $product->stock,
                'notes' => 'nullable|string|max:1000',
            ]);

            // Ambil data user yang sedang login
            $user = Auth::user();

            // Validasi user harus punya data lengkap
            if (!$user->name || !$user->email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil Anda belum lengkap. Silakan lengkapi data profil terlebih dahulu.'
                ], 400);
            }

            // Cek stok
            if ($product->stock < $validated['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi'
                ], 400);
            }

            DB::beginTransaction();

            // Generate order number & midtrans order ID
            $orderNumber = 'PRD-' . strtoupper(Str::random(8)) . '-' . time();
            $midtransOrderId = 'MIDPRD-' . time() . '-' . $user->id;

            $pricePerUnit = (float) $product->price;
            $totalAmount = $pricePerUnit * $validated['quantity'];

            // Buat order dengan data dari user
            $order = ProductOrder::create([
                'order_number' => $orderNumber,
                'midtrans_order_id' => $midtransOrderId,
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'price_per_unit' => $pricePerUnit,
                'total_amount' => $totalAmount,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->phone ?? '08000000000', // fallback jika phone null
                'notes' => $validated['notes'],
                'payment_status' => 'pending',
            ]);

            // Kurangi stok
            $product->decrement('stock', $validated['quantity']);

            // Konfigurasi Midtrans
            \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
            \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            // Parameter transaksi untuk Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $midtransOrderId,
                    'gross_amount' => (int) $totalAmount,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? '08000000000',
                ],
                'item_details' => [
                    [
                        'id' => $product->id,
                        'price' => (int) $pricePerUnit,
                        'quantity' => $validated['quantity'],
                        'name' => $product->name,
                    ]
                ],
                'callbacks' => [
                    'finish' => route('products.payment.status', $order->order_number),
                ]
            ];

            // Dapatkan Snap Token
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Update snap token
            $order->update(['snap_token' => $snapToken]);

            DB::commit();

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $order->order_number, // Kirim order_number, bukan midtrans_order_id
            ]);
        } catch (Error $e) {
            DB::rollBack();
            Log::error('Midtrans Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat transaksi pembayaran: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function paymentStatus($orderNumber)
    {
        $order = ProductOrder::where('order_number', $orderNumber)
            ->with(['product', 'user'])
            ->firstOrFail();

        return view('products.payment-status', compact('order'));
    }

    public function handleNotification(Request $request)
    {
        try {
            \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
            \Midtrans\Config::$isProduction = config('services.midtrans.is_production');

            $notification = new \Midtrans\Notification();

            $transactionStatus = $notification->transaction_status;
            $paymentType = $notification->payment_type;
            $orderId = $notification->order_id;
            $fraudStatus = $notification->fraud_status ?? null;

            Log::info('Midtrans Notification', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'payment_type' => $paymentType,
                'fraud_status' => $fraudStatus
            ]);

            // Cari order berdasarkan midtrans_order_id
            $order = ProductOrder::where('midtrans_order_id', $orderId)->first();

            if (!$order) {
                Log::error('Order not found: ' . $orderId);
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Update payment_type
            $order->payment_type = $paymentType;
            $order->midtrans_response = $notification->getResponse();

            // Handle berbagai status transaksi
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $order->payment_status = 'paid';
                    $order->paid_at = now();
                }
            } elseif ($transactionStatus == 'settlement') {
                $order->payment_status = 'paid';
                $order->paid_at = now();
            } elseif ($transactionStatus == 'pending') {
                $order->payment_status = 'pending';
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $order->payment_status = 'failed';

                // Kembalikan stok jika pembayaran gagal
                $order->product->increment('stock', $order->quantity);
            }

            $order->save();

            return response()->json(['message' => 'Notification handled']);
        } catch (\Exception $e) {
            Log::error('Notification Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error'], 500);
        }
    }
}
