<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    protected $fillable = [
        'supplier_name',
        'total_amount',
        'purchase_date',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'purchase_date' => 'date',
    ];

    // === RELATIONSHIPS ===

    /**
     * 1 purchase punya banyak purchase items
     */
    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    // === BUSINESS LOGIC METHODS ===

    /**
     * Hitung total amount dari semua items
     */
    public function calculateTotal(): float
    {
        return $this->purchaseItems()->sum('subtotal');
    }

    /**
     * Tambah item ke purchase ini
     */
    public function addItem(Product $product, int $quantity, float $costPrice): PurchaseItem
    {
        $subtotal = $quantity * $costPrice;

        $purchaseItem = $this->purchaseItems()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'cost_price' => $costPrice,
            'subtotal' => $subtotal,
        ]);

        // Update stok produk
        $product->updateStock($quantity, 'increase');

        // Update total amount purchase
        $this->update(['total_amount' => $this->calculateTotal()]);

        return $purchaseItem;
    }
}