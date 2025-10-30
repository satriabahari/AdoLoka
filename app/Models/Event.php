<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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
        'is_strategic_location',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_strategic_location' => 'boolean',
    ];

    // === RELATIONSHIPS ===
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function categories()
    {
        return $this->belongsToMany(
            EventAndUmkmCategory::class,
            'category_event',    // nama tabel pivot
            'event_id',          // foreignPivotKey: kolom yg mengacu ke events
            'category_id'        // relatedPivotKey: kolom yg mengacu ke event_and_umkm_categories
        );
    }

    // Gunakan slug untuk route model binding
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // === MEDIA LIBRARY ===
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('event')
            ->useFallbackUrl(asset('images/placeholder.png'))
            ->singleFile();
    }

    public function getImageUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('event');
    }

    // === SCOPES ===
    public function scopeUpcoming($query, $from = null)
    {
        $from = ($from ?? now('Asia/Jakarta'))->startOfDay();

        return $query
            // tampilkan yang belum berakhir (termasuk yang sedang berlangsung)
            ->whereDate('end_date', '>=', $from)
            ->orderBy('start_date', 'asc');
    }

    public function scopeOngoing($query, $on = null)
    {
        $on = ($on ?? now('Asia/Jakarta'))->toDateString();

        return $query
            ->whereDate('start_date', '<=', $on)
            ->whereDate('end_date', '>=', $on);
    }

    public function scopeCategories($query, array|string $cats)
    {
        $cats = is_array($cats) ? $cats : [$cats];
        return $query->whereHas('categories', function ($q) use ($cats) {
            $slugs = array_map(fn($c) => Str::slug($c), $cats);
            $q->whereIn('slug', $slugs)->orWhereIn('name', $cats);
        });
    }


    // === ACCESSOR ===
    public function getDateRangeAttribute(): string
    {
        $start = $this->start_date;
        $end   = $this->end_date;

        if (!$start || !$end) return '';

        // Sama hari
        if ($start->isSameDay($end)) {
            return $start->translatedFormat('d F Y');
        }

        // Sama bulan & tahun → "12–14 Oktober 2025"
        if ($start->isSameMonth($end) && $start->isSameYear($end)) {
            return $start->translatedFormat('d') . '–' . $end->translatedFormat('d F Y');
        }

        // Beda bulan atau tahun → "30 Sep 2025 – 02 Okt 2025"
        return $start->translatedFormat('d M Y') . ' – ' . $end->translatedFormat('d M Y');
    }
}
