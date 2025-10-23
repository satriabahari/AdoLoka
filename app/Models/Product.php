<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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
        'umkm_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price'     => 'decimal:2',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Auto-generate slug & ensure unique before insert/update.
     */
    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            static::ensureSlug($product);
        });

        // Jika name berubah dan slug belum di-set manual, buat lagi (opsional)
        static::updating(function (Product $product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                static::ensureSlug($product);
            }
        });
    }

    protected static function ensureSlug(Product $product): void
    {
        if (!empty($product->slug)) {
            return;
        }

        $base = Str::slug($product->name);
        $slug = $base;
        $i = 2;

        // Pastikan unik (abaikan diri sendiri kalau update)
        while (static::where('slug', $slug)
            ->when($product->exists, fn($q) => $q->where('id', '!=', $product->id))
            ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        $product->slug = $slug;
    }

    // === MEDIA LIBRARY ===
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('product')
            ->useFallbackUrl(asset('images/placeholder.png'))
            ->singleFile();
    }

    public function getImageUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('product') ?: asset('images/placeholder.png');
    }

    // === RELATIONS ===
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }
}
