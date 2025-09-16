<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/lang/{locale}', function ($locale) {
    session(['app_locale' => in_array($locale, ['en','id']) ? $locale : 'en']);
    return back();
})->name('lang.switch');

Route::middleware(['auth','lang'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // placeholder menu POS
    Route::view('pos', 'pos.index')->name('pos.index');

    // nanti: resource routes modul Products/Warehouse/Adjustments/Purchases/Transfers/Reports
});
