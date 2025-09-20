<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // List purchases by line item (to match screenshot)
        $purchases = \DB::table('purchase_details as pd')
            ->join('purchases as pu','pu.id','=','pd.purchase_id')
            ->leftJoin('products as p','p.id','=','pd.product_id')
            ->leftJoin('categories as c','c.id','=','p.category_id')
            ->leftJoin('warehouses as w','w.id','=','pu.warehouse_id')
            ->leftJoin('providers as pr','pr.id','=','pu.provider_id')
            ->selectRaw('pd.id, pu.id as purchase_id, pu.date, pu.image, p.name as item, pd.quantity as qty, IFNULL(c.name, "Stock") as category, IFNULL(pr.name, "Other") as supplier, IFNULL(w.name, "—") as warehouse, IFNULL(pu.notes, "-") as note')
            ->orderByDesc('pu.date')
            ->paginate(10);

        // Get supplier options for filter
        $supplierOptions = \DB::table('providers')
            ->select('id', 'name')
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();

        // Get warehouse options for filter
        $warehouseOptions = \DB::table('warehouses')
            ->select('id', 'name')
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();

        return view('purchases.index', compact('purchases', 'supplierOptions', 'warehouseOptions'));
    }

    public function create()
    {
    $providers  = DB::table('providers')->select('id', 'name')->orderBy('name')->get();
    $warehouses = DB::table('warehouses')->select('id', 'name')->orderBy('name')->get();
    $categories = DB::table('categories')->select('id', 'name')->orderBy('name')->get();
    $brands     = DB::table('brands')->select('id', 'name')->orderBy('name')->get();
    $projects   = Schema::hasTable('projects') 
                    ? DB::table('projects')->select('id','name')->orderBy('name')->get()
                    : collect();
    $products   = DB::table('products')->select('id', 'name', 'code')->orderBy('name')->get();
    $units      = DB::table('units')->select('id', 'name', 'ShortName')->orderBy('ShortName')->get();

    return view('purchases.create', [
        'providers'      => $providers,
        'warehouses'     => $warehouses,
        'categories'     => $categories,
        'brands'         => $brands,
        'projects'       => $projects,
        'products'       => $products,
        'units'          => $units,
        'barcode_types'  => ['Code 128', 'EAN13', 'UPC'],
        'types'          => ['Standard Product', 'Combo Product', 'Service'],
    ]);
}


public function show($id)
{
    $purchase = \DB::table('purchases')->where('id', $id)->first();
    $details = DB::table('purchase_details as pd')
    ->leftJoin('products as p', 'p.id', '=', 'pd.product_id')
    ->leftJoin('units as u', 'u.id', '=', 'pd.purchase_unit_id')
    ->select('pd.*', 'p.name as product_name', 'p.code as product_code', 'u.ShortName as unit')
    ->where('pd.purchase_id', $id)
    ->get();

    return view('purchases.show', compact('purchase', 'details'));
}

public function print($id)
{
$purchase = DB::table('purchases')
    ->select('*') // pastikan semua kolom termasuk 'statut'
    ->where('id', $id)
    ->first();


    if (!$purchase) {
        abort(404);
    }

    $details = DB::table('purchase_details as pd')
        ->leftJoin('products as p', 'p.id', '=', 'pd.product_id')
        ->leftJoin('units as u', 'u.id', '=', 'pd.purchase_unit_id')
        ->select('pd.*', 'p.name as product_name', 'p.code as product_code', 'u.ShortName as unit')
        ->where('pd.purchase_id', $id)
        ->get();

    $provider  = DB::table('providers')->where('id', $purchase->provider_id)->first();
    $warehouse = DB::table('warehouses')->where('id', $purchase->warehouse_id)->first();

    return view('purchases.print', compact('purchase', 'details', 'provider', 'warehouse'));
}

public function invoice($id)
{
    $purchase = DB::table('purchases')->where('id', $id)->first();
    $purchase->status = $purchase->statut ?? 'received'; // fallback jika NULL
    $details = DB::table('purchase_details as pd')
        ->leftJoin('products as p', 'p.id', '=', 'pd.product_id')
        ->leftJoin('units as u', 'u.id', '=', 'pd.purchase_unit_id')
        ->select('pd.*', 'p.name as product_name', 'p.code as product_code', 'u.ShortName as unit')
        ->where('pd.purchase_id', $id)
        ->get();

    return view('purchases.invoice', compact('purchase', 'details'));
}



    public function store(Request $request)
    {
    // ✅ Validasi
    $validated = $request->validate([
        'date' => 'required|date',
        'provider_id' => 'required|integer|exists:providers,id',
        'warehouse_id' => 'required|integer|exists:warehouses,id',
    
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|integer|exists:products,id',
        'items.*.quantity' => 'required|numeric|min:0.0001',
        'items.*.cost' => 'required|numeric|min:0',
    ]);

    // ✅ Simpan purchase utama
$grandTotal = 0;
foreach ($validated['items'] as $item) {
    $grandTotal += $item['quantity'] * $item['cost'];
}

            $imageName = null;
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $imageName = time().'_'.uniqid().'.'.$request->file('image')->getClientOriginalExtension();
                @mkdir(public_path('images/purchases'), 0755, true);
                $request->file('image')->move(public_path('images/purchases'), $imageName);
            }

            $purchaseId = DB::table('purchases')->insertGetId([
    'user_id' => Auth::check() ? Auth::id() : 1, // Use authenticated user or default to 1
    'Ref' => 'PR_' . substr(uniqid(), -6),
    'date' => $validated['date'],
    'provider_id' => $validated['provider_id'],
    'warehouse_id' => $validated['warehouse_id'],
    'notes' => $request->notes ?? null,
    'GrandTotal' => $grandTotal,
                'paid_amount' => 0,
                'statut' => 'received',
                'payment_statut' => 'unpaid',
                'image' => $imageName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);




foreach ($validated['items'] as $item) {
                DB::table('purchase_details')->insert([
                    'purchase_id' => $purchaseId,
        'product_id' => $item['product_id'],
        'quantity' => $item['quantity'],
        'cost' => $item['cost'],
        'total' => $item['quantity'] * $item['cost'], // ✅ DITAMBAHKAN
        'purchase_unit_id' => $item['purchase_unit_id'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
}


    return redirect()->route('purchases.index')
        ->with('success', 'Purchase created successfully.');
}

public function exportPdf()
{
    try {
        $purchases = DB::table('purchase_details as pd')
            ->join('purchases as pu','pu.id','=','pd.purchase_id')
            ->leftJoin('products as p','p.id','=','pd.product_id')
            ->leftJoin('categories as c','c.id','=','p.category_id')
            ->leftJoin('warehouses as w','w.id','=','pu.warehouse_id')
            ->leftJoin('providers as pr','pr.id','=','pu.provider_id')
            ->selectRaw('pd.id, pu.id as purchase_id, pu.date, pu.image, p.name as item, pd.quantity as qty, IFNULL(c.name, "Stock") as category, IFNULL(pr.name, "Other") as supplier, IFNULL(w.name, "—") as warehouse, IFNULL(pu.notes, "-") as note')
            ->orderByDesc('pu.date')
            ->get();

        // For now, return HTML view until DomPDF is properly configured
        return view('purchases.pdf', compact('purchases'));
        
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function exportPurchasePdf($id)
{
    $purchase = DB::table('purchases')->where('id', $id)->first();
    $details = DB::table('purchase_details as pd')
        ->leftJoin('products as p', 'p.id', '=', 'pd.product_id')
        ->leftJoin('units as u', 'u.id', '=', 'pd.purchase_unit_id')
        ->select('pd.*', 'p.name as product_name', 'p.code as product_code', 'u.ShortName as unit')
        ->where('pd.purchase_id', $id)
        ->get();

    $provider = DB::table('providers')->where('id', $purchase->provider_id)->first();
    $warehouse = DB::table('warehouses')->where('id', $purchase->warehouse_id)->first();

    // For now, return HTML view until DomPDF is properly configured
    return view('purchases.print', compact('purchase', 'details', 'provider', 'warehouse'));
}

public function exportExcel()
{
    try {
        $purchases = DB::table('purchase_details as pd')
            ->join('purchases as pu','pu.id','=','pd.purchase_id')
            ->leftJoin('products as p','p.id','=','pd.product_id')
            ->leftJoin('categories as c','c.id','=','p.category_id')
            ->leftJoin('warehouses as w','w.id','=','pu.warehouse_id')
            ->leftJoin('providers as pr','pr.id','=','pu.provider_id')
            ->selectRaw('pd.id, pu.id as purchase_id, pu.date, pu.image, p.name as item, pd.quantity as qty, IFNULL(c.name, "Stock") as category, IFNULL(pr.name, "Other") as supplier, IFNULL(w.name, "—") as warehouse, IFNULL(pu.notes, "-") as note')
            ->orderByDesc('pu.date')
            ->get();

        $csv = "ID,Purchase ID,Date,Item,Quantity,Category,Supplier,Warehouse,Note\n";
        foreach ($purchases as $purchase) {
            $csv .= "{$purchase->id},{$purchase->purchase_id},{$purchase->date},{$purchase->item},{$purchase->qty},{$purchase->category},{$purchase->supplier},{$purchase->warehouse},{$purchase->note}\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="purchases.csv"');
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Purchase $purchase)
    // {
    //     $providers = DB::table('providers')->select('id','name')->get();
    //     $warehouses = DB::table('warehouses')->select('id','name')->get();
    //     $products = DB::table('products')->select('id','name','code')->get();
    //     $units = DB::table('units')->select('id','ShortName')->get();
    //     $details = DB::table('purchase_details as pd')
    //         ->leftJoin('products as p','p.id','=','pd.product_id')
    //         ->leftJoin('units as u','u.id','=','pd.purchase_unit_id')
    //         ->select('pd.*','p.name as product_name','p.code as product_code','u.ShortName as unit')
    //         ->where('pd.purchase_id',$purchase->id)
    //         ->get();

    //     $stocks = DB::table('product_warehouse')
    //         ->where('warehouse_id',$purchase->warehouse_id)
    //         ->whereIn('product_id', $details->pluck('product_id'))
    //         ->pluck('qte','product_id');

    //     return view('purchases.edit', compact('purchase','providers','warehouses','products','units','details','stocks'));
    // }

    public function edit($id)
{
    $purchase   = DB::table('purchases')->where('id',$id)->first();
    $details    = DB::table('purchase_details')->where('purchase_id',$id)->get();
    $providers  = DB::table('providers')->whereNull('deleted_at')->orderBy('name')->get();
    $warehouses = DB::table('warehouses')->whereNull('deleted_at')->orderBy('name')->get();
    $products   = DB::table('products')->whereNull('deleted_at')->orderBy('name')->get();
    $units      = DB::table('units')->whereNull('deleted_at')->orderBy('ShortName')->get();
    $categories = Category::whereNull('deleted_at')->orderBy('name')->get();

    // stok per product (opsional)
    $stocks = []; // isi sesuai logic kamu

    return view('purchases.edit', compact(
        'purchase','details','providers','warehouses','products','units','categories','stocks'
    ));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Purchase $purchase)
    // {
    //     $request->validate([
    //         'date' => ['required','date'],
    //         'provider_id' => ['required','integer'],
    //         'warehouse_id' => ['required','integer'],
    //         'notes' => ['nullable','string'],
    //         'image' => ['nullable','image','mimes:jpeg,png,jpg,webp','max:4096'],
    //         'remove_image' => ['nullable','boolean'],
    //     ]);
    //     $update = [
    //         'date'=>$request->date,
    //         'provider_id'=>$request->provider_id,
    //         'warehouse_id'=>$request->warehouse_id,
    //         'notes'=>$request->notes,
    //         'updated_at'=>now(),
    //     ];

    //     if ($request->boolean('remove_image')) {
    //         $update['image'] = null;
    //     }
    //     if ($request->hasFile('image') && $request->file('image')->isValid()) {
    //         $imageName = time().'_'.uniqid().'.'.$request->file('image')->getClientOriginalExtension();
    //         @mkdir(public_path('images/purchases'), 0755, true);
    //         $request->file('image')->move(public_path('images/purchases'), $imageName);
    //         $update['image'] = $imageName;
    //     }

    //     DB::table('purchases')->where('id',$purchase->id)->update($update);
    //     return redirect()->route('purchases.index')->with('ok','Purchase updated');
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'provider_id' => 'required|exists:providers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'notes' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'date' => $request->date,
            'provider_id' => $request->provider_id,
            'warehouse_id' => $request->warehouse_id,
            'notes' => $request->notes,
            'updated_at' => now(),
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            @mkdir(public_path('images/purchases'), 0755, true);
            $image->move(public_path('images/purchases'), $imageName);
            $data['image'] = $imageName;
        }

        DB::table('purchases')->where('id', $id)->update($data);

        return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            DB::table('purchase_details')->where('purchase_id', $id)->delete();
            DB::table('purchases')->where('id', $id)->delete();
        });
        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully');
    }
}