<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ─── Role Helpers ──────────────────────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function isPenjaga(): bool
    {
        return $this->role === 'penjaga';
    }

    public function stand()
    {
        return $this->belongsTo(\App\Models\Stand::class);
    }

    public function favorits()
    {
        return $this->hasMany(Favorit::class);
    }

    public function hasFavorit(int $produkId): bool
    {
        return $this->favorits()->where('produk_id', $produkId)->exists();
    }

    public function passwordResetRequests()
    {
        return $this->hasMany(PasswordResetRequest::class);
    }

    public function notifications()
    {
        return $this->hasMany(UserNotification::class)->orderByDesc('created_at');
    }

    public function unreadNotificationsCount(): int
    {
        return $this->notifications()->where('is_read', false)->count();
    }
}
