<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $fillable = [
        'customer_id',
        'pickup_time',
        'total_price',
        'current_status',
        'payment_method',
        'qr_reference',
        'expires_at',
    ];

    protected $casts = [
        'pickup_time' => 'datetime',
        'expires_at' => 'datetime',
        'total_price' => 'decimal:2',
    ];

    // === RELATIONSHIPS ===

    /**
     * Transaction belongs to a customer
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Transaction has many items
     */
    public function items(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }

    /**
     * Transaction has many status history
     */
    public function statusHistory(): HasMany
    {
        return $this->hasMany(TransactionStatus::class);
    }

    // === BUSINESS LOGIC METHODS ===

    /**
     * Check if transaction is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at && now()->isAfter($this->expires_at);
    }

    /**
     * Check if transaction is pending payment
     */
    public function isPending(): bool
    {
        return $this->current_status === 'pending';
    }

    /**
     * Check if transaction is paid
     */
    public function isPaid(): bool
    {
        return in_array($this->current_status, ['paid', 'ready', 'completed']);
    }

    /**
     * Check if transaction can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->current_status, ['pending', 'paid']);
    }

    /**
     * Update transaction status
     */
    public function updateStatus(string $newStatus, int $updatedBy, ?string $notes = null): void
    {
        $oldStatus = $this->current_status;
        
        $this->update(['current_status' => $newStatus]);
        
        $this->statusHistory()->create([
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'updated_by' => $updatedBy,
            'notes' => $notes,
        ]);
    }

    /**
     * Calculate total from items
     */
    public function calculateTotal(): float
    {
        return $this->items()->sum('subtotal');
    }
}
