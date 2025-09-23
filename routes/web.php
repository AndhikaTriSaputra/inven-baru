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
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\StockCountController;
use Illuminate\Support\Facades\Cache;

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

    // Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/labels', [LabelController::class, 'index'])->name('products.labels');
// Stock Count routes under /app/products/stock-count*
Route::prefix('products')->group(function () {
    Route::resource('stock-count', StockCountController::class);
});

Route::post('/tags/ajax-create', [TagController::class, 'storeAjax'])->name('tags.ajax-create');

Route::post('/products/{id}/approve', [ProductController::class, 'approve'])->name('products.approve');
Route::post('/products/{id}/reject', [ProductController::class, 'reject'])->name('products.reject');
Route::post('/products/approve-pending', [ProductController::class, 'approvePending'])->name('products.approve-pending');
Route::post('/products/reject-pending', [ProductController::class, 'rejectPending'])->name('products.reject-pending');


    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    // Search API for products (AJAX) - MUST come before {id} routes
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('/products/export/pdf', [ProductController::class, 'exportPdf'])->name('products.export.pdf');
    Route::get('/products/export/excel', [ProductController::class, 'exportExcel'])->name('products.export.excel');
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
    
    // Dynamic product routes LAST - after all specific routes
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // brands
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/{brand}', [BrandController::class, 'show'])->name('brands.show');
    Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');

    // units
    Route::get('/units', [UnitController::class, 'index'])->name('units.index');
    Route::get('/units/create', [UnitController::class, 'create'])->name('units.create');
    Route::post('/units', [UnitController::class, 'store'])->name('units.store');
    Route::get('/units/{unit}', [UnitController::class, 'show'])->name('units.show');
    Route::get('/units/{unit}/edit', [UnitController::class, 'edit'])->name('units.edit');
    Route::put('/units/{unit}', [UnitController::class, 'update'])->name('units.update');
    Route::delete('/units/{unit}', [UnitController::class, 'destroy'])->name('units.destroy');

    // warehouses
    Route::resource('warehouses', WarehouseController::class);
    Route::get('/warehouses/{warehouse}/stock', [WarehouseController::class, 'stock'])->name('warehouses.stock');

    // purchases
    Route::resource('purchases', PurchaseController::class);

    Route::get('/purchases/{purchase}/invoice', [PurchaseController::class, 'invoice'])->name('purchases.invoice');
    Route::get('/purchases/{purchase}/print', [PurchaseController::class, 'print'])->name('purchases.print');

    // adjustments - custom endpoints FIRST to avoid clashing with resource {id}
    Route::get('/adjustments/product-search', [AdjustmentController::class, 'productSearch'])->name('adjustments.productSearch');
    Route::get('/adjustments/product-stock', [AdjustmentController::class, 'productStock'])->name('adjustments.productStock');
    Route::resource('adjustments', AdjustmentController::class);

    // transfers - custom search BEFORE resource
    Route::get('/transfers/product-search', [TransferController::class, 'productSearch'])->name('transfers.productSearch');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    
    // Language switching
    Route::get('/language/{locale}', [App\Http\Controllers\LanguageController::class, 'switchLanguage'])->name('language.switch');

    // settings
    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings.index');
    // transfers
    Route::resource('transfers', TransferController::class);
    Route::get('/transfers/search/product', [TransferController::class, 'searchProduct']);
    Route::get('/transfers/{transfer}/print', [TransferController::class, 'print'])->name('transfers.print');
    Route::get('/transfers/{transfer}/invoice', [TransferController::class, 'invoice'])->name('transfers.invoice');


    // reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/purchases', [ReportController::class, 'purchases'])->name('reports.purchases');
    Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
    Route::get('/reports/adjustments', [ReportController::class, 'adjustments'])->name('reports.adjustments');
    Route::get('/reports/warehouse', [ReportController::class, 'warehouse'])->name('reports.warehouse');
    Route::get('/reports/export/purchases', [ReportController::class, 'exportPurchases'])->name('reports.exportPurchases');
    Route::get('/reports/export/stock', [ReportController::class, 'exportStock'])->name('reports.exportStock');

});

