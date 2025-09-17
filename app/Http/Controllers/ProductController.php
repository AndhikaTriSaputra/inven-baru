<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Show the create product form.
     */
    public function create(): View
    {
        // In a real app, fetch from database. For now, pass empty arrays or examples.
        $categories = collect();
        $brands = collect();
        $projects = collect();
        $units = collect();
        $tags = collect();

        return view('products.create', compact('categories', 'brands', 'projects', 'units', 'tags'));
    }

    /**
     * Handle storing the product.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'barcode_symbology' => ['nullable', 'in:code128,ean13,upca'],
            'code' => ['required', 'string', 'max:255'],
            'category_id' => ['required'],
            'brand_id' => ['nullable'],
            'project_id' => ['nullable'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer'],
            'type' => ['required', 'in:standard,service'],
            'product_unit_id' => ['required'],
            'stock_alert' => ['nullable', 'integer', 'min:0'],
            'images' => ['nullable', 'array'],
            'images.*' => ['file', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ]);

        // Demo-only: create uploads directory if missing and store files.
        $uploadPath = public_path('uploads/products');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $storedImagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                if (!$imageFile->isValid()) {
                    continue;
                }
                $fileName = uniqid('prod_') . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move($uploadPath, $fileName);
                $storedImagePaths[] = 'uploads/products/' . $fileName;
            }
        }

        // Normally you'd create a Product model and persist $validated + $storedImagePaths.
        // For now, just flash success so the form round-trip works.
        return redirect()
            ->route('products.create')
            ->with('status', 'Product submitted successfully!');
    }
}



