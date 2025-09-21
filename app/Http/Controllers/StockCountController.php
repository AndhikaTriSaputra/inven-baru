<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StockCountController extends Controller
{
    /**
     * Display stock counts list
     */
    public function index(Request $request): View
    {
        $query = DB::table('stock_counts as sc')
            ->leftJoin('warehouses as w', 'w.id', '=', 'sc.warehouse_id')
            ->select('sc.*', 'w.name as warehouse_name')
            ->orderByDesc('sc.created_at');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function($q) use ($search) {
                $q->where('w.name', 'like', '%' . $search . '%')
                  ->orWhere('sc.status', 'like', '%' . $search . '%')
                  ->orWhere('sc.date', 'like', '%' . $search . '%');
            });
        }

        $stockCounts = $query->paginate(10)->withQueryString();
        
        // Get warehouses for the create modal
        $warehouses = DB::table('warehouses')->select('id', 'name')->get();

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
            $stockCountId = DB::table('stock_counts')->insertGetId([
                'date' => $request->date,
                'warehouse_id' => $request->warehouse_id,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()->route('stock-count.show', $stockCountId)
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
        $stockCount = DB::table('stock_counts as sc')
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
        $stockCount = DB::table('stock_counts as sc')
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
            DB::table('stock_counts')
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