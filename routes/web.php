<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AdjustmentController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\ReportController;

// kalau akses root, redirect ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// route auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// language switcher
Route::get('/lang/{locale}', function ($locale) {
    session(['app_locale' => in_array($locale, ['en','id']) ? $locale : 'en']);
    return back();
})->name('lang.switch');

// semua route di bawah butuh login
Route::middleware('auth')->prefix('app')->group(function () {
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // products
    Route::resource('products', ProductController::class);
    Route::get('/products/{product}/barcode', [ProductController::class, 'barcode'])->name('products.barcode');
    Route::get('/products/{product}/labels', [ProductController::class, 'labels'])->name('products.labels');

    // warehouses
    Route::resource('warehouses', WarehouseController::class);
    Route::get('/warehouses/{warehouse}/stock', [WarehouseController::class, 'stock'])->name('warehouses.stock');

    // purchases
    Route::resource('purchases', PurchaseController::class);
    Route::get('/purchases/{purchase}/invoice', [PurchaseController::class, 'invoice'])->name('purchases.invoice');

    // adjustments
    Route::resource('adjustments', AdjustmentController::class);
    Route::get('/adjustments/product-search', [AdjustmentController::class, 'productSearch'])->name('adjustments.productSearch');



    // transfers
    Route::resource('transfers', TransferController::class);

    // reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/purchases', [ReportController::class, 'purchases'])->name('reports.purchases');
    Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
    Route::get('/reports/adjustments', [ReportController::class, 'adjustments'])->name('reports.adjustments');
    Route::get('/reports/warehouse', [ReportController::class, 'warehouse'])->name('reports.warehouse');
    Route::get('/reports/export/purchases', [ReportController::class, 'exportPurchases'])->name('reports.exportPurchases');
    Route::get('/reports/export/stock', [ReportController::class, 'exportStock'])->name('reports.exportStock');
});
