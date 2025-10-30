<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class EventRegistration extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'event_id',
        'event_category_id',
        'umkm_brand_name',
        'partner_address',
        'business_type',
        'owner_name',
        'whatsapp_number',
        'instagram_name',
        'business_license_number',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function eventCategory()
    {
        return $this->belongsTo(EventAndUmkmCategory::class);
    }

    // === MEDIA LIBRARY ===
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('event_registration')
            ->useFallbackUrl(asset('images/placeholder.png'));
    }

    // ---------- Accessors opsional ----------
    public function getBrandPhotoUrlAttribute(): ?string
    {
        return optional(
            $this->getMedia('event_registration')
                ->first(fn($m) => ($m->getCustomProperty('kind') === 'brand'))
        )?->getUrl();
    }

    public function getProductPhotoUrlAttribute(): ?string
    {
        return optional(
            $this->getMedia('event_registration')
                ->first(fn($m) => ($m->getCustomProperty('kind') === 'product'))
        )?->getUrl();
    }

    public function getKtpPhotoUrlAttribute(): ?string
    {
        return optional(
            $this->getMedia('event_registration')
                ->first(fn($m) => ($m->getCustomProperty('kind') === 'ktp'))
        )?->getUrl();
    }
}
