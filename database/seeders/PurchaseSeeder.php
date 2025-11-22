<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\Product;
use Carbon\Carbon;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            'PT Sumber Makmur',
            'CV Jaya Abadi',
            'Toko Grosir Sejahtera',
            'PT Indo Distribusi',
            'CV Mitra Usaha',
            'Toko Grosir Berkah',
            'PT Cahaya Terang',
            'CV Sukses Bersama'
        ];

        // Get all products
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->warn('No products found. Please run ProductSeeder first.');
            return;
        }

        // Generate 30 purchases over the last 3 months
        for ($i = 0; $i < 30; $i++) {
            $purchaseDate = Carbon::now()->subDays(rand(0, 90));
            $supplier = $suppliers[array_rand($suppliers)];

            // Create purchase
            $purchase = Purchase::create([
                'supplier_name' => $supplier,
                'purchase_date' => $purchaseDate,
                'total_amount' => 0, // Will be calculated
            ]);

            // Add 2-5 random items to each purchase
            $itemCount = rand(2, 5);
            $selectedProducts = $products->random($itemCount);

            foreach ($selectedProducts as $product) {
                $quantity = rand(10, 100);
                // Use 70-90% of selling price as cost price (realistic margin)
                $costPrice = $product->price * rand(70, 90) / 100;

                $purchase->addItem($product, $quantity, $costPrice);
            }

            $this->command->info("Created purchase #{$purchase->id} from {$supplier} with {$itemCount} items");
        }

        $this->command->info('Purchase seeding completed!');
    }
}
