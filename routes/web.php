<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::prefix('app')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // Purchases & Transfers placeholders
    Route::get('/purchases', function () {
        return view('purchases.index');
    })->name('purchases.index');

    Route::get('/transfers', function () {
        return view('transfers.index');
    })->name('transfers.index');
});
