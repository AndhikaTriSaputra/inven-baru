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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ProductController extends Controller
{
    private function buildProductsQuery(Request $request, $showAll = false)
    {
        $q = DB::table('products as p')
            ->leftJoin('brands as b','b.id','=','p.brand_id')
            ->leftJoin('units as u','u.id','=','p.unit_id')
            ->leftJoin('categories as c','c.id','=','p.category_id')
            ->selectRaw('p.id, p.code, p.name, p.type, p.image, p.is_active, p.created_at, IFNULL(b.name, "N/D") as brand, IFNULL(u.ShortName, "Unt") as unit, IFNULL(c.name, "-") as category');

        // Role-based filtering: Non-admin users can only see approved products
        if (!$showAll && Auth::check()) {
            $user = Auth::user();
            if ($user->role_id != 1) { // Not admin
                $q->where('p.is_active', Product::STATUS_APPROVED);
            }
        }

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

    private function getUserPendingProducts($userId)
    {
        $cacheKey = "user_pending_products_{$userId}";
        return Cache::get($cacheKey, []);
    }

    private function saveUserPendingProduct($userId, $productData)
    {
        $cacheKey = "user_pending_products_{$userId}";
        $pendingProducts = Cache::get($cacheKey, []);
        
        $productId = 'temp_' . uniqid();
        $productData['temp_id'] = $productId;
        $productData['id'] = $productId; // Add id field for consistency with database products
        $productData['created_at'] = now();
        $productData['status'] = 'Pending';
        $productData['is_active'] = 0; // Add is_active field for consistency
        
        $pendingProducts[] = $productData;
        Cache::put($cacheKey, $pendingProducts, now()->addDays(30));
        
        return $productId;
    }

    private function removeUserPendingProduct($userId, $tempId)
    {
        $cacheKey = "user_pending_products_{$userId}";
        $pendingProducts = Cache::get($cacheKey, []);
        
        $pendingProducts = array_filter($pendingProducts, function($product) use ($tempId) {
            return $product['temp_id'] !== $tempId;
        });
        
        Cache::put($cacheKey, array_values($pendingProducts), now()->addDays(30));
    }

    private function getAllPendingProducts()
    {
        $allPendingProducts = [];
        $users = DB::table('users')->where('role_id', '!=', 1)->get();
        
        foreach ($users as $user) {
            $userPendingProducts = $this->getUserPendingProducts($user->id);
            
            // Enrich with category, brand, unit info
            foreach ($userPendingProducts as $product) {
                $category = DB::table('categories')->where('id', $product['category_id'])->first();
                $brand = DB::table('brands')->where('id', $product['brand_id'])->first();
                $unit = DB::table('units')->where('id', $product['unit_id'])->first();
                
                $product['category'] = $category ? $category->name : 'N/A';
                $product['brand'] = $brand ? $brand->name : 'N/A';
                $product['unit'] = $unit ? $unit->ShortName : 'N/A';
                $product['user_name'] = $user->firstname . ' ' . $user->lastname;
                $product['user_id'] = $user->id;
                
                $allPendingProducts[] = $product;
            }
        }
        
        // Sort by created_at
        usort($allPendingProducts, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        
        return $allPendingProducts;
    }
    /**
     * Display all products.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        
        if ($user && $user->role_id == 1) {
            // Admin: Show only approved products from database (no pending products)
            $products = $this->buildProductsQuery($request)
                ->where('p.is_active', Product::STATUS_APPROVED)
                ->orderByDesc('p.id')
                ->paginate(10)
                ->withQueryString();

            $allProducts = $this->buildProductsQuery($request)
                ->where('p.is_active', Product::STATUS_APPROVED)
                ->orderByDesc('p.id')
                ->get()
                ->map(function($product) {
                    return (array) $product; // Convert to array for consistency
                });
        } else {
            // Regular user: Show approved products from database + pending products from cache
            $approvedProducts = $this->buildProductsQuery($request)
                ->where('p.is_active', Product::STATUS_APPROVED)
                ->orderByDesc('p.id')
                ->get()
                ->map(function($product) {
                    return (array) $product; // Convert to array for consistency
                });

            // Get pending products from cache
            $pendingProducts = $this->getUserPendingProducts($user->id);
            
            // Combine and sort by created_at
            $allProducts = collect($approvedProducts)->merge(collect($pendingProducts))
                ->sortByDesc('created_at')
                ->values();

            // For pagination, we'll use a simple approach
            $perPage = 10;
            $currentPage = $request->get('page', 1);
            $offset = ($currentPage - 1) * $perPage;
            $paginatedProducts = $allProducts->slice($offset, $perPage)->values();
            
            // Create a simple paginator
            $products = new \Illuminate\Pagination\LengthAwarePaginator(
                $paginatedProducts,
                $allProducts->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'pageName' => 'page']
            );
            $products->withQueryString();
        }

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

    $user = Auth::user();
    
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
    ];

    if (Schema::hasColumn('products','project_id')) {
        $data['project_id'] = $request->input('project_id');
    }
    if (Schema::hasColumn('products','tag_id')) {
        $data['tag_id'] = $request->input('tag_id');
    }

    if ($user && $user->role_id == 1) {
        // Admin: Save directly to database
        $data['is_active'] = Product::STATUS_APPROVED;
        $data['created_at'] = now();
        $data['updated_at'] = now();
        
        DB::table('products')->insert($data);
        $message = 'Product created successfully';
    } else {
        // Regular user: Save to cache (temporary storage)
        $this->saveUserPendingProduct($user->id, $data);
        $message = 'Product created and submitted for approval';
    }
    
    return redirect()->route('products.index')->with('ok', $message);
}


    /** Show a product */
    public function show(int $id): View
    {
        // Check if it's a temporary product from cache
        if (strpos($id, 'temp_') === 0) {
            $user = Auth::user();
            if (!$user || $user->role_id == 1) {
                abort(404); // Only regular users can view their own pending products
            }
            
            $userPendingProducts = $this->getUserPendingProducts($user->id);
            $product = null;
            
            foreach ($userPendingProducts as $p) {
                if ($p['temp_id'] === $id) {
                    $product = (object) $p; // Convert to object for compatibility
                    break;
                }
            }
            
            abort_if(!$product, 404);
            return view('products.show', compact('product'));
        }
        
        $query = DB::table('products')->where('id',$id);
        
        // Non-admin users can only see approved products
        if (Auth::check() && Auth::user()->role_id != 1) {
            $query->where('is_active', Product::STATUS_APPROVED);
        }
        
        $product = $query->first();
        abort_if(!$product, 404);
        return view('products.show', compact('product'));
    }

    /** Show pending products for admin approval */
    public function pending(Request $request): View
    {
        // Get all pending products from all users' cache
        $allPendingProducts = [];
        
        // Get all users with pending products
        $users = DB::table('users')->where('role_id', '!=', 1)->get();
        
        foreach ($users as $user) {
            $userPendingProducts = $this->getUserPendingProducts($user->id);
            
            // Enrich with category, brand, unit info
            foreach ($userPendingProducts as $product) {
                $category = DB::table('categories')->where('id', $product['category_id'])->first();
                $brand = DB::table('brands')->where('id', $product['brand_id'])->first();
                $unit = DB::table('units')->where('id', $product['unit_id'])->first();
                
                $product['category'] = $category ? $category->name : 'N/A';
                $product['brand'] = $brand ? $brand->name : 'N/A';
                $product['unit'] = $unit ? $unit->ShortName : 'N/A';
                $product['user_name'] = $user->firstname . ' ' . $user->lastname;
                $product['user_id'] = $user->id;
                
                $allPendingProducts[] = $product;
            }
        }
        
        // Sort by created_at
        usort($allPendingProducts, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        
        // Simple pagination
        $perPage = 10;
        $currentPage = $request->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $products = array_slice($allPendingProducts, $offset, $perPage);
        
        // Create paginator
        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $products,
            count($allPendingProducts),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'pageName' => 'page']
        );
        $products->withQueryString();

        return view('products.pending', compact('products'));
    }

    /** Approve a product */
    public function approve($id)
    {
        if (Auth::user()->role_id != 1) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admin can approve products.'
            ], 403);
        }

        DB::beginTransaction();
        try {
            // Check if it's a temporary product from cache
            if (strpos($id, 'temp_') === 0) {
                // Find the product in user's cache
                $users = DB::table('users')->where('role_id', '!=', 1)->get();
                $productData = null;
                $userId = null;
                
                foreach ($users as $user) {
                    $userPendingProducts = $this->getUserPendingProducts($user->id);
                    foreach ($userPendingProducts as $product) {
                        if ($product['temp_id'] === $id) {
                            $productData = $product;
                            $userId = $user->id;
                            break 2;
                        }
                    }
                }
                
                if (!$productData) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Product not found in pending list.'
                    ], 404);
                }
                
                // Insert product into database
                $productId = DB::table('products')->insertGetId([
                    'type' => $productData['type'],
                    'code' => $productData['code'],
                    'Type_barcode' => $productData['Type_barcode'],
                    'name' => $productData['name'],
                    'category_id' => $productData['category_id'],
                    'brand_id' => $productData['brand_id'],
                    'unit_id' => $productData['unit_id'],
                    'stock_alert' => $productData['stock_alert'],
                    'image' => $productData['image'],
                    'is_active' => Product::STATUS_APPROVED,
                    'created_at' => $productData['created_at'],
                    'updated_at' => now(),
                ]);
                
                // Add optional fields if they exist
                if (isset($productData['project_id']) && Schema::hasColumn('products', 'project_id')) {
                    DB::table('products')->where('id', $productId)->update(['project_id' => $productData['project_id']]);
                }
                if (isset($productData['tag_id']) && Schema::hasColumn('products', 'tag_id')) {
                    DB::table('products')->where('id', $productId)->update(['tag_id' => $productData['tag_id']]);
                }
                
                // Remove from user's pending products
                $this->removeUserPendingProduct($userId, $id);
                
                // Add initial stock
                $initialStock = $productData['stock_alert'] > 0 ? $productData['stock_alert'] : 10;
                if (Schema::hasColumn('products', 'stock')) {
                    DB::table('products')->where('id', $productId)->update(['stock' => $initialStock]);
                }
                
            } else {
                // Handle database product (legacy support)
                $product = DB::table('products')->where('id', $id)->first();
                
                if (!$product) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Product not found.'
                    ], 404);
                }

                // Update product status to approved
                DB::table('products')->where('id', $id)->update([
                    'is_active' => Product::STATUS_APPROVED,
                    'updated_at' => now()
                ]);

                // Add quantity/stock to the product
                $initialStock = $product->stock_alert > 0 ? $product->stock_alert : 10;
                if (Schema::hasColumn('products', 'stock')) {
                    DB::table('products')->where('id', $id)->update(['stock' => $initialStock]);
                }
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Product approved successfully and added to stock.'
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error approving product: ' . $e->getMessage()
            ], 500);
        }
    }

    /** Reject a product */
    public function reject($id)
    {
        if (Auth::user()->role_id != 1) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admin can reject products.'
            ], 403);
        }

        try {
            // Check if it's a temporary product from cache
            if (strpos($id, 'temp_') === 0) {
                // Find the product in user's cache and remove it
                $users = DB::table('users')->where('role_id', '!=', 1)->get();
                $found = false;
                
                foreach ($users as $user) {
                    $userPendingProducts = $this->getUserPendingProducts($user->id);
                    foreach ($userPendingProducts as $product) {
                        if ($product['temp_id'] === $id) {
                            $this->removeUserPendingProduct($user->id, $id);
                            $found = true;
                            break 2;
                        }
                    }
                }
                
                if (!$found) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Product not found in pending list.'
                    ], 404);
                }
                
            } else {
                // Handle database product (legacy support)
                DB::table('products')->where('id', $id)->update([
                    'is_active' => Product::STATUS_REJECTED,
                    'updated_at' => now()
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Product rejected successfully.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error rejecting product: ' . $e->getMessage()
            ], 500);
        }
    }

    /** Get pending count for admin notification */
    public function getPendingCount()
    {
        // Count all pending products from all users' cache
        $count = 0;
        $users = DB::table('users')->where('role_id', '!=', 1)->get();
        
        foreach ($users as $user) {
            $userPendingProducts = $this->getUserPendingProducts($user->id);
            $count += count($userPendingProducts);
        }
        
        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }

    /** Approve pending product from cache */
    public function approvePending(Request $request)
    {
        if (Auth::user()->role_id != 1) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admin can approve products.'
            ], 403);
        }

        $cacheKey = $request->input('cache_key');
        $productData = Cache::get($cacheKey);
        
        if (!$productData) {
            return response()->json([
                'success' => false,
                'message' => 'Product data not found or expired.'
            ], 404);
        }

        DB::beginTransaction();
        try {
            // Insert product into database
            $productId = DB::table('products')->insertGetId([
                'type' => $productData['type'],
                'code' => $productData['code'],
                'Type_barcode' => $productData['Type_barcode'],
                'name' => $productData['name'],
                'category_id' => $productData['category_id'],
                'brand_id' => $productData['brand_id'],
                'unit_id' => $productData['unit_id'],
                'stock_alert' => $productData['stock_alert'],
                'image' => $productData['image'],
                'is_active' => 1, // Active immediately
                'created_at' => $productData['created_at'],
                'updated_at' => now(),
            ]);

            // Clear cache and remove from pending list
            Cache::forget($cacheKey);
            $pendingList = Cache::get('pending_products_list', []);
            $pendingList = array_filter($pendingList, function($key) use ($cacheKey) {
                return $key !== $cacheKey;
            });
            Cache::put('pending_products_list', array_values($pendingList), now()->addDays(30));
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Product approved and added to database successfully.'
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error approving product: ' . $e->getMessage()
            ], 500);
        }
    }

    /** Reject pending product from cache */
    public function rejectPending(Request $request)
    {
        if (Auth::user()->role_id != 1) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admin can reject products.'
            ], 403);
        }

        $cacheKey = $request->input('cache_key');
        
        // Just remove from cache (no database entry to delete)
        Cache::forget($cacheKey);
        
        // Remove from pending list
        $pendingList = Cache::get('pending_products_list', []);
        $pendingList = array_filter($pendingList, function($key) use ($cacheKey) {
            return $key !== $cacheKey;
        });
        Cache::put('pending_products_list', array_values($pendingList), now()->addDays(30));
        
        return response()->json([
            'success' => true,
            'message' => 'Product rejected successfully.'
        ]);
    }

    /** Edit form */
    public function edit(int $id): View
    {
        // Check if it's a temporary product from cache
        if (strpos($id, 'temp_') === 0) {
            $user = Auth::user();
            if (!$user || $user->role_id == 1) {
                abort(404); // Only regular users can edit their own pending products
            }
            
            $userPendingProducts = $this->getUserPendingProducts($user->id);
            $product = null;
            
            foreach ($userPendingProducts as $p) {
                if ($p['temp_id'] === $id) {
                    $product = (object) $p; // Convert to object for compatibility
                    break;
                }
            }
            
            abort_if(!$product, 404);
            $categories = DB::table('categories')->get();
            $brands = DB::table('brands')->get();
            $units = DB::table('units')->get();
            return view('products.edit', compact('product','categories','brands','units'));
        }
        
        $query = DB::table('products')->where('id',$id);
        
        // Non-admin users can only edit approved products
        if (Auth::check() && Auth::user()->role_id != 1) {
            $query->where('is_active', Product::STATUS_APPROVED);
        }
        
        $product = $query->first();
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

        $user = Auth::user();
        
        // Check if it's a temporary product from cache
        if (strpos($id, 'temp_') === 0) {
            // Update product in cache
            $userPendingProducts = $this->getUserPendingProducts($user->id);
            $productIndex = null;
            
            foreach ($userPendingProducts as $index => $product) {
                if ($product['temp_id'] === $id) {
                    $productIndex = $index;
                    break;
                }
            }
            
            if ($productIndex === null) {
                return redirect()->route('products.index')->with('error', 'Product not found');
            }
            
            // Handle images
            $existingImages = [];
            if (!empty($userPendingProducts[$productIndex]['image'])) {
                $existingImages = explode(',', $userPendingProducts[$productIndex]['image']);
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
                    $existingImages[] = $imageName;
                }
            }

            // Update product data
            $userPendingProducts[$productIndex]['name'] = $request->name;
            $userPendingProducts[$productIndex]['code'] = $request->code;
            $userPendingProducts[$productIndex]['type'] = $request->type;
            $userPendingProducts[$productIndex]['category_id'] = (int) $request->category_id;
            $userPendingProducts[$productIndex]['brand_id'] = $request->brand_id ? (int) $request->brand_id : null;
            $userPendingProducts[$productIndex]['unit_id'] = $request->product_unit_id ? (int) $request->product_unit_id : null;
            $userPendingProducts[$productIndex]['image'] = !empty($existingImages) ? implode(',', $existingImages) : null;
            
            if (Schema::hasColumn('products', 'description')) {
                $userPendingProducts[$productIndex]['description'] = $request->description;
            }
            if (Schema::hasColumn('products', 'barcode_symbology')) {
                $userPendingProducts[$productIndex]['barcode_symbology'] = $request->barcode_symbology;
            }
            if (Schema::hasColumn('products', 'project_id')) {
                $userPendingProducts[$productIndex]['project_id'] = $request->project_id ? (int) $request->project_id : null;
            }
            if (Schema::hasColumn('products', 'tag_id')) {
                $userPendingProducts[$productIndex]['tag_id'] = $request->tag_id ? (int) $request->tag_id : null;
            }
            
            // Save back to cache
            $cacheKey = "user_pending_products_{$user->id}";
            Cache::put($cacheKey, $userPendingProducts, now()->addDays(30));
            
            $message = 'Product updated and submitted for approval';
            
        } else {
            // Update database product
            $approvalStatus = ($user && $user->role_id == 1) ? Product::STATUS_APPROVED : Product::STATUS_PENDING;
            
            $updateData = [
                'name' => $request->name,
                'code' => $request->code,
                'type' => $request->type,
                'category_id' => (int) $request->category_id,
                'brand_id' => $request->brand_id ? (int) $request->brand_id : null,
                'unit_id' => $request->product_unit_id ? (int) $request->product_unit_id : null,
                'is_active' => $approvalStatus,
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
            
            $message = ($user && $user->role_id == 1) ? 'Product updated successfully' : 'Product updated and submitted for approval';
        }
        
        return redirect()->route('products.index')->with('ok', $message);
    }

    /** Delete */
    public function destroy($id): RedirectResponse
    {
        $user = Auth::user();
        
        // Check if it's a temporary product from cache
        if (strpos($id, 'temp_') === 0) {
            // Only the owner can delete their own pending products
            if (!$user || $user->role_id == 1) {
                return redirect()->route('products.index')->with('error', 'Unauthorized to delete this product');
            }
            
            // Remove from user's pending products
            $this->removeUserPendingProduct($user->id, $id);
            
            return redirect()->route('products.index')->with('success', 'Product deleted successfully');
        }
        
        // Check if user is admin (role_id = 1) for database products
        if ($user->role_id != 1) {
            return redirect()->route('products.index')->with('error', 'Only admin can delete products');
        }

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
}