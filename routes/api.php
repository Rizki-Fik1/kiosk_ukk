<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes (no authentication required)
Route::prefix('auth')->group(function () {
    Route::post('send-otp', [AuthController::class, 'sendOtp']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

// Protected routes (authentication required)
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'profile']);
        Route::put('profile', [AuthController::class, 'updateProfile']);
        Route::post('change-phone', [AuthController::class, 'changePhone']);
        Route::post('verify-new-phone', [AuthController::class, 'verifyNewPhone']);
    });

    // Customer routes
    Route::prefix('customers')->group(function () {
        // Customer self-management
        Route::get('profile', [CustomerController::class, 'profile']);
        Route::put('profile', [CustomerController::class, 'updateProfile']);
        
        // Admin only routes
        Route::middleware('admin')->group(function () {
            Route::get('/', [CustomerController::class, 'index']); // List all customers
            Route::get('statistics', [CustomerController::class, 'statistics']); // Customer stats
            Route::get('{id}', [CustomerController::class, 'show']); // Show specific customer
            Route::put('{id}', [CustomerController::class, 'update']); // Update customer
            Route::delete('{id}', [CustomerController::class, 'destroy']); // Soft delete
            Route::post('{id}/restore', [CustomerController::class, 'restore']); // Restore deleted
            Route::patch('{id}/toggle-status', [CustomerController::class, 'toggleStatus']); // Toggle active status
        });
    });
});

// Fallback route for API
Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'API endpoint not found'
    ], 404);
});