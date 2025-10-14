<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = [
        'title',
        'slug',
        'description',
        'location',
        'start_date',
        'end_date',
        'type',
        'category',
        'is_strategic_location',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_strategic_location' => 'boolean',
    ];

    // Gunakan slug untuk route model binding
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // === MEDIA LIBRARY ===
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('event')
            ->useFallbackUrl(asset('images/fallback.png'))
            ->singleFile();
    }

    public function getImageUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('event') ?: asset('images/fallback.png');
    }

    // === SCOPES ===
    // ambil event yang tanggal berakhirnya masih di masa depan (belum lewat).
    public function scopeUpcoming($query)
    {
        return $query->whereDate('end_date', '>=', now()->toDateString())
            ->orderBy('start_date');
    }

    // ambil event yang sedang berlangsung hari ini.
    public function scopeOngoing($query)
    {
        $today = now()->toDateString();
        return $query->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today);
    }

    // Ambil event berdasarkan kategori tertentu
    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    // === ACCESSOR TANGGAL ===
    // Jika event 1 hari → tampilkan 23 Desember 2025
    // Jika event rentang tanggal → tampilkan 23 - 30 Desember 2025
    public function getDateRangeAttribute(): string
    {
        $start = $this->start_date;
        $end = $this->end_date;

        if (!$start || !$end) return '';

        return $start->isSameDay($end)
            ? $start->translatedFormat('d F Y')
            : $start->translatedFormat('d') . ' - ' . $end->translatedFormat('d F Y');
    }
}
