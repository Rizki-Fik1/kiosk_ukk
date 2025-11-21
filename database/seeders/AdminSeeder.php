<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@kiosk.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create sample kiosk user (kasir)
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@kiosk.com',
            'password' => Hash::make('password'),
            'role' => 'kiosk',
            'email_verified_at' => now(),
        ]);
    }
}
