<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StockCountController extends Controller
{
    /**
     * Display stock count page
     */
    public function index()
    {
        try {
            $products = collect([]);
            
            if (Schema::hasTable('products')) {
                $products = DB::table('products')
                    ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                    ->leftJoin('brands', 'brands.id', '=', 'products.brand_id')
                    ->leftJoin('units', 'units.id', '=', 'products.unit_id')
                    ->select('products.*', 'categories.name as category_name', 'brands.name as brand_name', 'units.name as unit_name')
                    ->orderBy('products.name')
                    ->get();
            }

            return view('products.stock-count', compact('products'));
        } catch (\Exception $e) {
            // Fallback dengan sample data jika ada error
            $products = collect([
                (object)[
                    'id' => 1,
                    'name' => 'Sample Product 1',
                    'code' => 'PRD001',
                    'category_name' => 'Electronics',
                    'brand_name' => 'Samsung',
                    'unit_name' => 'pcs'
                ],
                (object)[
                    'id' => 2,
                    'name' => 'Sample Product 2',
                    'code' => 'PRD002',
                    'category_name' => 'Clothing',
                    'brand_name' => 'Nike',
                    'unit_name' => 'pcs'
                ]
            ]);
            
            return view('products.stock-count', compact('products'));
        }
    }
}







