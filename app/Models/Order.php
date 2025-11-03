<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'transaction_id',
        'user_id',
        'purchasable_type',
        'purchasable_id',
        'item_name',
        'unit_price',
        'quantity',
        'gross_amount',
        'status',
        'snap_token',
        'payment_type',
        'paid_at',
        'meta',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'unit_price' => 'decimal:2',
        'gross_amount' => 'decimal:2',
        'meta' => 'array',
    ];

    // === RELATIONS ===

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi polimorfik ke Product atau Service
     */
    public function purchasable()
    {
        return $this->morphTo();
    }

    // === ACCESSORS ===

    public function getFormattedGrossAmountAttribute()
    {
        return 'Rp ' . number_format((float) $this->gross_amount, 0, ',', '.');
    }

    public function getFormattedUnitPriceAttribute()
    {
        return 'Rp ' . number_format((float) $this->unit_price, 0, ',', '.');
    }

    public function getCustomerNameAttribute()
    {
        return $this->meta['customer_name'] ?? null;
    }

    public function getCustomerEmailAttribute()
    {
        return $this->meta['customer_email'] ?? null;
    }

    public function getCustomerPhoneAttribute()
    {
        return $this->meta['customer_phone'] ?? null;
    }

    public function getNotesAttribute()
    {
        return $this->meta['notes'] ?? null;
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'waiting_payment' => 'Menunggu Pembayaran',
            'paid' => 'Dibayar',
            'expired' => 'Kadaluarsa',
            'failed' => 'Gagal',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'waiting_payment' => 'yellow',
            'paid' => 'green',
            'expired' => 'gray',
            'failed' => 'red',
            default => 'gray',
        };
    }

    public function getItemTypeAttribute()
    {
        return $this->purchasable_type === Product::class ? 'Produk' : 'Layanan';
    }

    // === SCOPES ===

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeWaitingPayment($query)
    {
        return $query->where('status', 'waiting_payment');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
