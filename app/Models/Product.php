<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = [
        'name',
        'description',
        'slug',
        'price',
        'stock',
        'category_id',
        'user_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // protected static function booted()
    // {
    //     // jaga2 kalau slug belum diisi saat create manual
    //     static::creating(function ($product) {
    //         if (empty($product->slug)) {
    //             $slug = Str::slug($product->name);
    //             // unikkan slug jika ada nama duplikat
    //             $base = $slug;
    //             $i = 2;
    //             while (static::where('slug', $slug)->exists()) {
    //                 $slug = $base . '-' . $i++;
    //             }
    //             $product->slug = $slug;
    //         }
    //     });
    // }



    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // === MEDIA LIBRARY ===
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('product')
            ->useFallbackUrl(asset('images/fallback.png'))
            ->singleFile();
    }

    public function getImageUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('product') ?: asset('images/fallback.png');
    }

    // Auto-generate slug bila kosong
    // protected static function booted(): void
    // {
    //     static::creating(function (Product $product) {
    //         if (empty($product->slug)) {
    //             $product->slug = Str::slug($product->name);
    //         }
    //     });

    //     static::updating(function (Product $product) {
    //         if ($product->isDirty('name') && empty($product->slug)) {
    //             $product->slug = Str::slug($product->name);
    //         }
    //     });
    // }

    // Relations
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productimage()
    {
        return $this->hasOne(ProductImages::class);
    }
}
