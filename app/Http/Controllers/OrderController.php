<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function __construct()
    {
        // Midtrans config
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production', false);
        Config::$isSanitized  = (bool) config('services.midtrans.is_sanitized', true);
        Config::$is3ds        = (bool) config('services.midtrans.is_3ds', true);
    }

    public function createOrder(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity'        => ['required', 'integer', 'min:1'],
            'customer_name'   => ['required', 'string', 'max:150'],
            'customer_email'  => ['required', 'email', 'max:191'],
            'customer_phone'  => ['required', 'string', 'max:30'],
            'notes'           => ['nullable', 'string', 'max:255'],
        ]);

        // Stock check
        if ($product->stock < $data['quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi',
            ], 422);
        }

        // Hitung harga
        $pricePerUnit = (int) $product->price;              // pastikan integer untuk Midtrans
        $totalAmount  = $pricePerUnit * (int) $data['quantity'];

        // Generate ID
        $orderNumber      = 'PROD-' . strtoupper(Str::random(8));                                 // untuk user/URL
        $midtransOrderId  = 'MID-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(6));  // untuk Midtrans

        // Simpan order terlebih dahulu
        $order = ProductOrder::create([
            'order_number'       => $orderNumber,
            'midtrans_order_id'  => $midtransOrderId,
            'user_id'            => Auth::id(), // boleh null kalau guest checkout
            'product_id'         => $product->id,
            'quantity'           => (int) $data['quantity'],
            'price_per_unit'     => $pricePerUnit,
            'total_amount'       => $totalAmount,
            'customer_name'      => $data['customer_name'],
            'customer_email'     => $data['customer_email'],
            'customer_phone'     => $data['customer_phone'],
            'notes'              => $data['notes'] ?? null,
            'payment_status'     => 'pending',
        ]);

        // Siapkan payload Midtrans
        $transaction = [
            'transaction_details' => [
                'order_id'     => $order->midtrans_order_id, // GUNAKAN midtrans_order_id
                'gross_amount' => (int) $totalAmount,
            ],
            'item_details' => [[
                'id'       => (string) $product->id,
                'price'    => (int) $pricePerUnit,
                'quantity' => (int) $order->quantity,
                // batasi panjang nama agar aman
                'name'     => mb_strimwidth($product->name, 0, 50, '…'),
            ]],
            'customer_details' => [
                'first_name' => $order->customer_name,
                'email'      => $order->customer_email,
                'phone'      => $order->customer_phone,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($transaction);
            $order->update(['snap_token' => $snapToken]);

            return response()->json([
                'success'    => true,
                'snap_token' => $snapToken,
                // Frontend kamu pakai ini untuk redirect status page
                'order_id'   => $order->order_number,
            ]);
        } catch (\Throwable $e) {
            // Jika gagal ambil snap token, hapus order agar tidak nyangkut
            $order->delete();

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat transaksi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Endpoint NOTIFICATION/CALLBACK dari Midtrans
     * Pastikan route ini dipakai sebagai "Notification URL" di dashboard Midtrans.
     */
    public function callback(Request $request)
    {
        // Verifikasi signature
        $serverKey = config('services.midtrans.server_key');
        $calcSig   = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        if (!hash_equals($calcSig, (string) $request->signature_key)) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Ambil order berdasarkan midtrans_order_id (bukan order_number)
        $order = ProductOrder::where('midtrans_order_id', $request->order_id)->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Idempotensi: kalau sudah paid/failed, jangan proses ulang
        if (in_array($order->payment_status, ['paid', 'failed'])) {
            // tetap update payload terakhir untuk audit
            $order->update(['midtrans_response' => json_encode($request->all())]);
            return response()->json(['message' => 'Already processed']);
        }

        $txStatus   = $request->transaction_status;  // settlement|capture|pending|deny|expire|cancel|refund|chargeback
        $paymentType = $request->payment_type;

        // Proses atomik: update order & stok sekali jalan
        DB::transaction(function () use ($order, $txStatus, $paymentType, $request) {
            if (in_array($txStatus, ['capture', 'settlement'])) {
                // Untuk kartu kredit, jika ada fraud_status=challenge, idealnya tahan dulu.
                // Versi sederhana: anggap paid ketika capture/settlement.
                $order->update([
                    'payment_status'   => 'paid',
                    'payment_type'     => $paymentType,
                    'paid_at'          => now(),
                    'midtrans_response' => json_encode($request->all()),
                ]);

                // Kurangi stok hanya sekali, saat paid
                $order->product()->decrement('stock', $order->quantity);
            } elseif ($txStatus === 'pending') {
                $order->update([
                    'payment_status'   => 'pending',
                    'payment_type'     => $paymentType,
                    'midtrans_response' => json_encode($request->all()),
                ]);
            } elseif (in_array($txStatus, ['deny', 'expire', 'cancel'])) {
                $order->update([
                    'payment_status'   => 'failed',
                    'payment_type'     => $paymentType,
                    'midtrans_response' => json_encode($request->all()),
                ]);
            } else {
                // status lain (refund/chargeback), simplifikasi -> failed
                $order->update([
                    'payment_status'   => 'failed',
                    'payment_type'     => $paymentType,
                    'midtrans_response' => json_encode($request->all()),
                ]);
            }
        });

        return response()->json(['message' => 'OK']);
    }

    // Halaman hasil (opsional)
    public function success(Request $request)
    {
        // Frontend mengirim order_number (bukan midtrans_order_id)
        $order = ProductOrder::where('order_number', $request->order_id)
            ->with('product')->firstOrFail();

        return view('orders.success', compact('order'));
    }

    public function pending(Request $request)
    {
        $order = ProductOrder::where('order_number', $request->order_id)
            ->with('product')->firstOrFail();

        return view('orders.pending', compact('order'));
    }

    public function failed(Request $request)
    {
        $order = ProductOrder::where('order_number', $request->order_id)
            ->with('product')->firstOrFail();

        return view('orders.failed', compact('order'));
    }
}
