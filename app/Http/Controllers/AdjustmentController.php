<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdjustmentController extends Controller
{
    // --- INDEX ---
    public function index(Request $request)
    {
        $query = DB::table('adjustments as a')
            ->select('a.id','a.Ref','a.date','a.warehouse_id','a.items','a.notes');

        if ($request->filled('q')) {
            $q = '%'.$request->q.'%';
            $query->where(function($w) use ($q){
                $w->where('a.Ref','like',$q)->orWhere('a.notes','like',$q);
            });
        }
        if ($request->filled('date')) {
            $query->whereDate('a.date', $request->date);
        }
        if ($request->filled('ref')) {
            $query->where('a.Ref','like','%'.$request->ref.'%');
        }
        if ($request->filled('warehouse_id')) {
            $query->where('a.warehouse_id', (int)$request->warehouse_id);
        }

        // for export we need all rows without pagination
        if ($request->get('export') === 'csv' || $request->get('export') === 'pdf') {
            $rows = $query->orderByDesc('a.date')->get();
            $paths = $this->warehousePaths($rows->pluck('warehouse_id')->filter()->unique()->values());
            foreach ($rows as $row) {
                $row->warehouse = $paths[$row->warehouse_id] ?? '—';
            }

            if ($request->get('export') === 'csv') {
                $filename = 'adjustments_'.now()->format('Ymd_His').'.csv';
                $headers = [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => "attachment; filename=\"$filename\"",
                ];
                $callback = function() use ($rows) {
                    $out = fopen('php://output', 'w');
                    fputcsv($out, ['Date','Reference','Warehouse','Total Products']);
                    foreach ($rows as $r) {
                        fputcsv($out, [$r->date, $r->Ref, $r->warehouse, (int)($r->items ?? 0)]);
                    }
                    fclose($out);
                };
                return response()->stream($callback, 200, $headers);
            }

            // pseudo-PDF: printable HTML view
            return view('adjustments.export', [
                'rows' => $rows,
            ]);
        }

        $adjustments = $query->orderByDesc('a.date')->paginate(10)->appends($request->query());

        $paths = $this->warehousePaths(collect($adjustments->items())->pluck('warehouse_id')->filter()->unique()->values());
        $adjustments->getCollection()->transform(function($row) use ($paths) {
            $row->warehouse = $paths[$row->warehouse_id] ?? '—';
            return $row;
        });

        $warehouseOptions = $this->warehouseOptions();

        // Inline detail modal data (when coming from Show)
        $detailHeader = null; $detailItems = collect(); $detailWarehousePath = null;
        if ($request->filled('detail')) {
            $detailId = (int)$request->get('detail');
            $detailHeader = DB::table('adjustments')->where('id', $detailId)->first();
            if ($detailHeader) {
                [$detailTable, $qtyCol] = $this->resolveAdjustmentDetailTable();
                $hasWarehouseCol = Schema::hasColumn($detailTable, 'warehouse_id');
                $q = DB::table("$detailTable as ap")->join('products as p','p.id','=','ap.product_id');
                if ($hasWarehouseCol) { $q->leftJoin('warehouses as w','w.id','=','ap.warehouse_id'); }
                $selects = ['ap.id', DB::raw("ap.$qtyCol as qty"),'ap.type','p.code','p.name'];
                if ($hasWarehouseCol) { $selects[]='ap.warehouse_id'; $selects[] = DB::raw('w.name as warehouse_name'); }
                $detailItems = $q->select($selects)->where('ap.adjustment_id',$detailId)->orderBy('ap.id')->get();
                // compute warehouse path for header
                $paths = $this->warehousePaths([$detailHeader->warehouse_id]);
                $detailWarehousePath = $paths[$detailHeader->warehouse_id] ?? '—';
            }
        }

        return view('adjustments.index', compact('adjustments','warehouseOptions','detailHeader','detailItems','detailWarehousePath'));
    }

    /** Detail (read only) */
    public function show(int $id)
    {
        // Keep background as All Adjustments list, open modal inline
        return redirect()->route('adjustments.index', ['detail' => $id]);
    }

    /** Form edit */
    public function edit(int $id)
    {
        $header = DB::table('adjustments')->where('id', $id)->first();
        abort_if(!$header, 404);
        [$detailTable, $qtyCol] = $this->resolveAdjustmentDetailTable();
        $hasWarehouseCol = Schema::hasColumn($detailTable, 'warehouse_id');

        $query = DB::table("$detailTable as ap")
            ->join('products as p', 'p.id', '=', 'ap.product_id');
        if ($hasWarehouseCol) {
            $query->leftJoin('warehouses as w', 'w.id', '=', 'ap.warehouse_id');
        }

        $selects = [
            'ap.id', DB::raw("ap.$qtyCol as qty"),'ap.type',
            'p.id as product_id','p.code','p.name',
        ];
        if ($hasWarehouseCol) {
            $selects[] = 'ap.warehouse_id';
        } else {
            $selects[] = DB::raw(((int)$header->warehouse_id).' as warehouse_id');
        }

        $items = $query->select($selects)
            ->where('ap.adjustment_id', $id)
            ->orderBy('ap.id')
            ->get();

        // opsi gudang untuk <select>
        $warehouseOptions = $this->warehouseOptions(); // [id => "WO08 > RAK3 > A"]
        $headerWarehousePath = $this->warehousePaths([$header->warehouse_id])[$header->warehouse_id] ?? '—';
        $headerWarehouseId = (int) $header->warehouse_id;
        // stok saat ini per product + warehouse (opsional, biar badge “4 Pcs” tampil)
        $stockByKey = $this->currentStocks($items->pluck('product_id')->all());

        return view('adjustments.edit', compact('header','items','warehouseOptions','stockByKey','hasWarehouseCol','headerWarehousePath','headerWarehouseId'));
    }

    /** Simpan perubahan sederhana (tanggal, notes, qty/type/warehouse detail) */
    public function update(int $id, Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'notes' => 'nullable|string',
            'rows' => 'array', // rows[n][qty], rows[n][type], rows[n][warehouse_id], rows[n][id]
        ]);

        DB::transaction(function () use ($id, $request) {
            $headerUpdate = [
                'date'  => $request->date,
                'notes' => $request->notes,
                'updated_at' => now(),
            ];
            if (!$request->input('rows') || !Schema::hasColumn($this->resolveAdjustmentDetailTable()[0], 'warehouse_id')) {
                if ($request->filled('header_warehouse_id')) {
                    $headerUpdate['warehouse_id'] = (int) $request->input('header_warehouse_id');
                }
            }
            DB::table('adjustments')->where('id', $id)->update($headerUpdate);

            [$detailTable, $qtyCol] = $this->resolveAdjustmentDetailTable();
            $hasWarehouseCol = Schema::hasColumn($detailTable, 'warehouse_id');

            foreach ($request->input('rows', []) as $row) {
                $data = [
                    $qtyCol => (int) ($row['qty'] ?? 0),
                    'type' => in_array(($row['type'] ?? ''), ['Addition','Subtraction']) ? $row['type'] : 'Addition',
                    'updated_at' => now(),
                ];
                if ($hasWarehouseCol) {
                    $data['warehouse_id'] = $row['warehouse_id'] ?? null;
                }

                if (!empty($row['id'])) {
                    DB::table($detailTable)->where('id', $row['id'])->update($data);
                } else if (!empty($row['product_id'])) {
                    $data['product_id'] = (int) $row['product_id'];
                    $data['adjustment_id'] = $id;
                    $data['created_at'] = now();
                    DB::table($detailTable)->insert($data);
                }
            }

            // refresh header items = count detail rows
            $count = DB::table($detailTable)->where('adjustment_id', $id)->count();
            DB::table('adjustments')->where('id', $id)->update(['items' => $count]);
        });

        return redirect()->route('adjustments.index')->with('ok','Adjustment updated.');
    }

    /** Create form */
    public function create()
    {
        $warehouseOptions = $this->warehouseOptions();
        $nextRef = 'AD_' . str_pad((string) (DB::table('adjustments')->max('id') + 1), 4, '0', STR_PAD_LEFT);
        [$detailTable] = $this->resolveAdjustmentDetailTable();
        $hasWarehouseCol = Schema::hasColumn($detailTable, 'warehouse_id');
        return view('adjustments.create', compact('warehouseOptions','nextRef','hasWarehouseCol'));
    }

    /** Store new adjustment with optional details */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'Ref' => 'required|string|max:192',
            'warehouse_id' => 'required|integer',
            'items' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'rows' => 'array'
        ]);

        $id = DB::table('adjustments')->insertGetId([
            'user_id' => auth()->id() ?: 1,
            'date' => $request->date,
            'Ref' => $request->Ref,
            'warehouse_id' => (int) $request->warehouse_id,
            'items' => $request->items ?? 0,
            'notes' => $request->notes,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // save detail rows if table exists
        [$detailTable, $qtyCol] = $this->resolveAdjustmentDetailTable();
        $hasWarehouseCol = Schema::hasColumn($detailTable, 'warehouse_id');
        $rows = $request->input('rows', []);
        $inserted = 0;
        foreach ($rows as $row) {
            if (empty($row['product_id'])) continue;
            $data = [
                'adjustment_id' => $id,
                'product_id' => (int) $row['product_id'],
                $qtyCol => (int) ($row['qty'] ?? 0),
                'type' => in_array(($row['type'] ?? ''), ['Addition','Subtraction']) ? $row['type'] : 'Addition',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            if ($hasWarehouseCol) {
                $data['warehouse_id'] = $row['warehouse_id'] ?? $request->warehouse_id;
            }
            DB::table($detailTable)->insert($data);
            $inserted++;
        }

        if ($inserted > 0) {
            DB::table('adjustments')->where('id',$id)->update(['items' => $inserted]);
        }

        return redirect()->route('adjustments.index')->with('ok','Adjustment created.');
    }

    /** Delete */
    public function destroy(int $id)
    {
        DB::table('adjustments')->where('id',$id)->delete();
        return back()->with('ok','Adjustment deleted.');
    }

    /** AJAX: search products by code or name */
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
    // ========== Helpers ==========

    /** Return [id => "WO08 > RAK3 > A"] */
    private function warehouseOptions(): array
    {
        $all = DB::table('warehouses')->select('id','name','parent_id')->get();
        $byId = $all->keyBy('id');
        $res = [];
        foreach ($all as $w) {
            $path = [];
            $cur = $w->id; $guard=0;
            while ($cur && $guard<30) {
                $node = $byId[$cur] ?? null;
                if (!$node) break;
                $path[] = $node->name ?? '—';
                $cur = $node->parent_id; $guard++;
            }
            $res[$w->id] = implode(' > ', array_reverse($path));
        }
        asort($res);
        return $res;
    }

    /** Build paths just for a set of IDs */
    private function warehousePaths($ids): array
    {
        if (empty($ids)) return [];
        $all = DB::table('warehouses')->select('id','name','parent_id')->get()->keyBy('id');
        $res = [];
        foreach ($ids as $wid) {
            $path=[]; $cur=$wid; $g=0;
            while ($cur && $g<30) {
                $n = $all[$cur] ?? null; if(!$n) break;
                $path[]=$n->name ?? '—'; $cur=$n->parent_id; $g++;
            }
            $res[$wid] = implode(' > ', array_reverse($path));
        }
        return $res;
    }

    /** (Opsional) ambil stok saat ini untuk badge “x Pcs” */
    private function currentStocks(array $productIds): array
    {
        if (!$productIds) return [];
        // sesuaikan dengan struktur stok kamu; ini contoh umum pakai product_warehouse.qte
        $rows = DB::table('product_warehouse')
            ->whereIn('product_id', $productIds)
            ->select('product_id', DB::raw('SUM(qte) as qty'))
            ->groupBy('product_id')->get();

        return $rows->pluck('qty','product_id')->map(fn($v)=>(int)$v)->all();
    }

    /** Resolve adjustment detail table name and qty column */
    private function resolveAdjustmentDetailTable(): array
    {
        // favored table names by likelihood
        $candidates = [
            'adjustment_details',
            'adjustment_products',
            'adjustment_detail',
            'adjustment_product',
        ];

        foreach ($candidates as $tbl) {
            if (Schema::hasTable($tbl)) {
                // determine qty column
                $qtyCol = Schema::hasColumn($tbl, 'qty') ? 'qty' : (Schema::hasColumn($tbl, 'quantity') ? 'quantity' : 'qty');
                return [$tbl, $qtyCol];
            }
        }
        // fallback
        return ['adjustment_products', 'qty'];
    }
}
