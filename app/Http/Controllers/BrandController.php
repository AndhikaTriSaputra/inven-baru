<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $brands = DB::table('brands')->orderBy('name')->get();
        return view('brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'image' => ['nullable','image','max:5120'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $uploadPath = public_path('uploads/brands');
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $file = $request->file('image');
            $fileName = uniqid('brand_') . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $fileName);
            $imagePath = 'uploads/brands/' . $fileName;
        }

        $id = DB::table('brands')->insertGetId([
            'name' => $validated['name'],
            'image' => $imagePath,
            'description' => $validated['description'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($request->wantsJson()) {
            return response()->json(['brand' => [
                'id' => $id,
                'name' => $validated['name'],
                'image' => $imagePath,
                'description' => $validated['description'] ?? null,
            ]]);
        }

        return redirect()->route('brands.index')->with('ok','Brand created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand): View
    {
        return view('brands.edit', ['brand' => (array) $brand]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'image' => ['nullable','image','max:5120'],
        ]);

        $imagePath = $brand->image;
        if ($request->hasFile('image')) {
            $uploadPath = public_path('uploads/brands');
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $file = $request->file('image');
            $fileName = uniqid('brand_') . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $fileName);
            $imagePath = 'uploads/brands/' . $fileName;
        }

        DB::table('brands')->where('id',$brand->id)->update([
            'name' => $validated['name'],
            'image' => $imagePath,
            'description' => $validated['description'] ?? null,
            'updated_at' => now(),
        ]);

        return redirect()->route('brands.index')->with('ok','Brand updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand): RedirectResponse
    {
        DB::table('brands')->where('id',$brand->id)->delete();
        return redirect()->route('brands.index')->with('ok','Brand deleted');
    }
}
