<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display all products.
     */
    public function index(): View
    {
        $products = DB::table('products as p')
            ->leftJoin('brands as b','b.id','=','p.brand_id')
            ->leftJoin('units as u','u.id','=','p.unit_id')
            ->leftJoin('product_warehouse as pw','pw.product_id','=','p.id')
            ->selectRaw('p.id, p.code, p.name, p.type, p.image, IFNULL(b.name, "N/D") as brand, IFNULL(u.ShortName, "Unt") as unit, SUM(IFNULL(pw.qte,0)) as qty')
            ->groupBy('p.id')
            ->orderByDesc('p.id')
            ->paginate(10);

        return view('products.index', compact('products'));
    }
    /**
     * Show the create product form.
     */
    public function create(): View
    {
        $categories = DB::table('categories')->select('id','name','code')->orderBy('name')->get()->map(function($r){ return ['id'=>$r->id,'name'=>$r->name,'code'=>$r->code]; })->toArray();
        $brands = DB::table('brands')->select('id','name')->orderBy('name')->get()->map(function($r){ return ['id'=>$r->id,'name'=>$r->name]; })->toArray();
        $units = DB::table('units')->select('id','name')->orderBy('name')->get()->map(function($r){ return ['id'=>$r->id,'name'=>$r->name]; })->toArray();
        $projects = [];
        $tags = [];

        return view('products.create', compact('categories', 'brands', 'projects', 'units', 'tags'));
    }

    /**
     * Handle storing the product.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'barcode_symbology' => ['nullable', 'in:code128,ean13,upca'],
            'code' => ['required', 'string', 'max:255'],
            'category_id' => ['required'],
            'brand_id' => ['nullable'],
            'project_id' => ['nullable'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer'],
            'type' => ['required', 'in:is_single,is_service,is_variant,standard,service'],
            'product_unit_id' => ['nullable'],
            'stock_alert' => ['nullable', 'integer', 'min:0'],
            'images' => ['nullable', 'array'],
            'images.*' => ['file', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ]);

        // Demo-only: create uploads directory if missing and store files.
        $uploadPath = public_path('uploads/products');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $storedImagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                if (!$imageFile->isValid()) {
                    continue;
                }
                $fileName = uniqid('prod_') . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move($uploadPath, $fileName);
                $storedImagePaths[] = 'uploads/products/' . $fileName;
            }
        }

        // Persist minimal fields to products
        DB::table('products')->insert([
            'type' => $validated['type'],
            'code' => $validated['code'],
            'type_barcode' => strtoupper($request->input('barcode_symbology','CODE128')),
            'name' => $validated['name'],
            'category_id' => (int) $validated['category_id'],
            'brand_id' => $request->input('brand_id'),
            'unit_id' => $request->input('product_unit_id'),
            'image' => $storedImagePaths ? implode(',', $storedImagePaths) : 'no-image.png',
            'stock_alert' => (int) ($request->input('stock_alert', 0)),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('products.index')->with('ok', 'Product created');
    }

    /** Show a product */
    public function show(int $id): View
    {
        $product = DB::table('products')->where('id',$id)->first();
        abort_if(!$product, 404);
        return view('products.show', compact('product'));
    }

    /** Edit form */
    public function edit(int $id): View
    {
        $product = DB::table('products')->where('id',$id)->first();
        abort_if(!$product, 404);
        $categories = DB::table('categories')->get();
        $brands = DB::table('brands')->get();
        $units = DB::table('units')->get();
        return view('products.edit', compact('product','categories','brands','units'));
    }

    /** Update */
    public function update(int $id, Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'code' => ['required','string','max:255'],
            'type' => ['required','in:is_single,is_service,is_variant,standard,service'],
            'category_id' => ['required'],
            'brand_id' => ['nullable'],
            'unit_id' => ['nullable'],
        ]);

        DB::table('products')->where('id',$id)->update([
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type,
            'category_id' => (int) $request->category_id,
            'brand_id' => $request->brand_id,
            'unit_id' => $request->unit_id,
            'updated_at' => now(),
        ]);

        return redirect()->route('products.index')->with('ok','Product updated');
    }

    /** Delete */
    public function destroy(int $id): RedirectResponse
    {
        DB::table('products')->where('id',$id)->delete();
        return redirect()->route('products.index')->with('ok','Product deleted');
    }

    /**
     * Export products to PDF (placeholder implementation)
     */
    public function exportPdf(): RedirectResponse
    {
        return redirect()->route('products.index')->with('info', 'Export PDF not configured in this demo.');
    }

    /**
     * Export products to Excel (placeholder implementation)
     */
    public function exportExcel(): RedirectResponse
    {
        return redirect()->route('products.index')->with('info', 'Export Excel not configured in this demo.');
    }

    /**
     * Lightweight search endpoint used by the index page JS
     */
    public function search(Request $request): JsonResponse
    {
        $q = trim((string) $request->get('q', ''));
        if ($q === '') {
            return response()->json(['products' => []]);
        }

        $products = DB::table('products as p')
            ->leftJoin('brands as b','b.id','=','p.brand_id')
            ->leftJoin('units as u','u.id','=','p.unit_id')
            ->leftJoin('product_warehouse as pw','pw.product_id','=','p.id')
            ->selectRaw('p.id, p.code, p.name, p.type, IFNULL(b.name, "N/D") as brand, IFNULL(u.ShortName, "Unt") as unit, SUM(IFNULL(pw.qte,0)) as quantity')
            ->where(function($w) use ($q) {
                $w->where('p.name', 'like', "%$q%")
                  ->orWhere('p.code', 'like', "%$q%")
                  ->orWhere('b.name', 'like', "%$q%");
            })
            ->groupBy('p.id')
            ->limit(20)
            ->get();

        return response()->json(['products' => $products]);
    }

    /**
     * Approve selected products (demo: no-op)
     */
    public function approve(Request $request): JsonResponse
    {
        $ids = (array) $request->input('product_ids', []);
        return response()->json(['approved' => array_values($ids)]);
    }

    /**
     * Import products from CSV (demo: no-op)
     */
    public function import(Request $request): JsonResponse
    {
        return response()->json(['status' => 'ok']);
    }
}



