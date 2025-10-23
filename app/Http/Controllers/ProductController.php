<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductCategory;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = ProductCategory::withCount('products')->get();

        $query = Product::with(['category', 'umkm'])
            ->where('is_active', true)
            ->where('stock', '>', 0);

        // Filter by category if provided
        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $products = $query->orderBy('created_at', 'desc')->get();

        return view('products', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'umkm']);

        if (!$product->is_active) {
            abort(404);
        }

        return view('product-detail', compact('product'));
    }

    public function createPayment(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'notes' => 'nullable|string|max:500',
        ], [
            'customer_name.required' => 'Nama lengkap harus diisi',
            'customer_email.required' => 'Email harus diisi',
            'customer_email.email' => 'Format email tidak valid',
            'customer_phone.required' => 'Nomor WhatsApp harus diisi',
            'quantity.max' => 'Jumlah melebihi stok yang tersedia',
        ]);

        // Check stock availability
        if ($product->stock < $validated['quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi'
            ], 400);
        }

        try {
            // Configure Midtrans
            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production');
            Config::$isSanitized = config('services.midtrans.is_sanitized');
            Config::$is3ds = config('services.midtrans.is_3ds');

            // Generate order number
            $orderNumber = 'PROD-' . strtoupper(Str::random(10));

            // Calculate total
            $pricePerUnit = $product->price;
            $totalPrice = $pricePerUnit * $validated['quantity'];

            // Create order in database
            $order = ProductOrder::create([
                'order_number' => $orderNumber,
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'quantity' => $validated['quantity'],
                'price_per_unit' => $pricePerUnit,
                'total_price' => $totalPrice,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'notes' => $validated['notes'] ?? null,
                'payment_status' => 'pending',
            ]);

            // Prepare transaction details for Midtrans
            $transactionDetails = [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $totalPrice,
            ];

            $itemDetails = [
                [
                    'id' => $product->id,
                    'price' => (int) $pricePerUnit,
                    'quantity' => $validated['quantity'],
                    'name' => $product->name,
                ]
            ];

            $customerDetails = [
                'first_name' => $validated['customer_name'],
                'email' => $validated['customer_email'],
                'phone' => $validated['customer_phone'],
            ];

            $params = [
                'transaction_details' => $transactionDetails,
                'item_details' => $itemDetails,
                'customer_details' => $customerDetails,
                'enabled_payments' => [
                    'credit_card',
                    'gopay',
                    'shopeepay',
                    'other_qris',
                    'bca_va',
                    'bni_va',
                    'bri_va',
                    'permata_va',
                    'other_va',
                    'indomaret',
                    'alfamart'
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            // Update order with snap token
            $order->update(['snap_token' => $snapToken]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $order->order_number,
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans Payment Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function paymentStatus($orderNumber)
    {
        $order = ProductOrder::where('order_number', $orderNumber)
            ->with(['product.category', 'product.umkm'])
            ->firstOrFail();

        return view('components.product-payment-status', compact('order'));
    }

    public function paymentCallback(Request $request)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');

        try {
            $notification = new \Midtrans\Notification();

            $orderNumber = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status ?? null;

            $order = ProductOrder::where('order_number', $orderNumber)->firstOrFail();

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $order->update([
                        'payment_status' => 'paid',
                        'paid_at' => now(),
                    ]);
                    // Reduce stock
                    $order->product->decrement('stock', $order->quantity);
                }
            } elseif ($transactionStatus == 'settlement') {
                $order->update([
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                ]);
                // Reduce stock
                $order->product->decrement('stock', $order->quantity);
            } elseif ($transactionStatus == 'pending') {
                $order->update(['payment_status' => 'pending']);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $order->update(['payment_status' => 'failed']);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Midtrans Callback Error: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }
}
