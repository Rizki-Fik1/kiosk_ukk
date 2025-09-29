<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockAdjustment extends Model
{
    protected $table = 'stock_adjustment'; // Sesuai nama tabel di migration

    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'reason',
        'created_by',
    ];

    // === RELATIONSHIPS ===

    /**
     * Stock adjustment untuk produk tertentu
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Stock adjustment dibuat oleh user tertentu
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // === BUSINESS LOGIC METHODS ===

    /**
     * Apply adjustment ke stok produk
     */
    public function applyAdjustment(): bool
    {
        return $this->product->updateStock($this->quantity, $this->type);
    }

    /**
     * Auto apply adjustment saat model dibuat
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($adjustment) {
            $adjustment->applyAdjustment();
        });
    }
}