<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'date_of_birth',
        'phone_verified_at',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
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
            'phone_verified_at' => 'datetime',
            'date_of_birth' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Check if customer's phone is verified
     */
    public function isPhoneVerified(): bool
    {
        return !is_null($this->phone_verified_at);
    }

    /**
     * Mark phone as verified
     */
    public function markPhoneAsVerified(): void
    {
        $this->phone_verified_at = now();
        $this->save();
    }

    /**
     * Check if customer is active
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Get customer's OTP verifications
     */
    public function otpVerifications()
    {
        return $this->hasMany(OtpVerification::class, 'phone', 'phone');
    }

    /**
     * Get the latest OTP verification for this customer
     */
    public function latestOtpVerification()
    {
        return $this->hasOne(OtpVerification::class, 'phone', 'phone')
                    ->latest('created_at');
    }

    /**
     * Check if customer can request new OTP (rate limiting)
     */
    public function canRequestOtp(): bool
    {
        $latestOtp = $this->latestOtpVerification;
        
        if (!$latestOtp) {
            return true;
        }

        // Allow new OTP if last one was created more than 1 minute ago
        return $latestOtp->created_at->addMinute()->isPast();
    }

    /**
     * Get customer's age
     */
    public function getAgeAttribute(): ?int
    {
        if (!$this->date_of_birth) {
            return null;
        }

        return $this->date_of_birth->age;
    }

    /**
     * Scope for verified customers
     */
    public function scopeVerified($query)
    {
        return $query->whereNotNull('phone_verified_at');
    }

    /**
     * Scope for unverified customers
     */
    public function scopeUnverified($query)
    {
        return $query->whereNull('phone_verified_at');
    }

    /**
     * Scope for active customers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for inactive customers
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }
}