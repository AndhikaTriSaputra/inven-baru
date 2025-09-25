<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class StockCountController extends Controller
{
    private function stockCountTable(): string
    {
        if (Schema::hasTable('count_stock')) { return 'count_stock'; }
        if (Schema::hasTable('stock_counts')) { return 'stock_counts'; }
        return '';
    }
    /**
     * Display stock counts list
     */
    public function index(Request $request): View
    {
        // Support both table names
        $table = $this->stockCountTable();
        if ($table === '') {
            $page = (int) $request->query('page', 1);
            $stockCounts = new LengthAwarePaginator(collect(), 0, 10, $page, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);

            $warehouses = Schema::hasTable('warehouses')
                ? DB::table('warehouses')->select('id', 'name')->get()
                : collect();

            return view('products.stock-count', compact('stockCounts', 'warehouses'));
        }

        $query = DB::table($table . ' as sc')
            ->leftJoin('warehouses as w', 'w.id', '=', 'sc.warehouse_id')
            ->select('sc.*', 'w.name as warehouse_name', DB::raw('sc.file_stock as file'))
            ->orderByDesc('sc.created_at');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function($q) use ($search) {
                $q->where('w.name', 'like', '%' . $search . '%')
                  ->orWhere('sc.date', 'like', '%' . $search . '%');
                if (Schema::hasColumn($this->stockCountTable() ?: 'count_stock', 'status')) {
                    $q->orWhere('sc.status', 'like', '%' . $search . '%');
                }
            });
        }

        $stockCounts = $query->paginate(10)->withQueryString();
        
        // Get warehouses for the create modal
        $warehouses = Schema::hasTable('warehouses') ? DB::table('warehouses')->select('id', 'name')->get() : collect();

        return view('products.stock-count', compact('stockCounts', 'warehouses'));
    }

    /**
     * Create new stock count
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'warehouse_id' => 'required|exists:warehouses,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = [
                'date' => $request->date,
                'warehouse_id' => $request->warehouse_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $table = $this->stockCountTable() ?: 'count_stock';
            if (Schema::hasColumn($table, 'user_id')) {
                $data['user_id'] = Auth::id();
            }
            // Ensure placeholder for NOT NULL file_stock columns to avoid MySQL default error
            if (Schema::hasColumn($table, 'file_stock')) {
                $data['file_stock'] = '';
            }
            if (Schema::hasColumn($table, 'status')) {
                $data['status'] = 'pending';
            }
            $stockCountId = DB::table($table)->insertGetId($data);

            // Auto-create an initial CSV file so "Download" is always available
            if (Schema::hasColumn($table, 'file_stock')) {
                $uploadsPath = public_path('uploads');
                if (!is_dir($uploadsPath)) {
                    @mkdir($uploadsPath, 0755, true);
                }

                $filename = 'stock_count_'.$stockCountId.'_'.date('Ymd_His').'.csv';
                $filepath = $uploadsPath . DIRECTORY_SEPARATOR . $filename;

                $fh = @fopen($filepath, 'w');
                if ($fh) {
                    // Optional UTF-8 BOM
                    fprintf($fh, chr(0xEF).chr(0xBB).chr(0xBF));
                    // Headers for empty template
                    fputcsv($fh, ['Stock Count ID','Date','Warehouse ID','Product Code','Product Name','Expected Qty','Counted Qty','Difference']);
                    fputcsv($fh, [$stockCountId, $request->date, $request->warehouse_id, '', '', 0, 0, 0]);
                    fclose($fh);

                    DB::table($table)->where('id', $stockCountId)->update([
                        'file_stock' => $filename,
                        'updated_at' => now(),
                    ]);
                }
            }

            // Seed stock_count_items from current warehouse inventory
            if (Schema::hasTable('stock_count_items') && Schema::hasTable('product_warehouse')) {
                $inventory = DB::table('product_warehouse as pw')
                    ->leftJoin('products as p','p.id','=','pw.product_id')
                    ->leftJoin('units as u','u.id','=','p.unit_id')
                    ->select('pw.product_id','pw.qte as expected_qty')
                    ->where('pw.warehouse_id', $request->warehouse_id)
                    ->get();
                foreach ($inventory as $row) {
                    DB::table('stock_count_items')->insert([
                        'stock_count_id' => $stockCountId,
                        'product_id' => $row->product_id,
                        'expected_qty' => (float)($row->expected_qty ?? 0),
                        'counted_qty' => 0,
                        'difference' => (float)($row->expected_qty ?? 0),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            return redirect()->route('stock-count.index')
                ->with('success', 'Stock count created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create stock count: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show specific stock count details
     */
    public function show($id): View
    {
        $table = $this->stockCountTable() ?: 'count_stock';
        $stockCount = DB::table($table . ' as sc')
            ->leftJoin('warehouses as w', 'w.id', '=', 'sc.warehouse_id')
            ->select('sc.*', 'w.name as warehouse_name')
            ->where('sc.id', $id)
            ->first();

        if (!$stockCount) {
            abort(404, 'Stock count not found');
        }

        // Get products for this stock count - check if table exists first
        $products = collect();
        if (DB::getSchemaBuilder()->hasTable('stock_count_items')) {
            $products = DB::table('stock_count_items as sci')
                ->leftJoin('products as p', 'p.id', '=', 'sci.product_id')
                ->leftJoin('brands as b', 'b.id', '=', 'p.brand_id')
                ->leftJoin('units as u', 'u.id', '=', 'p.unit_id')
                ->select('sci.*', 'p.name as product_name', 'p.code as product_code', 'b.name as brand', 'u.ShortName as unit')
                ->where('sci.stock_count_id', $id)
                    ->get();
            }

        return view('products.stock-count-detail', compact('stockCount', 'products'));
    }

    /**
     * Show edit stock count form
     */
    public function edit($id): View
    {
        $table = $this->stockCountTable() ?: 'count_stock';
        $stockCount = DB::table($table . ' as sc')
            ->leftJoin('warehouses as w', 'w.id', '=', 'sc.warehouse_id')
            ->select('sc.*', 'w.name as warehouse_name')
            ->where('sc.id', $id)
            ->first();

        if (!$stockCount) {
            abort(404, 'Stock count not found');
        }

        // Get warehouses for the form
        $warehouses = DB::table('warehouses')->select('id', 'name')->get();

        return view('products.stock-count-edit', compact('stockCount', 'warehouses'));
    }

    /**
     * Update stock count
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'warehouse_id' => 'required|exists:warehouses,id',
            'status' => 'required|in:pending,in_progress,completed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $table = $this->stockCountTable() ?: 'stock_counts';
            DB::table($table)
                ->where('id', $id)
                ->update([
                    'date' => $request->date,
                    'warehouse_id' => $request->warehouse_id,
                    'status' => $request->status,
                    'updated_at' => now()
                ]);

            return redirect()->route('stock-count.index')
                ->with('success', 'Stock count updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update stock count: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete stock count
     */
    public function destroy($id): RedirectResponse
    {
        try {
            DB::beginTransaction();
            
            // Check if stock_count_items table exists before trying to delete
            if (DB::getSchemaBuilder()->hasTable('stock_count_items')) {
                DB::table('stock_count_items')->where('stock_count_id', $id)->delete();
            }
            
            // Delete stock count
            DB::table('stock_counts')->where('id', $id)->delete();
            
            DB::commit();

            return redirect()->route('stock-count.index')
                ->with('success', 'Stock count deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to delete stock count: ' . $e->getMessage());
        }
    }

    /**
     * Export stock count to PDF
     */
    public function exportPdf($id)
    {
        $stockCount = DB::table('stock_counts as sc')
            ->leftJoin('warehouses as w', 'w.id', '=', 'sc.warehouse_id')
            ->select('sc.*', 'w.name as warehouse_name')
            ->where('sc.id', $id)
            ->first();

        if (!$stockCount) {
            abort(404, 'Stock count not found');
        }

        $products = DB::table('stock_count_items as sci')
            ->leftJoin('products as p', 'p.id', '=', 'sci.product_id')
            ->leftJoin('brands as b', 'b.id', '=', 'p.brand_id')
            ->leftJoin('units as u', 'u.id', '=', 'p.unit_id')
            ->select('sci.*', 'p.name as product_name', 'p.code as product_code', 'b.name as brand', 'u.ShortName as unit')
            ->where('sci.stock_count_id', $id)
            ->get();

        return view('products.stock-count-pdf', compact('stockCount', 'products'));
    }

    /**
     * Export stock count to Excel (CSV)
     */
    public function exportExcel($id)
    {
        $stockCount = DB::table('stock_counts as sc')
            ->leftJoin('warehouses as w', 'w.id', '=', 'sc.warehouse_id')
            ->select('sc.*', 'w.name as warehouse_name')
            ->where('sc.id', $id)
            ->first();

        if (!$stockCount) {
            abort(404, 'Stock count not found');
        }

        $products = DB::table('stock_count_items as sci')
            ->leftJoin('products as p', 'p.id', '=', 'sci.product_id')
            ->leftJoin('brands as b', 'b.id', '=', 'p.brand_id')
            ->leftJoin('units as u', 'u.id', '=', 'p.unit_id')
            ->select('sci.*', 'p.name as product_name', 'p.code as product_code', 'b.name as brand', 'u.ShortName as unit')
            ->where('sci.stock_count_id', $id)
            ->get();

        $filename = 'stock_count_' . $stockCount->id . '_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ];

        $callback = function() use ($stockCount, $products) {
            $output = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Add headers
            fputcsv($output, ['Stock Count ID', 'Date', 'Warehouse', 'Status', 'Product Code', 'Product Name', 'Brand', 'Unit', 'Expected Qty', 'Counted Qty', 'Difference']);
            
            // Add data rows
            foreach ($products as $product) {
                fputcsv($output, [
                    $stockCount->id,
                    $stockCount->date,
                    $stockCount->warehouse_name,
                    ucfirst($stockCount->status),
                    $product->product_code,
                    $product->product_name,
                    $product->brand,
                    $product->unit,
                    $product->expected_quantity ?? 0,
                    $product->counted_quantity ?? 0,
                    ($product->counted_quantity ?? 0) - ($product->expected_quantity ?? 0)
                ]);
            }
            
            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }
}