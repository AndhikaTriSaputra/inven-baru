<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \DB::table('transfers as t')
            ->leftJoin('warehouses as wf','wf.id','=','t.from_warehouse_id')
            ->leftJoin('warehouses as wt','wt.id','=','t.to_warehouse_id')
            ->selectRaw('t.id, t.date, t.Ref as reference, IFNULL(wf.name, "—") as from_wh, IFNULL(wt.name, "—") as to_wh, t.items, t.statut, "Stock" as category');

        // Apply filters
        if ($request->filled('reference')) {
            $query->where('t.Ref', 'like', '%' . $request->reference . '%');
        }
        if ($request->filled('from_warehouse_id')) {
            $query->where('t.from_warehouse_id', $request->from_warehouse_id);
        }
        if ($request->filled('to_warehouse_id')) {
            $query->where('t.to_warehouse_id', $request->to_warehouse_id);
        }
        if ($request->filled('status')) {
            $query->where('t.statut', $request->status);
        }
        if ($request->filled('category')) {
            $query->whereRaw('"Stock" = ?', [$request->category]);
        }

        $transfers = $query->orderByDesc('t.date')->paginate(10);

        // Get all transfers for JavaScript search functionality
        $allTransfers = $query->orderByDesc('t.date')->get();

        // Get warehouse options for filter
        $warehouseOptions = \DB::table('warehouses')->pluck('name', 'id')->toArray();

        // Handle export
        if ($request->has('export')) {
            return $this->handleExport($request, $query->get());
        }

        // Handle detail modal
        $detailHeader = null;
        $detailItems = null;
        $detailFromWarehouse = null;
        $detailToWarehouse = null;
        
        if ($request->has('detail')) {
            $detailHeader = \DB::table('transfers')->where('id', $request->detail)->first();
            if ($detailHeader) {
                $detailItems = \DB::table('transfer_details as td')
                    ->join('products as p','p.id','=','td.product_id')
                    ->leftJoin('units as u','u.id','=','td.purchase_unit_id')
                    ->select('td.*','p.name as product_name','p.code as product_code','u.ShortName as unit')
                    ->where('td.transfer_id', $request->detail)
                    ->get();
                    
                $detailFromWarehouse = \DB::table('warehouses')->where('id', $detailHeader->from_warehouse_id)->value('name');
                $detailToWarehouse = \DB::table('warehouses')->where('id', $detailHeader->to_warehouse_id)->value('name');
            }
        }

        return view('transfers.index', compact('transfers', 'allTransfers', 'warehouseOptions', 'detailHeader', 'detailItems', 'detailFromWarehouse', 'detailToWarehouse'));
    }

    private function handleExport($request, $data)
    {
        $exportType = $request->get('export');
        
        if ($exportType === 'pdf') {
            return $this->exportPdf($data);
        } elseif ($exportType === 'excel') {
            return $this->exportExcel($data);
        }
        
        return redirect()->back();
    }

    private function exportPdf($data)
    {
        // Create a simple HTML view for PDF like purchases
        $html = view('transfers.pdf', compact('data'))->render();
        
        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'inline; filename="transfers_report.html"');
    }

    private function exportExcel($data)
    {
        // Simple CSV export - you can enhance this with a proper Excel library
        $content = "Date,Reference,From Warehouse,To Warehouse,Items,Status,Category\n";
        
        foreach ($data as $transfer) {
            $content .= $transfer->date . "," . 
                       $transfer->reference . "," . 
                       $transfer->from_wh . "," . 
                       $transfer->to_wh . "," . 
                       $transfer->items . "," . 
                       $transfer->statut . "," . 
                       $transfer->category . "\n";
        }
        
        return response($content)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="transfers_report.csv"');
    }

    

    /**
     * Show the form for creating a new resource.
     */
 public function create()
    {
        $warehouses = DB::table('warehouses')->select('id','name')->get();
        $categories = DB::table('categories')->select('id','name')->get();
        $products = DB::table('products')->select('id','name','code')->get();
        $units = DB::table('units')->select('id','ShortName')->get();

        return view('transfers.create', compact('warehouses','products','units','categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $request->validate([
    'date' => ['required','date'],
    'from_warehouse_id' => ['required','integer','different:to_warehouse_id'],
    'to_warehouse_id' => ['required','integer'],
    'statut' => ['required','in:completed,pending,sent'],
    'notes' => ['nullable','string'],
    'category_id' => ['nullable','integer'],
    'items' => ['required','array','min:1'],
    'items.*.product_id' => ['required','integer'],
    'items.*.quantity' => ['required','numeric','min:0.0001'],
    'items.*.purchase_unit_id' => ['nullable','integer'],
]);


        DB::transaction(function () use ($request) {
            $transferId = DB::table('transfers')->insertGetId([
                'user_id' => auth()->id(),
                'Ref' => 'TR_'.substr(uniqid(), -6),
                'date' => $request->date,
                'from_warehouse_id' => $request->from_warehouse_id,
                'to_warehouse_id' => $request->to_warehouse_id,
                'items' => count($request->items),
                'GrandTotal' => 0,
                'statut' => $request->statut ?? 'completed',
                'notes' => $request->notes,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

foreach ($request->items as $row) {
    // Ambil data produk untuk mendapatkan cost
    $product = DB::table('products')->where('id', $row['product_id'])->first();
    $cost = $product->cost ?? 0;

    DB::table('transfer_details')->insert([
        'transfer_id' => $transferId,
        'product_id' => $row['product_id'],
        'purchase_unit_id' => $row['purchase_unit_id'] ?? null,
        'quantity' => $row['quantity'],
        'cost' => $cost, // ✅ masukkan cost yang diambil dari product
        'total' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Update stok di gudang asal
    $qFrom = DB::table('product_warehouse')
        ->where('product_id', $row['product_id'])
        ->where('warehouse_id', $request->from_warehouse_id)
        ->value('qte') ?? 0;

    DB::table('product_warehouse')->updateOrInsert(
        ['product_id' => $row['product_id'], 'warehouse_id' => $request->from_warehouse_id],
        ['qte' => max(0, $qFrom - $row['quantity']), 'manage_stock' => 1, 'updated_at' => now()]
    );

    // Update stok di gudang tujuan
    $qTo = DB::table('product_warehouse')
        ->where('product_id', $row['product_id'])
        ->where('warehouse_id', $request->to_warehouse_id)
        ->value('qte') ?? 0;

    DB::table('product_warehouse')->updateOrInsert(
        ['product_id' => $row['product_id'], 'warehouse_id' => $request->to_warehouse_id],
        ['qte' => $qTo + $row['quantity'], 'manage_stock' => 1, 'updated_at' => now()]
    
    );
}
        });
    
    return redirect()->route('transfers.index')->with('ok','Transfer created');

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        // Keep background as All Transfers list, open modal inline
        return redirect()->route('transfers.index', ['detail' => $id]);
    }

public function print($id)
{
    $transfer = \DB::table('transfers')->where('id', $id)->first();
    
    if (!$transfer) {
        abort(404);
    }

    $details = \DB::table('transfer_details as td')
        ->join('products as p','p.id','=','td.product_id')
        ->leftJoin('units as u','u.id','=','td.purchase_unit_id')
        ->select('td.*','p.name as product_name','p.code as product_code','u.ShortName as unit')
        ->where('td.transfer_id', $id)
        ->get();

    $fromWarehouse = \DB::table('warehouses')->where('id', $transfer->from_warehouse_id)->value('name');
    $toWarehouse = \DB::table('warehouses')->where('id', $transfer->to_warehouse_id)->value('name');

    return view('transfers.print', compact('transfer', 'details', 'fromWarehouse', 'toWarehouse'));
}

public function invoice($id)
{
    $transfer = \DB::table('transfers')->where('id', $id)->first();
    $transfer->status = $transfer->statut ?? 'pending';
    
    $details = \DB::table('transfer_details as td')
        ->join('products as p','p.id','=','td.product_id')
        ->leftJoin('units as u','u.id','=','td.purchase_unit_id')
        ->select('td.*','p.name as product_name','p.code as product_code','u.ShortName as unit')
        ->where('td.transfer_id', $id)
        ->get();

    $fromWarehouse = \DB::table('warehouses')->where('id', $transfer->from_warehouse_id)->value('name');
    $toWarehouse = \DB::table('warehouses')->where('id', $transfer->to_warehouse_id)->value('name');

    return view('transfers.invoice', compact('transfer', 'details', 'fromWarehouse', 'toWarehouse'));
}

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Transfer $transfer)
{
    $warehouses = DB::table('warehouses')->select('id','name')->get();
    $products = DB::table('products')->select('id','name','code')->get();
    $units = DB::table('units')->select('id','ShortName')->get();
    $categories = DB::table('categories')->select('id','name')->get();

    $transferDetails = DB::table('transfer_details as td')
        ->join('products as p','p.id','=','td.product_id')
        ->leftJoin('units as u','u.id','=','td.purchase_unit_id')
        ->select('td.*','p.name as product_name','p.code as product_code','u.ShortName as unit')
        ->where('td.transfer_id', $transfer->id)
        ->get();

    return view('transfers.edit', compact('transfer','warehouses','products','units','transferDetails','categories'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transfer $transfer)
    {
        $request->validate([
            'date' => ['required','date'],
            'from_warehouse_id' => ['required','integer','different:to_warehouse_id'],
            'to_warehouse_id' => ['required','integer'],
            'statut' => ['required','string','in:pending,sent,completed'],
            'notes' => ['nullable','string'],
        ]);
        DB::table('transfers')->where('id',$transfer->id)->update([
            'date'=>$request->date,
            'from_warehouse_id'=>$request->from_warehouse_id,
            'to_warehouse_id'=>$request->to_warehouse_id,
            'statut'=>$request->statut,
            'notes'=>$request->notes,
            'updated_at'=>now(),
        ]);
        return redirect()->route('transfers.index')->with('ok','Transfer updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transfer $transfer)
    {
        DB::transaction(function () use ($transfer) {
            DB::table('transfer_details')->where('transfer_id',$transfer->id)->delete();
            DB::table('transfers')->where('id',$transfer->id)->delete();
        });
        return redirect()->route('transfers.index')->with('ok','Transfer deleted');
    }

    /**
     * AJAX: search products by code or name
     */
    public function productSearch(Request $request)
    {
        $q = trim($request->get('q',''));
        $limit = max(1, (int)$request->get('limit', 20));
        $rows = DB::table('products')
            ->select('id','code','name')
            ->when($q !== '', function($qq) use ($q){
                $qq->where(function($w) use ($q){
                    $w->where('code','like',"%$q%")
                      ->orWhere('name','like',"%$q%");
                });
            })
            ->orderBy('code')
            ->limit($limit)
            ->get()
            ->map(function($r){
                return [
                    'id' => $r->id,
                    'code' => $r->code,
                    'name' => $r->name,
                    'label' => ($r->code ? ($r->code.' - ') : '').$r->name,
                ];
            });
        return response()->json($rows);
    }
}