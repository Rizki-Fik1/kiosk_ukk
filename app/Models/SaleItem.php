<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'price',
        'subtotal',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // === RELATIONSHIPS ===

    /**
     * Sale item milik sale tertentu
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Sale item untuk produk tertentu
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // === BUSINESS LOGIC METHODS ===

    /**
     * Hitung subtotal (quantity × price)
     */
    public function calculateSubtotal(): float
    {
        return $this->quantity * $this->price;
    }

    /**
     * Hitung profit untuk item ini
     */
    public function calculateProfit(): float
    {
        $avgCostPrice = $this->product->getAverageCostPrice();
        $totalCost = $this->quantity * $avgCostPrice;
        $totalRevenue = $this->subtotal;
        
        return $totalRevenue - $totalCost;
    }

    /**
     * Auto calculate subtotal saat model di-save
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($saleItem) {
            $saleItem->subtotal = $saleItem->calculateSubtotal();
        });
    }
}