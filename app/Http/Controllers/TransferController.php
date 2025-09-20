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
    public function index()
    {
        $transfers = \DB::table('transfers as t')
            ->leftJoin('warehouses as wf','wf.id','=','t.from_warehouse_id')
            ->leftJoin('warehouses as wt','wt.id','=','t.to_warehouse_id')
            ->selectRaw('t.id, t.created_at as date, t.reference, IFNULL(wf.name, "—") as from_wh, IFNULL(wt.name, "—") as to_wh, t.total_amount, t.status')
            ->orderByDesc('t.created_at')
            ->paginate(10);

        return view('transfers.index', compact('transfers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $warehouses = DB::table('warehouses')->select('id','name')->get();
        $products = DB::table('products')->select('id','name','code')->get();
        $units = DB::table('units')->select('id','ShortName')->get();
        return view('transfers.create', compact('warehouses','products','units'));
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
            'notes' => ['nullable','string'],
            'items' => ['required','array','min:1'],
            'items.*.product_id' => ['required','integer'],
            'items.*.quantity' => ['required','numeric','min:0.0001'],
            'items.*.purchase_unit_id' => ['nullable','integer'],
        ]);

        DB::transaction(function () use ($request) {
            $transferId = DB::table('transfers')->insertGetId([
                'reference' => 'TR_'.substr(uniqid(),-6),
                'from_warehouse_id' => $request->from_warehouse_id,
                'to_warehouse_id' => $request->to_warehouse_id,
                'total_amount' => 0,
                'note' => $request->notes,
                'status' => 'completed',
                'created_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($request->items as $row) {
                DB::table('transfer_details')->insert([
                    'transfer_id' => $transferId,
                    'product_id' => $row['product_id'],
                    'quantity' => $row['quantity'],
                    'unit_cost' => 0,
                    'total_cost' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // decrement source warehouse
                $qFrom = DB::table('product_warehouse')
                    ->where('product_id',$row['product_id'])
                    ->where('warehouse_id',$request->from_warehouse_id)
                    ->value('qte') ?? 0;
                DB::table('product_warehouse')
                    ->updateOrInsert(
                        ['product_id'=>$row['product_id'],'warehouse_id'=>$request->from_warehouse_id],
                        ['qte'=> max(0, $qFrom - $row['quantity']), 'manage_stock'=>1, 'updated_at'=>now()]
                    );

                // increment destination warehouse
                $qTo = DB::table('product_warehouse')
                    ->where('product_id',$row['product_id'])
                    ->where('warehouse_id',$request->to_warehouse_id)
                    ->value('qte') ?? 0;
                DB::table('product_warehouse')
                    ->updateOrInsert(
                        ['product_id'=>$row['product_id'],'warehouse_id'=>$request->to_warehouse_id],
                        ['qte'=> $qTo + $row['quantity'], 'manage_stock'=>1, 'updated_at'=>now()]
                    );
            }
        });

        return redirect()->route('transfers.index')->with('ok','Transfer created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transfer = DB::table('transfers')->where('id', $id)->first();
        $details = DB::table('transfer_details as td')
            ->join('products as p','p.id','=','td.product_id')
            ->leftJoin('units as u','u.id','=','p.unit_id')
            ->select('td.*','p.name as product_name','p.code as product_code','u.ShortName as unit')
            ->where('td.transfer_id', $id)
            ->get();
        return view('transfers.show', compact('transfer','details'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $transfer = DB::table('transfers')->where('id', $id)->first();
        $warehouses = DB::table('warehouses')->select('id','name')->get();
        $products = DB::table('products')->select('id','name','code')->get();
        $units = DB::table('units')->select('id','ShortName')->get();
        $details = DB::table('transfer_details')->where('transfer_id', $id)->get();
        return view('transfers.edit', compact('transfer','warehouses','products','units','details'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'from_warehouse_id' => ['required','integer','different:to_warehouse_id'],
            'to_warehouse_id' => ['required','integer'],
            'notes' => ['nullable','string'],
        ]);
        DB::table('transfers')->where('id', $id)->update([
            'from_warehouse_id'=>$request->from_warehouse_id,
            'to_warehouse_id'=>$request->to_warehouse_id,
            'note'=>$request->notes,
            'updated_at'=>now(),
        ]);
        return redirect()->route('transfers.index')->with('ok','Transfer updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            DB::table('transfer_details')->where('transfer_id', $id)->delete();
            DB::table('transfers')->where('id', $id)->delete();
        });
        return redirect()->route('transfers.index')->with('ok','Transfer deleted');
    }
}
