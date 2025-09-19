PurchaseController

<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Added DB facade
// Prefer raw Dompdf if available; fallback to barryvdh facade if installed
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;

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
        $categories = DB::table('categories')->select('id','name')->orderBy('name')->get();
        $categories = DB::table('categories')->select('id','name')->orderBy('name')->get();
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
            'image' => ['nullable','image','mimes:jpeg,png,jpg,webp','max:4096'],
        ]);

        DB::transaction(function () use ($request) {
            $grand = 0;
            foreach ($request->items as $row) {
                $grand += $row['cost'] * $row['quantity'];
            }
            $imageName = null;
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $imageName = time().'_'.uniqid().'.'.$request->file('image')->getClientOriginalExtension();
                @mkdir(public_path('images/purchases'), 0755, true);
                $request->file('image')->move(public_path('images/purchases'), $imageName);
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
                'image' => $imageName,
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

    public function print(Purchase $purchase)
    {
        $details = DB::table('purchase_details as pd')
            ->join('products as p','p.id','=','pd.product_id')
            ->leftJoin('units as u','u.id','=','pd.purchase_unit_id')
            ->select('pd.*','p.name as product_name','p.code as product_code','u.ShortName as unit')
            ->where('pd.purchase_id',$purchase->id)
            ->get();
        return view('purchases.print', compact('purchase','details'));
    }

    public function invoice(Purchase $purchase)
    {
        $details = DB::table('purchase_details as pd')
            ->join('products as p','p.id','=','pd.product_id')
            ->leftJoin('units as u','u.id','=','pd.purchase_unit_id')
            ->select('pd.*','p.name as product_name','p.code as product_code','u.ShortName as unit')
            ->where('pd.purchase_id',$purchase->id)
            ->get();
        $filename = 'purchase-'.$purchase->Ref.'.pdf';
        // Try native Dompdf first
        if (class_exists(\Dompdf\Dompdf::class)) {
            $html = view('purchases.export-pdf', compact('purchase','details'))->render();
            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $options->set('isHtml5ParserEnabled', true);
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"'
            ]);
        }
        // Fallback to barryvdh facade if present
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::setOption(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true])
                ->loadView('purchases.export-pdf', compact('purchase','details'))
                ->setPaper('a4', 'portrait');
            $content = $pdf->output();
            return response($content, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"'
            ]);
        }
        // Fallback: render HTML if DomPDF not installed yet
        return view('purchases.export-pdf', compact('purchase','details'));
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
        $details = DB::table('purchase_details as pd')
            ->leftJoin('products as p','p.id','=','pd.product_id')
            ->leftJoin('units as u','u.id','=','pd.purchase_unit_id')
            ->select('pd.*','p.name as product_name','p.code as product_code','u.ShortName as unit')
            ->where('pd.purchase_id',$purchase->id)
            ->get();

        $stocks = DB::table('product_warehouse')
            ->where('warehouse_id',$purchase->warehouse_id)
            ->whereIn('product_id', $details->pluck('product_id'))
            ->pluck('qte','product_id');

        return view('purchases.edit', compact('purchase','providers','warehouses','products','units','details','stocks','categories'));
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
            'image' => ['nullable','image','mimes:jpeg,png,jpg,webp','max:4096'],
            'remove_image' => ['nullable','boolean'],
        ]);
        $update = [
            'date'=>$request->date,
            'provider_id'=>$request->provider_id,
            'warehouse_id'=>$request->warehouse_id,
            'notes'=>$request->notes,
            'updated_at'=>now(),
        ];

        if ($request->boolean('remove_image')) {
            $update['image'] = null;
        }
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time().'_'.uniqid().'.'.$request->file('image')->getClientOriginalExtension();
            @mkdir(public_path('images/purchases'), 0755, true);
            $request->file('image')->move(public_path('images/purchases'), $imageName);
            $update['image'] = $imageName;
        }

        DB::table('purchases')->where('id',$purchase->id)->update($update);
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