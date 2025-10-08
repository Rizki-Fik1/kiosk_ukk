<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
// SaleController will be replaced with OrderController
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// API Routes for Mobile App will be added in api.php


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Products (existing pattern)
    Route::get('/admin/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('products.store');
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

    // Orders (Admin Management) - Will be implemented in Task 4
    // Route::get('/admin/orders', [OrderController::class, 'index'])->name('orders.index');
    // Route::get('/admin/customers', [CustomerController::class, 'index'])->name('customers.index');
});


require __DIR__.'/auth.php';
