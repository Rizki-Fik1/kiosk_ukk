<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseItem extends Model
{
    protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'cost_price',
        'subtotal',
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // === RELATIONSHIPS ===

    /**
     * Purchase item milik purchase tertentu
     */
    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    /**
     * Purchase item untuk produk tertentu
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // === BUSINESS LOGIC METHODS ===

    /**
     * Hitung subtotal (quantity × cost_price)
     */
    public function calculateSubtotal(): float
    {
        return $this->quantity * $this->cost_price;
    }

    /**
     * Auto calculate subtotal saat model di-save
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($purchaseItem) {
            $purchaseItem->subtotal = $purchaseItem->calculateSubtotal();
        });
    }
}