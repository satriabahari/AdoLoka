<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'product_id',
        'quantity',
        'price',
        'total_amount',
        'status',
        'payment_type',
        'snap_token',
        'midtrans_response',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'price' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
