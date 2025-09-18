<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = DB::table('warehouses')
            ->select('id','name','mobile as phone','country','city','email','zip')
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->paginate(10);

        return view('warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        // daftar parent (opsional): untuk membuat hierarki WO08 > RAK3 > ...
        $parents = DB::table('warehouses')->select('id','name')->orderBy('name')->get();

        return view('warehouses.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'mobile'    => 'nullable|string|max:50',
            'email'     => 'nullable|email|max:255',
            'country'   => 'nullable|string|max:100',
            'city'      => 'nullable|string|max:100',
            'zip'       => 'nullable|string|max:20',
            'parent_id' => 'nullable|integer|exists:warehouses,id',
        ]);

        $data['created_at'] = now();
        $data['updated_at'] = now();

        DB::table('warehouses')->insert($data);

        return redirect()->route('warehouses.index')->with('ok','Warehouse created.');
    }

    public function edit($id)
    {
        $warehouse = DB::table('warehouses')->where('id',$id)->first();
        abort_unless($warehouse, 404);

        $parents = DB::table('warehouses')->select('id','name')->orderBy('name')->get();

        return view('warehouses.edit', compact('warehouse','parents'));
    }

    public function update(Request $request, $id)
    {
        $warehouse = DB::table('warehouses')->where('id',$id)->first();
        abort_unless($warehouse, 404);

        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'mobile'    => 'nullable|string|max:50',
            'email'     => 'nullable|email|max:255',
            'country'   => 'nullable|string|max:100',
            'city'      => 'nullable|string|max:100',
            'zip'       => 'nullable|string|max:20',
            'parent_id' => 'nullable|integer|exists:warehouses,id',
        ]);

        $data['updated_at'] = now();

        DB::table('warehouses')->where('id',$id)->update($data);

        return redirect()->route('warehouses.index')->with('ok','Warehouse updated.');
    }

    public function destroy($id)
    {
        try {
            DB::table('warehouses')->where('id',$id)->delete();
            return redirect()->route('warehouses.index')->with('ok','Warehouse permanently deleted.');
        } catch (\Throwable $e) {
            // Fallback to soft delete if there are FK constraints
            DB::table('warehouses')->where('id',$id)->update([
                'deleted_at' => now(),
                'updated_at' => now(),
            ]);
            return redirect()->route('warehouses.index')->with('ok','Warehouse archived (in use by other records).');
        }
    }
}
