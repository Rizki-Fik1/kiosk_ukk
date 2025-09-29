<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

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

    // === RELATIONSHIPS ===

    /**
     * User bisa punya banyak sales (sebagai kasir/admin)
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * User bisa punya banyak stock adjustments (yang dia buat)
     */
    public function stockAdjustments()
    {
        return $this->hasMany(StockAdjustment::class, 'created_by');
    }

    // === BUSINESS LOGIC METHODS ===

    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah kiosk
     */
    public function isKiosk(): bool
    {
        return $this->role === 'kiosk';
    }
}
