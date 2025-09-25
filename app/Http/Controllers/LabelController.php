<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LabelController extends Controller
{
    /**
     * Display print labels page
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
                    ->select('products.*', 'categories.name as category_name', 'brands.name as brand_name', DB::raw('COALESCE(units.ShortName, units.name) as unit_name'))
                    ->orderByDesc('products.created_at')
                    ->get();
            }

            // Include pending products for non-admin users so they can print labels immediately
            if (Auth::check() && Auth::user()->role_id != 1) {
                $userId = Auth::id();
                $pending = Cache::get("user_pending_products_{$userId}", []);

                if (!empty($pending)) {
                    foreach ($pending as $p) {
                        // Resolve names for category/brand/unit
                        $categoryName = null;
                        if (!empty($p['category_id'])) {
                            $categoryName = DB::table('categories')->where('id', $p['category_id'])->value('name');
                        }
                        $brandName = null;
                        if (!empty($p['brand_id'])) {
                            $brandName = DB::table('brands')->where('id', $p['brand_id'])->value('name');
                        }
                        $unitName = null;
                        if (!empty($p['unit_id'])) {
                            $unitName = DB::table('units')->where('id', $p['unit_id'])->value(DB::raw('COALESCE(ShortName, name)'));
                        }

                        $products->prepend((object) [
                            'id' => $p['temp_id'] ?? ($p['id'] ?? null),
                            'name' => $p['name'] ?? 'Untitled',
                            'code' => $p['code'] ?? '',
                            'category_name' => $categoryName,
                            'brand_name' => $brandName,
                            'unit_name' => $unitName ?? 'pcs',
                            'stock' => $p['stock'] ?? 0,
                            'price' => $p['price'] ?? 0,
                        ]);
                    }
                }
            }

            return view('products.labels', compact('products'));
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
            
            return view('products.labels', compact('products'));
        }
    }
}































