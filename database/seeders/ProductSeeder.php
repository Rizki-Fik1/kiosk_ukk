<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Indomie Goreng',
            'price' => 3500,
            'stock' => 100,
            'image' => null,
        ]);

        Product::create([
            'name' => 'Aqua Botol 600ml',
            'price' => 5000,
            'stock' => 50,
            'image' => null,
        ]);
    }
}