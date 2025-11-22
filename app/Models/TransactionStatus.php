<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionStatus extends Model
{
    protected $table = 'transaction_status';

    protected $fillable = [
        'transaction_id',
        'old_status',
        'new_status',
        'updated_by',
        'notes',
    ];

    // === RELATIONSHIPS ===

    /**
     * Status belongs to a transaction
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Status updated by a user (admin/kiosk)
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // === BUSINESS LOGIC METHODS ===

    /**
     * Get status change description
     */
    public function getStatusChangeDescription(): string
    {
        return "{$this->old_status} → {$this->new_status}";
    }

    /**
     * Get updater name
     */
    public function getUpdaterName(): string
    {
        return $this->updatedBy->name ?? 'System';
    }
}
