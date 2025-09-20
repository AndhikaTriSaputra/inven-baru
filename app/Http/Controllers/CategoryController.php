<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = DB::table('categories')->orderBy('name')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'code' => ['nullable','string','max:255'],
        ]);

        $id = DB::table('categories')->insertGetId([
            'name' => $validated['name'],
            'code' => $validated['code'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($request->wantsJson()) {
            return response()->json(['category' => ['id' => $id, 'name' => $validated['name'], 'code' => $validated['code'] ?? null]]);
        }

        return redirect()->route('categories.index')->with('ok','Category created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): View
    {
        return view('categories.show', ['category' => (array) $category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        return view('categories.edit', ['category' => (array) $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'code' => ['nullable','string','max:255'],
        ]);

        DB::table('categories')->where('id', $category->id)->update([
            'name' => $validated['name'],
            'code' => $validated['code'] ?? null,
            'updated_at' => now(),
        ]);

        if ($request->wantsJson()) {
            return response()->json(['category' => ['id' => $category->id, 'name' => $validated['name'], 'code' => $validated['code'] ?? null]]);
        }

        return redirect()->route('categories.index')->with('ok','Category updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category)
    {
        DB::table('categories')->where('id',$category->id)->delete();
        
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Category deleted']);
        }
        
        return redirect()->route('categories.index')->with('ok','Category deleted');
    }
}
