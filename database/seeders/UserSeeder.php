<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user (pemilik toko)
        User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@toko.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Kiosk user (untuk device kiosk)
        User::create([
            'name' => 'Kiosk Device',
            'email' => 'kiosk@toko.com',
            'password' => Hash::make('kiosk123'),
            'role' => 'kiosk',
        ]);
    }
}
