<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Indomie Goreng',
                'description' => 'Mie instan rasa goreng original',
                'price' => 3000,
                'stock' => 100,
                'min_stock' => 20,
                'is_active' => true,
                'image' => 'https://picsum.photos/seed/indomie/300/300',
            ],
            [
                'name' => 'Teh Botol Sosro',
                'description' => 'Minuman teh dalam kemasan botol',
                'price' => 4000,
                'stock' => 50,
                'min_stock' => 10,
                'is_active' => true,
                'image' => 'https://picsum.photos/seed/teh/300/300',
            ],
            [
                'name' => 'Aqua 600ml',
                'description' => 'Air mineral dalam kemasan',
                'price' => 3500,
                'stock' => 8,
                'min_stock' => 15,
                'is_active' => true,
                'image' => 'https://picsum.photos/seed/aqua/300/300',
            ],
            [
                'name' => 'Minyak Goreng Bimoli 1L',
                'description' => 'Minyak goreng kemasan 1 liter',
                'price' => 18000,
                'stock' => 25,
                'min_stock' => 5,
                'is_active' => true,
                'image' => 'https://picsum.photos/seed/minyak/300/300',
            ],
            [
                'name' => 'Gula Pasir 1kg',
                'description' => 'Gula pasir kemasan 1 kilogram',
                'price' => 15000,
                'stock' => 30,
                'min_stock' => 10,
                'is_active' => true,
                'image' => 'https://picsum.photos/seed/gula/300/300',
            ],
            [
                'name' => 'Beras Premium 5kg',
                'description' => 'Beras premium kualitas terbaik',
                'price' => 65000,
                'stock' => 5,
                'min_stock' => 3,
                'is_active' => true,
                'image' => 'https://picsum.photos/seed/beras/300/300',
            ],
            [
                'name' => 'Telur Ayam 1kg',
                'description' => 'Telur ayam segar per kilogram',
                'price' => 28000,
                'stock' => 15,
                'min_stock' => 5,
                'is_active' => true,
                'image' => 'https://picsum.photos/seed/telur/300/300',
            ],
            [
                'name' => 'Susu Ultra Milk 1L',
                'description' => 'Susu UHT rasa plain',
                'price' => 18000,
                'stock' => 20,
                'min_stock' => 10,
                'is_active' => true,
                'image' => 'https://picsum.photos/seed/susu/300/300',
            ],
            [
                'name' => 'Kopi Kapal Api',
                'description' => 'Kopi bubuk sachet',
                'price' => 2000,
                'stock' => 150,
                'min_stock' => 30,
                'is_active' => true,
                'image' => 'https://picsum.photos/seed/kopi/300/300',
            ],
            [
                'name' => 'Sabun Mandi Lifebuoy',
                'description' => 'Sabun mandi batangan',
                'price' => 5000,
                'stock' => 40,
                'min_stock' => 10,
                'is_active' => true,
                'image' => 'https://picsum.photos/seed/sabun/300/300',
            ],
            [
                'name' => 'Shampo Pantene 170ml',
                'description' => 'Shampo perawatan rambut',
                'price' => 22000,
                'stock' => 3,
                'min_stock' => 5,
                'is_active' => true,
                'image' => 'https://picsum.photos/seed/shampo/300/300',
            ],
            [
                'name' => 'Pasta Gigi Pepsodent',
                'description' => 'Pasta gigi keluarga',
                'price' => 8000,
                'stock' => 25,
                'min_stock' => 10,
                'is_active' => true,
                'image' => 'https://picsum.photos/seed/pasta/300/300',
            ],
            [
                'name' => 'Detergen Rinso 800g',
                'description' => 'Detergen bubuk untuk mencuci',
                'price' => 15000,
                'stock' => 18,
                'min_stock' => 8,
                'is_active' => true,
                'image' => 'https://picsum.photos/seed/detergen/300/300',
            ],
            [
                'name' => 'Tissue Paseo',
                'description' => 'Tissue wajah lembut',
                'price' => 12000,
                'stock' => 30,
                'min_stock' => 10,
                'is_active' => true,
                'image' => 'https://picsum.photos/seed/tissue/300/300',
            ],
            [
                'name' => 'Roti Tawar Sari Roti',
                'description' => 'Roti tawar untuk sarapan',
                'price' => 13000,
                'stock' => 2,
                'min_stock' => 5,
                'is_active' => false, // Inactive product
                'image' => null, // No image untuk test "No image" state
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
