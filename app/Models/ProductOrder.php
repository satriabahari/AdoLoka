<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    protected $fillable = [
        'order_number',         // human-readable, untuk URL/status page
        'midtrans_order_id',    // ID yang dikirim ke Midtrans
        'product_id',
        'user_id',
        'quantity',
        'price_per_unit',
        'total_amount',         // <- ganti dari total_price
        'customer_name',
        'customer_email',
        'customer_phone',
        'notes',
        'payment_status',       // pending|paid|failed|expired
        'payment_type',         // qris|gopay|va|cc|...
        'snap_token',
        'paid_at',
        'midtrans_response',    // JSON payload terakhir dari Midtrans
    ];

    protected $casts = [
        'price_per_unit'    => 'decimal:2',
        'total_amount'      => 'decimal:2',
        'paid_at'           => 'datetime',
        'midtrans_response' => 'array',
    ];

    // Relasi
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* =========================
     * Back-compat accessors
     * ========================= */

    // Agar $order->total_price tetap berfungsi (mapping ke total_amount)
    public function getTotalPriceAttribute()
    {
        return $this->total_amount;
    }

    // Agar $order->formatted_total_price tetap tersedia di Blade
    public function getFormattedTotalPriceAttribute()
    {
        return 'Rp ' . number_format((float) $this->total_amount, 0, ',', '.');
    }

    /* =========================
     * Helper opsional
     * ========================= */

    // Total human-readable satuan + qty (jika butuh di view)
    public function getLinePriceLabelAttribute()
    {
        return sprintf(
            '%s × %d',
            'Rp ' . number_format((float) $this->price_per_unit, 0, ',', '.'),
            (int) $this->quantity
        );
    }

    // Scope kecil kalau mau query order yang belum final
    public function scopeActive($q)
    {
        return $q->whereNotIn('payment_status', ['paid', 'failed', 'expired']);
    }
}
