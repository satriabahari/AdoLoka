<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    protected $fillable = [
        'product_id',
        'image_path',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessor untuk menampilkan URL gambar lengkap
    // public function getImageUrlAttribute()
    // {
    //     return asset('storage/' . $this->image_path);
    // }
}
