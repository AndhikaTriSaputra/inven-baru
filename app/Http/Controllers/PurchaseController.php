<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Added DB facade

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
            ->selectRaw('pd.id, pu.id as purchase_id, pu.date, p.image, p.name as item, pd.quantity as qty, IFNULL(c.name, "Stock") as category, IFNULL(pr.name, "Other") as supplier, IFNULL(w.name, "—") as warehouse, IFNULL(pu.notes, "-") as note')
            ->orderByDesc('pu.date')
            ->paginate(10);

        return view('purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $providers = DB::table('providers')->select('id','name')->get();
        $warehouses = DB::table('warehouses')->select('id','name')->get();
        $products = DB::table('products')->select('id','name','code')->get();
        $units = DB::table('units')->select('id','ShortName')->get();
        return view('purchases.create', compact('providers','warehouses','products','units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => ['required','date'],
            'provider_id' => ['required','integer'],
            'warehouse_id' => ['required','integer'],
            'notes' => ['nullable','string'],
            'items' => ['required','array','min:1'],
            'items.*.product_id' => ['required','integer'],
            'items.*.quantity' => ['required','numeric','min:0.0001'],
            'items.*.cost' => ['required','numeric','min:0'],
            'items.*.purchase_unit_id' => ['nullable','integer'],
        ]);

        DB::transaction(function () use ($request) {
            $grand = 0;
            foreach ($request->items as $row) {
                $grand += $row['cost'] * $row['quantity'];
            }
            $purchaseId = DB::table('purchases')->insertGetId([
                'user_id' => auth()->id(),
                'Ref' => 'PR_'.substr(uniqid(),-6),
                'date' => $request->date,
                'provider_id' => $request->provider_id,
                'warehouse_id' => $request->warehouse_id,
                'GrandTotal' => $grand,
                'paid_amount' => 0,
                'statut' => 'received',
                'payment_statut' => 'unpaid',
                'notes' => $request->notes,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($request->items as $row) {
                DB::table('purchase_details')->insert([
                    'purchase_id' => $purchaseId,
                    'product_id' => $row['product_id'],
                    'cost' => $row['cost'],
                    'purchase_unit_id' => $row['purchase_unit_id'] ?? null,
                    'total' => $row['cost'] * $row['quantity'],
                    'quantity' => $row['quantity'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // update stock into product_warehouse
                $current = DB::table('product_warehouse')
                    ->where('product_id',$row['product_id'])
                    ->where('warehouse_id',$request->warehouse_id)
                    ->value('qte');

                if ($current === null) {
                    DB::table('product_warehouse')->insert([
                        'product_id'=>$row['product_id'],
                        'warehouse_id'=>$request->warehouse_id,
                        'qte'=>$row['quantity'],
                        'manage_stock'=>1,
                        'created_at'=>now(),
                        'updated_at'=>now(),
                    ]);
                } else {
                    DB::table('product_warehouse')
                        ->where('product_id',$row['product_id'])
                        ->where('warehouse_id',$request->warehouse_id)
                        ->update(['qte'=> $current + $row['quantity'], 'updated_at'=>now()]);
                }
            }
        });

        return redirect()->route('purchases.index')->with('ok','Purchase created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        $details = DB::table('purchase_details as pd')
            ->join('products as p','p.id','=','pd.product_id')
            ->leftJoin('units as u','u.id','=','pd.purchase_unit_id')
            ->select('pd.*','p.name as product_name','p.code as product_code','u.ShortName as unit')
            ->where('pd.purchase_id',$purchase->id)
            ->get();
        return view('purchases.show', compact('purchase','details'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        $providers = DB::table('providers')->select('id','name')->get();
        $warehouses = DB::table('warehouses')->select('id','name')->get();
        $products = DB::table('products')->select('id','name','code')->get();
        $units = DB::table('units')->select('id','ShortName')->get();
        $details = DB::table('purchase_details')->where('purchase_id',$purchase->id)->get();
        return view('purchases.edit', compact('purchase','providers','warehouses','products','units','details'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'date' => ['required','date'],
            'provider_id' => ['required','integer'],
            'warehouse_id' => ['required','integer'],
            'notes' => ['nullable','string'],
        ]);
        DB::table('purchases')->where('id',$purchase->id)->update([
            'date'=>$request->date,
            'provider_id'=>$request->provider_id,
            'warehouse_id'=>$request->warehouse_id,
            'notes'=>$request->notes,
            'updated_at'=>now(),
        ]);
        return redirect()->route('purchases.index')->with('ok','Purchase updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        DB::transaction(function () use ($purchase) {
            DB::table('purchase_details')->where('purchase_id',$purchase->id)->delete();
            DB::table('purchases')->where('id',$purchase->id)->delete();
        });
        return redirect()->route('purchases.index')->with('ok','Purchase deleted');
    }
}
