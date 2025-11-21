<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OtpVerification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'phone',
        'otp_code',
        'expires_at',
        'verified_at',
        'attempts',
        'purpose',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'verified_at' => 'datetime',
            'attempts' => 'integer',
        ];
    }

    /**
     * Generate a new OTP code
     */
    public static function generateOtp(): string
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Create a new OTP verification record
     */
    public static function createForPhone(string $phone, string $purpose = 'verification'): self
    {
        // Delete any existing unverified OTP for this phone
        self::where('phone', $phone)
            ->whereNull('verified_at')
            ->delete();

        return self::create([
            'phone' => $phone,
            'otp_code' => self::generateOtp(),
            'expires_at' => now()->addMinutes(5), // OTP expires in 5 minutes
            'purpose' => $purpose,
            'attempts' => 0,
        ]);
    }

    /**
     * Check if OTP is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check if OTP is verified
     */
    public function isVerified(): bool
    {
        return !is_null($this->verified_at);
    }

    /**
     * Check if OTP has exceeded maximum attempts
     */
    public function hasExceededAttempts(): bool
    {
        return $this->attempts >= 3;
    }

    /**
     * Increment verification attempts
     */
    public function incrementAttempts(): void
    {
        $this->increment('attempts');
    }

    /**
     * Mark OTP as verified
     */
    public function markAsVerified(): void
    {
        $this->verified_at = now();
        $this->save();
    }

    /**
     * Verify OTP code
     */
    public function verify(string $code): bool
    {
        if ($this->isExpired()) {
            return false;
        }

        if ($this->isVerified()) {
            return false;
        }

        if ($this->hasExceededAttempts()) {
            return false;
        }

        $this->incrementAttempts();

        if ($this->otp_code === $code) {
            $this->markAsVerified();
            return true;
        }

        return false;
    }

    /**
     * Get customer associated with this OTP
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'phone', 'phone');
    }

    /**
     * Scope for active (non-expired, non-verified) OTPs
     */
    public function scopeActive($query)
    {
        return $query->whereNull('verified_at')
                    ->where('expires_at', '>', now());
    }

    /**
     * Scope for expired OTPs
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    /**
     * Scope for verified OTPs
     */
    public function scopeVerified($query)
    {
        return $query->whereNotNull('verified_at');
    }
}