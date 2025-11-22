<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\DashboardController;
// SaleController will be replaced with OrderController
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// API Routes for Mobile App will be added in api.php


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Products (complete CRUD)
    Route::get('/admin/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/admin/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Purchases (same pattern as Products)
    Route::get('/admin/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('/admin/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
    Route::post('/admin/purchases', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('/admin/purchases/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
    Route::get('/admin/purchases/{purchase}/edit', [PurchaseController::class, 'edit'])->name('purchases.edit');
    Route::put('/admin/purchases/{purchase}', [PurchaseController::class, 'update'])->name('purchases.update');
    Route::delete('/admin/purchases/{purchase}', [PurchaseController::class, 'destroy'])->name('purchases.destroy');

    // Coming Soon Pages
    Route::get('/admin/transactions', function () {
        return view('coming-soon', [
            'feature' => 'Transaksi',
            'progress' => 35,
            'features' => [
                'Manajemen order pelanggan',
                'Tracking status transaksi',
                'Pembayaran digital (Midtrans)',
                'Riwayat transaksi lengkap',
                'Laporan penjualan'
            ]
        ]);
    })->name('transactions.index');

    Route::get('/admin/customers', function () {
        return view('coming-soon', [
            'feature' => 'Customer',
            'progress' => 40,
            'features' => [
                'Database pelanggan',
                'Verifikasi OTP',
                'Riwayat pembelian',
                'Loyalty program',
                'Customer analytics'
            ]
        ]);
    })->name('customers.index');

    Route::get('/admin/admins', function () {
        return view('coming-soon', [
            'feature' => 'Admin Management',
            'progress' => 25,
            'features' => [
                'Manajemen user admin',
                'Role & permissions',
                'Activity logs',
                'Access control',
                'Team management'
            ]
        ]);
    })->name('admins.index');

    Route::get('/admin/settings', function () {
        return view('coming-soon', [
            'feature' => 'Pengaturan',
            'progress' => 30,
            'features' => [
                'Konfigurasi toko',
                'Jam operasional',
                'Metode pembayaran',
                'Notifikasi & alerts',
                'Backup & restore'
            ]
        ]);
    })->name('settings.index');
});


require __DIR__.'/auth.php';
