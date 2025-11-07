<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements FilamentUser, HasName, HasAvatar, HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, InteractsWithMedia;

    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'about',
        'phone_number',
        'google_id',
        'email',
        'password',
        'role_id'
        // 'phone',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function umkm()
    {
        return $this->hasOne(Umkm::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hasRole(string $roleName): bool
    {
        return $this->role && $this->role->name === $roleName;
    }

    /**
     * Check if user is admin (role_id = 1)
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role_id === self::ROLE_ADMIN;
    }

    /**
     * Check if user is regular user (role_id = 2)
     *
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->role_id === self::ROLE_USER;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }

    // 👇 Wajib return string (bukan null)
    public function getFilamentName(): string
    {
        // dukung skema 'first_name' atau 'firstname'
        $first = $this->first_name ?? $this->firstname ?? '';
        $last  = $this->last_name  ?? $this->lastname  ?? '';

        $full = trim($first . ' ' . $last);

        // fallback supaya TIDAK PERNAH null/kosong
        return $full !== '' ? $full : ($this->email ?? 'User');
    }

    // (opsional) avatar
    public function getFilamentAvatarUrl(): ?string
    {
        $name = $this->getFilamentName();
        return 'https://ui-avatars.com/api/?name=' . urlencode($name);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('user')
            ->useFallbackUrl(asset('images/avatar-profile.png'))
            ->singleFile();
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('user') ?: asset('images/avatar-profile.png');
    }
}
