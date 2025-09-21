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
use Illuminate\Support\Facades\Schema;

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
    session(['app_locale' => in_array($locale, ['en', 'id']) ? $locale : 'en']);
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

    // products - specific routes first before resource
    Route::get('/products/labels', function () {
        try {
            $products = DB::table('products')
                ->leftJoin('product_warehouse', 'product_warehouse.product_id', '=', 'products.id')
                ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                ->leftJoin('brands', 'brands.id', '=', 'products.brand_id')
                ->leftJoin('units', 'units.id', '=', 'products.unit_id')
                ->select(
                    'products.id',
                    'products.name',
                    'products.code',
                    'products.price',
                    DB::raw('COALESCE(SUM(product_warehouse.qte), 0) as stock'),
                    'categories.name as category_name',
                    'brands.name as brand_name',
                    'units.name as unit_name'
                )
                ->groupBy('products.id', 'products.name', 'products.code', 'products.price', 'categories.name', 'brands.name', 'units.name')
                ->orderBy('products.name')
                ->get();

            // Add default values for missing fields
            $products = $products->map(function ($product) {
                return (object) [
                    'id' => $product->id,
                    'name' => $product->name ?? 'Unknown Product',
                    'code' => $product->code ?? 'N/A',
                    'sku' => $product->code ?? 'N/A',
                    'price' => $product->price ?? 0,
                    'stock' => $product->stock ?? 0,
                    'category_name' => $product->category_name ?? 'General',
                    'brand_name' => $product->brand_name ?? 'No Brand',
                    'unit_name' => $product->unit_name ?? 'pcs'
                ];
            });

            return view('products.labels-standalone', compact('products'));
        } catch (\Exception $e) {
            \Log::error('Labels route error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    })->name('products.labels');

    Route::get('/products/stock-count', function () {
        try {
            $products = DB::table('products')
                ->leftJoin('product_warehouse', 'product_warehouse.product_id', '=', 'products.id')
                ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                ->leftJoin('brands', 'brands.id', '=', 'products.brand_id')
                ->leftJoin('units', 'units.id', '=', 'products.unit_id')
                ->select(
                    'products.id',
                    'products.name',
                    'products.code',
                    'products.price',
                    DB::raw('COALESCE(SUM(product_warehouse.qte), 0) as stock'),
                    'categories.name as category_name',
                    'brands.name as brand_name',
                    'units.name as unit_name'
                )
                ->groupBy('products.id', 'products.name', 'products.code', 'products.price', 'categories.name', 'brands.name', 'units.name')
                ->orderBy('products.name')
                ->get();

            return view('products.stock-count', compact('products'));
        } catch (\Exception $e) {
            \Log::error('Stock count route error: ' . $e->getMessage());
            return view('products.stock-count', ['products' => collect([])]);
        }
    })->name('products.stock_count');

    Route::get('/products/export/pdf', [ProductController::class, 'exportPdf'])->name('products.export.pdf');
    Route::get('/products/export/excel', [ProductController::class, 'exportExcel'])->name('products.export.excel');
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::post('/products/approve', [ProductController::class, 'approve'])->name('products.approve');
    Route::post('/products/{id}/approve', [ProductController::class, 'approve'])->name('products.approve');
    Route::post('/products/{id}/reject', [ProductController::class, 'reject'])->name('products.reject');
    Route::post('/products/approve-pending', [ProductController::class, 'approvePending'])->name('products.approve-pending');
    Route::post('/products/reject-pending', [ProductController::class, 'rejectPending'])->name('products.reject-pending');
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
    Route::get('/products/{product}/barcode', [ProductController::class, 'barcode'])->name('products.barcode');

    // products resource route (must be last)
    Route::resource('products', ProductController::class);
    // brands
    Route::resource('brands', BrandController::class);

    // warehouses
    Route::resource('warehouses', WarehouseController::class);
    Route::get('/warehouses/{warehouse}/stock', [WarehouseController::class, 'stock'])->name('warehouses.stock');

    // purchases
    // purchases
    Route::resource('purchases', PurchaseController::class);

    Route::get('/purchases/{purchase}/invoice', [PurchaseController::class, 'invoice'])->name('purchases.invoice');
    Route::get('/purchases/{purchase}/print', [PurchaseController::class, 'print'])->name('purchases.print');

    Route::get('/reports/purchases', [ReportController::class, 'purchases'])->name('reports.purchases');

    Route::get('/reports/export/purchases', [ReportController::class, 'exportPurchases'])->name('reports.exportPurchases');

    // categories
    Route::resource('categories', CategoryController::class);
    // units
    Route::resource('units', UnitController::class);

    // tags (simple AJAX route for creating tags)
    Route::post('/tags/ajax-create', function (\Illuminate\Http\Request $request) {
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

    Route::get('/transfers/product-search', [TransferController::class, 'productSearch'])->name('transfers.productSearch');

    // transfers
       Route::resource('transfers', TransferController::class);
       Route::get('/transfers/search/product', [TransferController::class, 'searchProduct']);
       Route::get('/transfers/{transfer}/print', [TransferController::class, 'print'])->name('transfers.print');
       Route::get('/transfers/{transfer}/invoice', [TransferController::class, 'invoice'])->name('transfers.invoice');
});
