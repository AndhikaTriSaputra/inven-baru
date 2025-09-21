<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Project;
use App\Models\Tag;
use App\Models\Unit;




class ProductController extends Controller
{
    private function buildProductsQuery(Request $request)
    {
        $q = DB::table('products as p')
            ->leftJoin('brands as b','b.id','=','p.brand_id')
            ->leftJoin('units as u','u.id','=','p.unit_id')
            ->leftJoin('categories as c','c.id','=','p.category_id')
            ->selectRaw('p.id, p.code, p.name, p.type, p.image, IFNULL(b.name, "N/D") as brand, IFNULL(u.ShortName, "Unt") as unit, IFNULL(c.name, "-") as category');

        if ($request->filled('code')) {
            $q->where('p.code', 'like', '%'.$request->query('code').'%');
        }
        if ($request->filled('name')) {
            $q->where('p.name', 'like', '%'.$request->query('name').'%');
        }
        if ($request->filled('brand_id')) {
            $q->where('p.brand_id', (int) $request->query('brand_id'));
        }
        if ($request->filled('category_id')) {
            $q->where('p.category_id', (int) $request->query('category_id'));
        }
        return $q;
    }
    /**
     * Display all products.
     */
    public function index(Request $request): View
    {
        $products = $this->buildProductsQuery($request)
            ->orderByDesc('p.id')
            ->paginate(10)
            ->withQueryString();

        // Get all products for JavaScript search functionality
        $allProducts = $this->buildProductsQuery($request)
            ->orderByDesc('p.id')
            ->get();

        return view('products.index', compact('products', 'allProducts'));
    }
    
    /** Lightweight search API (used by frontend live search) */
    public function search(Request $request)
    {
        $products = $this->buildProductsQuery($request)
            ->orderByDesc('p.id')
            ->limit(50)
            ->get();
        return response()->json([ 'products' => $products ]);
    }

    /** Export CSV (Excel-friendly) honoring filters */
    public function exportExcel(Request $request)
    {
        $rows = $this->buildProductsQuery($request)
            ->orderBy('p.name')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename=products.csv',
        ];

        $callback = function() use ($rows) {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['ID','Code','Name','Type','Brand','Unit','Category']);
            foreach ($rows as $r) {
                fputcsv($output, [$r->id, $r->code, $r->name, $r->type, $r->brand, $r->unit, $r->category]);
            }
            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }

    /** Export printable HTML that the browser can save as PDF, honoring filters */
    public function exportPdf(Request $request)
    {
        $rows = $this->buildProductsQuery($request)
            ->orderBy('p.name')
            ->get();
        return view('products.export-pdf', [ 'rows' => $rows ]);
    }
    /**
     * Show the create product form.
     */
    // public function create(): View
    // {
    //     // Fetch options from database if tables exist
    //     $categories = DB::table('categories')->select('id','name')->get();
    //     $brands = DB::table('brands')->select('id','name')->get();
    //     $units = DB::table('units')->select('id','name','ShortName')->get();
    //     $projects = Schema::hasTable('projects') ? DB::table('projects')->select('id','name')->get() : collect();
    //     $tags = Schema::hasTable('tags') ? DB::table('tags')->select('id','name')->get() : collect();

    //     return view('products.create', compact('categories', 'brands', 'projects', 'units', 'tags'));
    // }

public function create()
{
    return view('products.create', [
    'categories'     => Category::all(),
    'brands'         => Brand::all(),
    'projects'       => Schema::hasTable('projects') 
                            ? DB::table('projects')->select('id','name')->get()
                            : collect(),
    'tags'           => Schema::hasTable('tags') 
                            ? DB::table('tags')->select('id','name')->get()
                            : collect(),
    'units'          => Unit::all(),
        'barcode_types'  => ['Code 128', 'EAN13', 'UPC', 'QR'],
        'types'          => ['Standard Product', 'Combo Product', 'Service'],
    ]);
}

// public function create()
// {
//     return view('products.create', [
//         'categories' => Category::all(),
//         'brands' => Brand::all(),
//         'units' => Unit::all(),
//         'projects' => DB::table('projects')->get(),
//         'tags' => Tag::all(),
//         'types' => ['standard', 'combo', 'service'],
//         'barcode_types' => ['Code128', 'Code39', 'EAN8', 'EAN13', 'UPC-A', 'UPC-E'],
//     ]);
// }



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
        'tag_id' => ['nullable'],
        'type' => ['required', 'in:is_single,is_service,is_variant,standard,service'],
        'product_unit_id' => ['nullable'],
        'stock_alert' => ['nullable', 'integer', 'min:0'],
        'images' => ['nullable', 'array'],
        'images.*' => ['file', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
    ]);

    // Siapkan direktori upload
    $uploadPath = public_path('images/products');
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
            $storedImagePaths[] = $fileName; // Tanpa path panjang
        }
    }

    // Siapkan data untuk insert
   $data = [
    'type' => $validated['type'],
    'code' => $validated['code'],
    'Type_barcode' => strtoupper($request->input('barcode_symbology', 'CODE128')),
    'name' => $validated['name'],
    'category_id' => (int) $validated['category_id'],
    'brand_id' => $request->input('brand_id'),
    'unit_id' => $request->input('product_unit_id'),
    'stock_alert' => (int) ($request->input('stock_alert', 0)),
    'image' => !empty($storedImagePaths) ? implode(',', $storedImagePaths) : null,
    'is_active' => 1, // ✅ Pastikan aktif
    'created_at' => now(),
    'updated_at' => now(),
];


    if (Schema::hasColumn('products','project_id')) {
        $data['project_id'] = $request->input('project_id');
    }
    if (Schema::hasColumn('products','tag_id')) {
        $data['tag_id'] = $request->input('tag_id');
    }

    DB::table('products')->insert($data);

    return redirect()->route('products.index')->with('ok', 'Product created');
}


    /** Show a product */
    public function show($id): View
    {
        $product = DB::table('products')->where('id', (int)$id)->first();
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
            'type' => ['required','in:is_single,is_service,is_variant,standard,service,non_product'],
            'category_id' => ['required'],
            'brand_id' => ['nullable'],
            'product_unit_id' => ['nullable'],
            'description' => ['nullable','string'],
            'barcode_symbology' => ['nullable','string'],
            'project_id' => ['nullable'],
            'tag_id' => ['nullable'],
            'images.*' => ['nullable','image','mimes:jpeg,png,jpg,gif,webp','max:4096'],
            'remove_images' => ['nullable','array'],
            'remove_images.*' => ['string'],
        ]);

        $updateData = [
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type,
            'category_id' => (int) $request->category_id,
            'brand_id' => $request->brand_id ? (int) $request->brand_id : null,
            'unit_id' => $request->product_unit_id ? (int) $request->product_unit_id : null,
            'updated_at' => now(),
        ];

        // Add optional fields only if columns exist to avoid SQL errors
        if (Schema::hasColumn('products', 'description')) {
            $updateData['description'] = $request->description;
        }
        if (Schema::hasColumn('products', 'barcode_symbology')) {
            $updateData['barcode_symbology'] = $request->barcode_symbology;
        }
        if (Schema::hasColumn('products', 'project_id')) {
            $updateData['project_id'] = $request->project_id ? (int) $request->project_id : null;
        }
        if (Schema::hasColumn('products', 'tag_id')) {
            $updateData['tag_id'] = $request->tag_id ? (int) $request->tag_id : null;
        }

        // Handle multiple images (existing + new)
        $existing = DB::table('products')->where('id',$id)->value('image');
        $existingImages = [];
        if (!empty($existing)) {
            $existingImages = is_string($existing) ? explode(',', $existing) : (array) $existing;
            $existingImages = array_values(array_filter(array_map('trim', $existingImages)));
        }

        // Remove selected existing images
        $removeImages = (array) $request->input('remove_images', []);
        if (!empty($removeImages)) {
            $existingImages = array_values(array_filter($existingImages, function($img) use ($removeImages) {
                return !in_array($img, $removeImages, true);
            }));
        }

        // Upload new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if (!$image->isValid()) continue;
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/products'), $imageName);
                // store relative path consistent with existing
                $existingImages[] = $imageName;
            }
        }

        // Save merged list
        if (!empty($existingImages)) {
            $updateData['image'] = implode(',', $existingImages);
        } else {
            $updateData['image'] = null;
        }

        DB::table('products')->where('id',$id)->update($updateData);

        return redirect()->route('products.index')->with('success','Product updated successfully');
    }

    /** Delete */
    public function destroy(int $id): RedirectResponse
    {
        try {
            // Start a database transaction
            DB::beginTransaction();
            
            // Delete related records from all tables that might reference products
            // Check if tables exist before trying to delete from them
            if (DB::getSchemaBuilder()->hasTable('product_warehouse')) {
                DB::table('product_warehouse')->where('product_id', $id)->delete();
            }
            
            if (DB::getSchemaBuilder()->hasTable('purchase_details')) {
                DB::table('purchase_details')->where('product_id', $id)->delete();
            }
            
            if (DB::getSchemaBuilder()->hasTable('sale_details')) {
                DB::table('sale_details')->where('product_id', $id)->delete();
            }
            
            if (DB::getSchemaBuilder()->hasTable('adjustment_details')) {
                DB::table('adjustment_details')->where('product_id', $id)->delete();
            }
            
            if (DB::getSchemaBuilder()->hasTable('transfer_details')) {
                DB::table('transfer_details')->where('product_id', $id)->delete();
            }
            
            if (DB::getSchemaBuilder()->hasTable('quotation_details')) {
                DB::table('quotation_details')->where('product_id', $id)->delete();
            }
            
            if (DB::getSchemaBuilder()->hasTable('sale_return_details')) {
                DB::table('sale_return_details')->where('product_id', $id)->delete();
            }
            
            if (DB::getSchemaBuilder()->hasTable('purchase_return_details')) {
                DB::table('purchase_return_details')->where('product_id', $id)->delete();
            }
            
            // Then delete the product
            $deleted = DB::table('products')->where('id', $id)->delete();
            
            if ($deleted) {
                DB::commit();
                return redirect()->route('products.index')->with('success', 'Product deleted successfully');
            } else {
                DB::rollback();
                return redirect()->route('products.index')->with('error', 'Product not found');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('products.index')->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

    /**
     * Display print labels page
     */
    public function labels()
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

            return view('products.labels', compact('products'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display stock count page
     */
    public function stockCount()
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
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}