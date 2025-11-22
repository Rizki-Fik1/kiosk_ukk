<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionItem extends Model
{
    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'price',
        'subtotal',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // === RELATIONSHIPS ===

    /**
     * Item belongs to a transaction
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Item belongs to a product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // === BUSINESS LOGIC METHODS ===

    /**
     * Calculate subtotal (quantity * price)
     */
    public function calculateSubtotal(): float
    {
        return $this->quantity * $this->price;
    }

    /**
     * Get product name
     */
    public function getProductName(): string
    {
        return $this->product->name ?? 'Unknown Product';
    }
}
