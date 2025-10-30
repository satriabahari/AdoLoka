<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAndUmkmCategory extends Model
{
    protected $fillable = ['name', 'slug'];

    public function events()
    {
        return $this->belongsToMany(
            Event::class,
            'category_event',
            'category_id',   // foreignPivotKey di pivot yg mengacu ke kategori
            'event_id'       // relatedPivotKey di pivot yg mengacu ke event
        );
    }

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }
}
