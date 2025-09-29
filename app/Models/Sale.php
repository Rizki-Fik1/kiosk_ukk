<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'total_amount',
        'payment_method',
        'status',
        'midtrans_order_id',
        'sale_date',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'sale_date' => 'date',
    ];

    // === RELATIONSHIPS ===

    /**
     * Sale dibuat oleh user tertentu (admin/kiosk)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 1 sale punya banyak sale items
     */
    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    // === BUSINESS LOGIC METHODS ===

    /**
     * Hitung total amount dari semua items
     */
    public function calculateTotal(): float
    {
        return $this->saleItems()->sum('subtotal');
    }

    /**
     * Tambah item ke sale ini
     */
    public function addItem(Product $product, int $quantity, float $price): SaleItem|false
    {
        // Cek stok dulu
        if (!$product->canSell($quantity)) {
            return false;
        }

        $subtotal = $quantity * $price;

        $saleItem = $this->saleItems()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $price,
            'subtotal' => $subtotal,
        ]);

        // Update total amount sale
        $this->update(['total_amount' => $this->calculateTotal()]);

        return $saleItem;
    }

    /**
     * Complete sale - kurangi stok dan update status
     */
    public function completeSale(): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }

        // Kurangi stok untuk setiap item
        foreach ($this->saleItems as $item) {
            if (!$item->product->updateStock($item->quantity, 'decrease')) {
                return false; // Gagal update stok
            }
        }

        // Update status jadi paid
        $this->update(['status' => 'paid']);

        return true;
    }

    /**
     * Cek apakah sale bisa di-refund
     */
    public function canRefund(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Process refund - kembalikan stok dan update status
     */
    public function processRefund(): bool
    {
        if (!$this->canRefund()) {
            return false;
        }

        // Kembalikan stok untuk setiap item
        foreach ($this->saleItems as $item) {
            $item->product->updateStock($item->quantity, 'increase');
        }

        // Update status jadi refunded
        $this->update(['status' => 'refunded']);

        return true;
    }
}