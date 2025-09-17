<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // stats (pakai tabel kamu; kalau belum ada, kasih 0)
        $stats = [
            'products'   => DB::table('products')->count()      ?? 0,
            'purchases'  => DB::table('purchases')->count()     ?? 0,
            'warehouses' => DB::table('warehouses')->count()    ?? 0,
        ];

        // sales this week (7 hari terakhir) -> jumlah transaksi per hari
        $startDate = now()->subDays(6)->startOfDay();
        $endDate   = now()->endOfDay();

        $salesByDay = DB::table('sales')
            ->selectRaw('DATE(`date`) as d, COUNT(*) as c')
            ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->groupBy('d')
            ->pluck('c', 'd');

        $labels = [];
        $series = [];
        for ($i = 0; $i < 7; $i++) {
            $day = now()->subDays(6 - $i)->toDateString();
            $labels[] = $day;
            $series[] = (int) ($salesByDay[$day] ?? 0);
        }

        $chart = [
            'labels' => $labels,
            'series' => $series,
        ];

        // recent purchases (join supplier & warehouse)
        $recentPurchases = DB::table('purchases as pu')
            ->leftJoin('providers as pr', 'pr.id', '=', 'pu.provider_id')
            ->leftJoin('warehouses as w', 'w.id', '=', 'pu.warehouse_id')
            ->selectRaw('pu.date as date, pu.Ref as reference, IFNULL(w.name, "—") as warehouse, IFNULL(pr.name, "—") as supplier')
            ->orderByDesc('pu.date')
            ->limit(5)
            ->get();

        // filter gudang
        $warehouses = DB::table('warehouses')->select('id','name')->get();
        $selectedWarehouse = (int) $request->get('warehouse_id');

        // tabel bawah: contoh join sederhana (silakan sesuaikan dengan skema kamu)
        $base = DB::table('products as p')
            ->leftJoin('product_warehouse as pw','pw.product_id','=','p.id')
            ->leftJoin('warehouses as w','w.id','=','pw.warehouse_id')
            ->selectRaw('p.name as product_name, IFNULL(p.type,"Non Product") as type, p.code, GROUP_CONCAT(DISTINCT w.name ORDER BY w.name SEPARATOR ", ") as warehouse, SUM(IFNULL(pw.qte,0)) as qty')
            ->groupBy('p.id');

        if ($selectedWarehouse) {
            $base->where('w.id', $selectedWarehouse);
        }

       $rows = $base->paginate(10); // ganti ->paginate(10) kalau mau paging

        return view('dashboard.index', compact(
            'stats','chart','recentPurchases','warehouses','selectedWarehouse','rows'
        ));
    }
}
