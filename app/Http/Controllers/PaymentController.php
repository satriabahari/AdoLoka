<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production', false);
        Config::$isSanitized  = (bool) config('services.midtrans.is_sanitized', true);
        Config::$is3ds        = (bool) config('services.midtrans.is_3ds', true);
    }

    /**
     * Create order untuk Product atau Service (UNIFIED)
     */
    public function createOrder(Request $request, string $type, int $id)
    {
        try {
            // Validasi type
            if (!in_array($type, ['product', 'service'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid type'
                ], 400);
            }

            // Ambil item (Product atau Service)
            $item = $type === 'product'
                ? Product::findOrFail($id)
                : Service::findOrFail($id);

            // Validasi request
            $validated = $request->validate([
                'quantity' => 'required|integer|min:1',
                'customer_name' => 'nullable|string|max:255',
                'customer_email' => 'nullable|email|max:255',
                'customer_phone' => 'nullable|string|max:20',
                'notes' => 'nullable|string|max:1000',
            ]);

            // Cek status aktif
            if (!$item->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => $type === 'product' ? 'Produk tidak tersedia' : 'Layanan tidak tersedia'
                ], 400);
            }

            // Cek stok untuk product
            if ($type === 'product' && $item->stock < $validated['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi'
                ], 400);
            }

            $quantity = (int) $validated['quantity'];
            $unitPrice = (int) $item->price;
            $grossAmount = $unitPrice * $quantity;

            // Get customer info
            $user = Auth::user();
            $customerName = $validated['customer_name']
                ?? ($user ? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) : null)
                ?? ($user->email ?? 'Guest');
            $customerEmail = $validated['customer_email'] ?? ($user->email ?? null);
            $customerPhone = $validated['customer_phone'] ?? ($user->phone_number ?? null);

            // Validasi customer info untuk service (wajib)
            if ($type === 'service') {
                if (!$customerName || !$customerEmail || !$customerPhone) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Informasi customer harus lengkap untuk pemesanan layanan',
                        'errors' => [
                            'customer_name' => !$customerName ? ['Nama harus diisi'] : null,
                            'customer_email' => !$customerEmail ? ['Email harus diisi'] : null,
                            'customer_phone' => !$customerPhone ? ['Nomor telepon harus diisi'] : null,
                        ]
                    ], 422);
                }
            }

            // Generate order number & transaction ID
            $orderNumber = 'INV-' . strtoupper(Str::random(10));
            $transactionId = 'TRX-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(6));

            // Buat meta data
            $meta = [
                'notes' => $validated['notes'] ?? null,
                'customer_name' => $customerName,
                'customer_email' => $customerEmail,
                'customer_phone' => $customerPhone,
            ];

            // Simpan order
            $order = DB::transaction(function () use (
                $orderNumber,
                $transactionId,
                $type,
                $item,
                $quantity,
                $unitPrice,
                $grossAmount,
                $meta
            ) {
                return Order::create([
                    'order_number' => $orderNumber,
                    'transaction_id' => $transactionId,
                    'user_id' => Auth::id() ?? null,
                    'purchasable_type' => $type === 'product' ? Product::class : Service::class,
                    'purchasable_id' => $item->id,
                    'item_name' => $item->name,
                    'unit_price' => $unitPrice,
                    'quantity' => $quantity,
                    'gross_amount' => $grossAmount,
                    'status' => 'waiting_payment',
                    'meta' => json_encode($meta),
                ]);
            });

            // Siapkan payload Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $order->transaction_id,
                    'gross_amount' => (int) $grossAmount,
                ],
                'customer_details' => [
                    'first_name' => $meta['customer_name'],
                    'email' => $meta['customer_email'],
                    'phone' => $meta['customer_phone'],
                ],
                'item_details' => [[
                    'id' => (string) $item->id,
                    'price' => (int) $unitPrice,
                    'quantity' => (int) $quantity,
                    'name' => mb_strimwidth($item->name, 0, 50, '…'),
                ]],
            ];

            // Ambil Snap Token
            $snapToken = Snap::getSnapToken($params);

            // Update snap token
            $order->update(['snap_token' => $snapToken]);

            Log::info('Order created successfully', [
                'order_number' => $orderNumber,
                'transaction_id' => $transactionId,
                'type' => $type,
                'amount' => $grossAmount
            ]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_number' => $order->order_number,
                'message' => 'Order berhasil dibuat',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Payment createOrder error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle Midtrans Notification (FIXED - Menggunakan Midtrans\Notification)
     */
    public function notification(Request $request)
    {
        try {
            Log::info('=== MIDTRANS NOTIFICATION RECEIVED ===');
            Log::info('Raw Payload:', $request->all());

            // Gunakan Midtrans\Notification sesuai dokumentasi resmi
            $notif = new Notification();

            // Ambil data dari notification object
            $transactionStatus = $notif->transaction_status;
            $paymentType = $notif->payment_type;
            $orderId = $notif->order_id;
            $fraudStatus = $notif->fraud_status;

            Log::info('Parsed Notification:', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'payment_type' => $paymentType,
                'fraud_status' => $fraudStatus,
            ]);

            // Cari order berdasarkan transaction_id
            $order = Order::where('transaction_id', $orderId)->first();

            if (!$order) {
                Log::warning('Order not found', ['order_id' => $orderId]);
                return response()->json(['status' => 'order-not-found'], 404);
            }

            Log::info('Order found:', [
                'order_number' => $order->order_number,
                'current_status' => $order->status
            ]);

            // Idempotent check: jika sudah final, skip
            if (in_array($order->status, ['paid', 'expired', 'failed'], true)) {
                Log::info('Order already in final state, skipping', [
                    'order_id' => $orderId,
                    'status' => $order->status
                ]);
                return response()->json(['status' => 'already-processed'], 200);
            }

            // Proses status pembayaran sesuai dokumentasi Midtrans
            DB::transaction(function () use ($order, $transactionStatus, $paymentType, $fraudStatus, $orderId) {

                // CAPTURE (Credit Card)
                if ($transactionStatus == 'capture') {
                    if ($paymentType == 'credit_card') {
                        if ($fraudStatus == 'accept') {
                            $this->markAsPaid($order, $paymentType);
                            Log::info("✅ Transaction $orderId successfully captured using $paymentType");
                        } else {
                            $order->update([
                                'status' => 'failed',
                                'payment_type' => $paymentType,
                            ]);
                            Log::warning("❌ Transaction $orderId fraud status: $fraudStatus");
                        }
                    }
                }
                // SETTLEMENT (Transfer Bank, E-Wallet, dll)
                else if ($transactionStatus == 'settlement') {
                    $this->markAsPaid($order, $paymentType);
                    Log::info("✅ Transaction $orderId successfully settled using $paymentType");
                }
                // PENDING
                else if ($transactionStatus == 'pending') {
                    $order->update([
                        'status' => 'waiting_payment',
                        'payment_type' => $paymentType,
                    ]);
                    Log::info("⏳ Transaction $orderId is pending using $paymentType");
                }
                // DENY
                else if ($transactionStatus == 'deny') {
                    $order->update([
                        'status' => 'failed',
                        'payment_type' => $paymentType,
                    ]);
                    Log::warning("❌ Transaction $orderId is denied using $paymentType");
                }
                // EXPIRE
                else if ($transactionStatus == 'expire') {
                    $order->update([
                        'status' => 'expired',
                        'payment_type' => $paymentType,
                    ]);
                    Log::info("⏰ Transaction $orderId is expired using $paymentType");
                }
                // CANCEL
                else if ($transactionStatus == 'cancel') {
                    $order->update([
                        'status' => 'failed',
                        'payment_type' => $paymentType,
                    ]);
                    Log::info("🚫 Transaction $orderId is canceled using $paymentType");
                }
                // UNKNOWN STATUS
                else {
                    Log::warning("⚠️ Unknown transaction status: $transactionStatus for order $orderId");
                }
            });

            Log::info('=== NOTIFICATION PROCESSED SUCCESSFULLY ===', [
                'order_id' => $orderId,
                'final_status' => $order->fresh()->status
            ]);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            Log::error('=== MIDTRANS NOTIFICATION ERROR ===');
            Log::error('Error Message: ' . $e->getMessage());
            Log::error('Stack Trace: ' . $e->getTraceAsString());
            Log::error('Request Data: ' . json_encode($request->all()));

            // Tetap return 200 agar Midtrans tidak retry berlebihan
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 200);
        }
    }

    /**
     * Mark order as paid dan kurangi stok
     */
    private function markAsPaid(Order $order, string $paymentType): void
    {
        $order->update([
            'status' => 'paid',
            'payment_type' => $paymentType,
            'paid_at' => now(),
        ]);

        // Kurangi stok untuk product
        if ($order->purchasable_type === Product::class) {
            $product = Product::find($order->purchasable_id);
            if ($product) {
                $product->decrement('stock', $order->quantity);
                Log::info('✅ Stock decremented', [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity_sold' => $order->quantity,
                    'remaining_stock' => $product->fresh()->stock
                ]);
            }
        }

        Log::info('💰 Order marked as PAID', [
            'order_number' => $order->order_number,
            'order_id' => $order->transaction_id,
            'payment_type' => $paymentType,
            'amount' => $order->gross_amount
        ]);
    }

    /**
     * Halaman status pembayaran
     */
    public function status($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['purchasable'])
            ->firstOrFail();

        return view('components.status', compact('order'));
    }

    /**
     * Check payment status via Midtrans API (untuk debugging)
     */
    public function checkStatus($orderNumber)
    {
        try {
            $order = Order::where('order_number', $orderNumber)->firstOrFail();

            // Query status ke Midtrans
            $status = \Midtrans\Transaction::status($order->transaction_id);

            Log::info('Manual status check:', [
                'order_number' => $orderNumber,
                'transaction_id' => $order->transaction_id,
                'midtrans_response' => json_decode(json_encode($status), true)
            ]);

            return response()->json([
                'success' => true,
                'order_number' => $order->order_number,
                'order_status' => $order->status,
                'midtrans_status' => $status,
            ]);
        } catch (\Exception $e) {
            Log::error('Check status error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
