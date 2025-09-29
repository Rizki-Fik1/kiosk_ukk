<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name', 
        'description', 
        'price', 
        'stock', 
        'is_active',
        'image', 
        'image_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // === RELATIONSHIPS ===
    
    /**
     * Product bisa dibeli berkali-kali dari supplier
     */
    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    /**
     * Product bisa dijual berkali-kali ke customer
     */
    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * Product bisa di-adjust stoknya berkali-kali
     */
    public function stockAdjustments(): HasMany
    {
        return $this->hasMany(StockAdjustment::class);
    }

    // === BUSINESS LOGIC METHODS ===

    /**
     * Update stok produk
     */
    public function updateStock(int $quantity, string $type): bool
    {
        if ($type === 'increase') {
            $this->increment('stock', $quantity);
        } elseif ($type === 'decrease') {
            if ($this->stock >= $quantity) {
                $this->decrement('stock', $quantity);
            } else {
                return false; // Stok tidak cukup
            }
        }
        
        return true;
    }

    /**
     * Cek apakah stok cukup untuk dijual
     */
    public function canSell(int $quantity): bool
    {
        return $this->stock >= $quantity && $this->is_active;
    }

    /**
     * Cek apakah stok sudah menipis (kurang dari 10)
     */
    public function isLowStock(): bool
    {
        return $this->stock < 10;
    }

    /**
     * Hitung rata-rata harga modal dari pembelian
     */
    public function getAverageCostPrice(): float
    {
        $avgCost = $this->purchaseItems()
            ->selectRaw('AVG(cost_price) as avg_cost')
            ->value('avg_cost');
            
        return $avgCost ? (float) $avgCost : 0;
    }

    /**
     * Total quantity yang pernah dijual
     */
    public function getTotalSold(): int
    {
        return $this->saleItems()->sum('quantity');
    }

    /**
     * Total quantity yang pernah dibeli dari supplier
     */
    public function getTotalPurchased(): int
    {
        return $this->purchaseItems()->sum('quantity');
    }
}
