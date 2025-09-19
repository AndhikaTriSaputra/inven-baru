<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $units = DB::table('units')->orderBy('name')->get();
        return view('units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'ShortName' => ['nullable','string','max:50'],
        ]);
        DB::table('units')->insert([
            'name' => $validated['name'],
            'ShortName' => $validated['ShortName'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('units.index')->with('ok','Unit created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit): View
    {
        return view('units.edit', ['unit' => (array) $unit]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'ShortName' => ['nullable','string','max:50'],
        ]);
        DB::table('units')->where('id',$unit->id)->update([
            'name' => $validated['name'],
            'ShortName' => $validated['ShortName'] ?? null,
            'updated_at' => now(),
        ]);
        return redirect()->route('units.index')->with('ok','Unit updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit): RedirectResponse
    {
        DB::table('units')->where('id',$unit->id)->delete();
        return redirect()->route('units.index')->with('ok','Unit deleted');
    }
}
