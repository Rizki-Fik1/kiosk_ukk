<?php

namespace App\Services;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;
use Exception;

class PurchaseService
{
    /**
     * Create a purchase with Items.
     */
    public function createPurchase(array $data): Purchase
    {
        // 1. Validate items dulu
        $this->validatePurchaseItems($data['items']);

        // 2. Database transaction untuk data consistency
        return DB::transaction(function () use ($data) {
            // Create purchase header
            $purchase = Purchase::create([
                'supplier_name' => $data['supplier_name'],
                'purchase_date' => $data['purchase_date'],
                'total_amount' => 0 // Akan dihitung nanti
            ]);

            $totalAmount = 0;

            // Create purchase items dan update stock
            foreach ($data['items'] as $item) {
                $product = Product::find($item['product_id']);
                $subtotal = $item['quantity'] * $item['cost_price'];

                // Create purchase item
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'cost_price' => $item['cost_price'],
                    'subtotal' => $subtotal
                ]);

                // Update stock product
                $product->updateStock($item['quantity'], 'increase');

                $totalAmount += $subtotal;
            }

            // Update total purchase
            $purchase->update(['total_amount' => $totalAmount]);

            return $purchase;
        });
    }

    /**
     * Validate purchase Items.
     */
    public function validatePurchaseItems(array $items): bool
    {
        if (empty($items)) {
            throw new Exception('Items tidak boleh kosong');
        }

        foreach ($items as $item) {
            // Cek required fields
            if (!isset($item['product_id']) || !isset($item['quantity']) || !isset($item['cost_price'])) {
                throw new Exception('Data item tidak lengkap');
            }

            // Cek product exists
            $product = Product::find($item['product_id']);
            if (!$product) {
                throw new Exception("Product dengan ID {$item['product_id']} tidak ditemukan");
            }

            // Cek product active
            if (!$product->is_active) {
                throw new Exception("Product {$product->name} sudah tidak aktif");
            }

            // Cek quantity valid
            if ($item['quantity'] <= 0) {
                throw new Exception('Quantity harus lebih dari 0');
            }

            // Cek cost_price valid
            if ($item['cost_price'] <= 0) {
                throw new Exception('Harga modal harus lebih dari 0');
            }
        }

        return true;
    }

    /**
     * Calculate Total Purchase.
     */
    public function calculatePurchaseTotal(Purchase $purchase): float
    {
        return $purchase->purchaseItems()->sum('subtotal');
    }

    /**
     * Update Stock for All Items.
     */
    public function updateProductStock(array $items): void
    {
        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $product->updateStock($item['quantity'], 'increase');
            }
        }
    }

    /**
     * Delete Purchase and Rollback Stock.
     */
    public function deletePurchase(Purchase $purchase): bool
    {
        return DB::transaction(function () use ($purchase) {
            // 1. Rollback stock dulu
            $this->rollbackProductStock($purchase);

            // 2. Delete purchase (akan cascade delete purchase_items juga)
            $purchase->delete();

            return true;
        });
    }

    /**
     * Rollback All Items Stock
     */
    public function rollbackProductStock(Purchase $purchase): void
    {
        // Load purchase items dengan product relationship
        $purchase->load('purchaseItems.product');

        foreach ($purchase->purchaseItems as $item) {
            if ($item->product) {
                // Kurangi stock yang sudah ditambah sebelumnya
                $item->product->updateStock($item->quantity, 'decrease');
            }
        }
    }

    /**
     * Get Purchase Statistics
     */
    public function getPurchaseStats(): array
    {
        return [
            'total_purchases' => Purchase::count(),
            'total_amount' => Purchase::sum('total_amount'),
            'total_items' => PurchaseItem::sum('quantity'),
            'unique_products' => PurchaseItem::distinct('product_id')->count(),
        ];
    }

    /**
     * Get Low Stock Products (Helper method)
     */
    public function getLowStockProducts(int $threshold = 10): array
    {
        return Product::where('stock', '<', $threshold)
            ->where('is_active', true)
            ->get()
            ->toArray();
    }
}
