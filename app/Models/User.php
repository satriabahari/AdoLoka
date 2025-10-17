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

class User extends Authenticatable implements FilamentUser, HasName, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'password',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function umkm()
    {
        return $this->hasOne(Umkm::class);
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

    public function canAccessPanel(Panel $panel): bool
    {
        return true; // atur sesuai kebijakanmu
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
}
