<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AdjustmentController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\StockCountController;

// kalau akses root, redirect ke dashboard
Route::get('/', function () {
    return 'Welcome to Inventory System!';
});

// Test routes outside middleware
Route::get('/test-labels', function() {
    return '<h1>Print Labels Test</h1><p>Route is working!</p>';
});

Route::get('/test-stock-count', function() {
    return '<h1>Count Stock Test</h1><p>Route is working!</p>';
});

Route::get('/test-view', function() {
    return view('label-print.index', ['products' => collect([])]);
});

Route::get('/test-stock-view', function() {
    return view('stock-count.index', ['products' => collect([])]);
});

Route::get('/test-labels-simple', function() {
    return view('products.labels', ['products' => collect([])]);
});

Route::get('/test-stock-simple', function() {
    return view('products.stock-count', ['products' => collect([])]);
});

Route::get('/labels-test', function() {
    return '<h1>Print Labels Test (No Auth)</h1><p>This should work without authentication!</p>';
});

Route::get('/stock-test', function() {
    return '<h1>Count Stock Test (No Auth)</h1><p>This should work without authentication!</p>';
});

// Simple test routes
Route::get('/test', function () {
    return 'Test route working!';
});

Route::get('/dashboard', function () {
    return 'Dashboard working!';
});

Route::get('/app/dashboard', function () {
    return 'App Dashboard working!';
});

// Test routes outside middleware
Route::get('/test-pdf', function() {
    return 'PDF Test Route Working';
});
Route::get('/test-excel', function() {
    return 'Excel Test Route Working';
});
Route::get('/test-purchases-pdf', function() {
    return 'Purchases PDF Test Working';
});
Route::get('/test-purchases-excel', function() {
    return 'Purchases Excel Test Working';
});

// Simple export routes outside middleware
Route::get('/export-pdf', function() {
    return 'PDF Export Working';
});
Route::get('/export-excel', function() {
    return 'Excel Export Working';
});

// Test routes for products outside middleware
Route::get('/test-labels', function() {
    return response()->json(['message' => 'Test Labels Working!']);
});
Route::get('/test-stock-count', function() {
    return response()->json(['message' => 'Test Stock Count Working!']);
});

// Products routes outside middleware for testing
Route::get('/products-labels', function() {
    return response()->json(['message' => 'Products Labels Working!']);
});
Route::get('/products-stock-count', function() {
    return response()->json(['message' => 'Products Stock Count Working!']);
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

    // pos
    Route::get('/pos', function () {
        return view('pos.index');
    })->name('pos.index');

    // profile
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile.index');

    // settings
    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings.index');

    // products
    Route::resource('products', ProductController::class);
    // brands
    Route::resource('brands', BrandController::class);
    Route::get('/products/export/pdf', [ProductController::class, 'exportPdf'])->name('products.export.pdf');
    Route::get('/products/export/excel', [ProductController::class, 'exportExcel'])->name('products.export.excel');
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::post('/products/approve', [ProductController::class, 'approve'])->name('products.approve');
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
    Route::get('/products/{product}/barcode', [ProductController::class, 'barcode'])->name('products.barcode');
    Route::get('/products/labels', function() {
        return '<h1>Print Labels Page</h1><p>Route is working!</p><a href="/app/products">Back to Products</a>';
    })->name('products.labels');
    
    Route::get('/products/stock-count', function() {
        return '<h1>Count Stock Page</h1><p>Route is working!</p><a href="/app/products">Back to Products</a>';
    })->name('products.stock_count');

    // warehouses
    Route::resource('warehouses', WarehouseController::class);
    Route::get('/warehouses/{warehouse}/stock', [WarehouseController::class, 'stock'])->name('warehouses.stock');

    // purchases
    Route::resource('purchases', PurchaseController::class);
    Route::get('/purchases/{purchase}/invoice', [PurchaseController::class, 'invoice'])->name('purchases.invoice');
    Route::get('/purchases/{purchase}/print', [PurchaseController::class, 'print'])->name('purchases.print');
    Route::get('/purchases/{purchase}/pdf', [PurchaseController::class, 'exportPurchasePdf'])->name('purchases.pdf');
    
    // Export routes
    Route::get('/purchases-export-pdf', function() {
        return 'PDF Export Working';
    })->name('purchases.export.pdf');
    Route::get('/purchases-export-excel', function() {
        return 'Excel Export Working';
    })->name('purchases.export.excel');
    
    // categories
    Route::resource('categories', CategoryController::class);
    // units
    Route::resource('units', UnitController::class);
    
    // tags (simple AJAX route for creating tags)
    Route::post('/tags/ajax-create', function(\Illuminate\Http\Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:7'
        ]);
        
        $tagId = DB::table('tags')->insertGetId([
            'name' => $request->name,
            'color' => $request->color ?? '#3B82F6',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'tag' => [
                'id' => $tagId,
                'name' => $request->name,
                'color' => $request->color ?? '#3B82F6'
            ]
        ]);
    })->name('tags.ajax-create');
    
    // reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/purchases', [ReportController::class, 'purchases'])->name('reports.purchases');
    Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
    Route::get('/reports/adjustments', [ReportController::class, 'adjustments'])->name('reports.adjustments');
    Route::get('/reports/warehouse', [ReportController::class, 'warehouse'])->name('reports.warehouse');
    Route::get('/reports/export/purchases', [ReportController::class, 'exportPurchases'])->name('reports.exportPurchases');
    Route::get('/reports/export/stock', [ReportController::class, 'exportStock'])->name('reports.exportStock');

    // adjustments
    // NOTE: define specific routes BEFORE resource to avoid conflicts like 'product-search' matching {adjustment}
    Route::get('/adjustments/product-search', [AdjustmentController::class, 'productSearch'])->name('adjustments.productSearch');
    Route::get('/adjustments/product-stock', [AdjustmentController::class, 'productStock'])->name('adjustments.productStock');
    Route::resource('adjustments', AdjustmentController::class);



    // transfers
    Route::resource('transfers', TransferController::class);

});
