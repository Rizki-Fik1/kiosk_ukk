<?php

use Illuminate\Support\Facades\Route;

// Only show the coming soon page for public deployment
Route::get('/', function () {
    return view('comingsoon');
})->name('home');

// Redirect all other routes to home
Route::fallback(function () {
    return redirect()->route('home');
});