@extends('layouts.app')

@section('header')
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-4 mb-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Update Product</h1>
                <div class="flex items-center space-x-2 text-sm text-gray-500 mt-1">
                    <a href="{{ route('products.index') }}" class="text-violet-600 hover:text-violet-700 transition-colors">Products</a>
                    <span>|</span>
                    <span>Update Product</span>
                </div>
            </div>
        </div>
        <div class="border-b border-gray-200"></div>
</div>

    <!-- Success Message -->
    @if (session('status'))
    <div class="mb-6 rounded-2xl border border-green-200 bg-gradient-to-r from-green-50 to-emerald-50 text-green-800 px-6 py-4 shadow-sm">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold">Success!</p>
                <p class="text-sm">{{ session('status') }}</p>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Error Messages -->
    @if ($errors->any())
    <div class="mb-6 rounded-2xl border border-red-200 bg-gradient-to-r from-red-50 to-pink-50 text-red-700 px-6 py-4 shadow-sm">
        <div class="flex items-start space-x-3">
            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="font-semibold mb-2">Please fix the following errors:</p>
                <ul class="space-y-1 text-sm">
            @foreach ($errors->all() as $error)
                        <li class="flex items-center space-x-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            <span>{{ $error }}</span>
                        </li>
            @endforeach
        </ul>
            </div>
        </div>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('products.show', $product->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-700 transition-all duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Product
        </a>
        
        <div class="flex items-center space-x-3">
            <button type="button" onclick="window.history.back()" class="px-4 py-2 border-2 border-gray-300 text-gray-600 rounded-lg font-semibold hover:bg-gray-50 transition-all duration-200">
                Cancel
            </button>
        </div>
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-6" autocomplete="off" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- Main Grid: Left form (2 cols), Right uploader (1 col) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Product details card -->
            <div class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl p-8 shadow-lg">
                <div class="grid grid-cols-1 gap-5">
                    <!-- Item Field -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Item <span class="text-red-500 font-bold">*</span>
                        </label>
                        <input type="text" name="name" 
                               class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300" 
                               value="{{ old('name', $product->name ?? '') }}" required />
                        @error('name')
                        <div class="mt-1 flex items-center space-x-1 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-xs font-medium">{{ $message }}</p>
                        </div>
                        @enderror
                    </div>

                    <!-- Code Product Field -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Code Product <span class="text-red-500 font-bold">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="code" 
                                   class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 pr-10 text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300" 
                                   value="{{ old('code', $product->code ?? '') }}" required />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-4h-2m-2-5h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4a2 2 0 012-2z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Scan your barcode and select the correct symbology below</p>
                        @error('code')
                        <div class="mt-1 flex items-center space-x-1 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-xs font-medium">{{ $message }}</p>
                        </div>
                        @enderror
                    </div>

                    <!-- Brand Field -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Brand</label>
                        <div class="relative">
                            <select name="brand_id" class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300 appearance-none bg-white">
                                <option value="">Choose Brand</option>
                                @if(isset($brands) && $brands->count() > 0)
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id ?? '')==$brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                @else
                                    <option value="1" {{ old('brand_id', $product->brand_id ?? '1')=='1' ? 'selected' : '' }}>good</option>
                                @endif
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Tags Field -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tags</label>
                        <div class="relative">
                            <select name="tag_id" class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300 appearance-none bg-white">
                                <option value="">Choose_Tags</option>
                                @if(isset($tags) && $tags->count() > 0)
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}" {{ old('tag_id', $product->tag_id ?? '')==$tag->id ? 'selected' : '' }}>{{ $tag->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Description Field -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="4" 
                                  class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300 resize-none">{{ old('description', $product->description ?? '') }}</textarea>
                    </div>

                    <!-- Type Field -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Type <span class="text-red-500 font-bold">*</span>
                        </label>
                        <div class="relative">
                            <select name="type" class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300 appearance-none bg-white" required>
                                <option value="standard" {{ old('type', $product->type ?? 'standard')=='standard' ? 'selected' : '' }}>Standard Product</option>
                                <option value="service" {{ old('type', $product->type ?? '')=='service' ? 'selected' : '' }}>Service</option>
                                <option value="non_product" {{ old('type', $product->type ?? '')=='non_product' ? 'selected' : '' }}>Non Product</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Barcode Symbology Field -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Barcode Symbology <span class="text-red-500 font-bold">*</span>
                        </label>
                        <div class="relative">
                            <select name="barcode_symbology" class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300 appearance-none bg-white" required>
                                <option value="Code 128" {{ old('barcode_symbology', $product->barcode_symbology ?? 'Code 128')=='Code 128' ? 'selected' : '' }}>Code 128</option>
                                <option value="Code 39" {{ old('barcode_symbology', $product->barcode_symbology ?? '')=='Code 39' ? 'selected' : '' }}>Code 39</option>
                                <option value="EAN-13" {{ old('barcode_symbology', $product->barcode_symbology ?? '')=='EAN-13' ? 'selected' : '' }}>EAN-13</option>
                                <option value="EAN-8" {{ old('barcode_symbology', $product->barcode_symbology ?? '')=='EAN-8' ? 'selected' : '' }}>EAN-8</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Category Field -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Category <span class="text-red-500 font-bold">*</span>
                        </label>
                        <div class="relative">
                            <select name="category_id" class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300 appearance-none bg-white" required>
                                <option value="">Choose Category</option>
                                @if(isset($categories) && $categories->count() > 0)
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '')==$category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                @else
                                    <option value="1" {{ old('category_id', $product->category_id ?? '1')=='1' ? 'selected' : '' }}>Default</option>
                                @endif
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Project Field -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Project</label>
                        <div class="relative">
                            <select name="project_id" class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300 appearance-none bg-white">
                                <option value="">Choose Project</option>
                                @if(isset($projects) && $projects->count() > 0)
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ old('project_id', $product->project_id ?? '')==$project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                    @endforeach
                                @else
                                    <option value="1" {{ old('project_id', $product->project_id ?? '1')=='1' ? 'selected' : '' }}>Rapid-ResponseBrimob2025</option>
                                @endif
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Product Unit Field -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Product Unit <span class="text-red-500 font-bold">*</span>
                        </label>
                        <div class="relative">
                            <select name="product_unit_id" class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300 appearance-none bg-white" required>
                                <option value="">Choose Unit</option>
                                @if(isset($units) && $units->count() > 0)
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" {{ old('product_unit_id', $product->product_unit_id ?? '')==$unit->id ? 'selected' : '' }}>{{ $unit->ShortName }}</option>
                                    @endforeach
                                @else
                                    <option value="1" {{ old('product_unit_id', $product->product_unit_id ?? '1')=='1' ? 'selected' : '' }}>Unit</option>
                                @endif
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>

            <!-- Right: Image uploader card -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-lg h-max lg:sticky lg:top-20">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Multiple Image</h3>

                <!-- Hidden file input -->
                <input type="file" id="imageUpload" name="images[]" multiple accept="image/*" class="hidden">

                <!-- Upload Area -->
                <div id="uploadArea" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-violet-400 transition-colors duration-200 cursor-pointer bg-gray-50">
                    <div class="space-y-4">
                        <div class="mx-auto w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-600 font-medium">Drag & Drop Multiple images For product (or) Select</p>
                        <div class="flex items-center justify-center gap-3">
                            <button type="button" id="selectImagesBtn" class="px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition-colors duration-200">Select Images</button>
                        </div>
                    </div>
                </div>

                <!-- Image Preview Area -->
                <div id="imagePreview" class="mt-4 grid grid-cols-2 gap-4 hidden"></div>

                <!-- Current Images Section -->
                <div class="mt-5">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Current Images:</h4>
                    @php
                        $existingImages = [];
                        if (!empty($product->image)) {
                            $existingImages = is_string($product->image) ? explode(',', $product->image) : (array) $product->image;
                            $existingImages = array_filter(array_map('trim', $existingImages));
                        }
                    @endphp
                    @if(!empty($existingImages))
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($existingImages as $img)
                                <div class="relative">
                                    <img src="{{ asset('images/products/'.$img) }}" alt="Product Image">
                                    <button type="button" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600" onclick="removeExistingImage('{{ $img }}', this)">×</button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="w-32 h-32 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end mt-8">
            <button type="submit" class="px-8 py-3 bg-violet-600 text-white rounded-lg font-semibold hover:bg-violet-700 transition-all duration-200 flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Update Product</span>
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Debug form submission
    const form = document.querySelector('form[action*="products.update"]');
    if (form) {
        console.log('Form found:', form);
        form.addEventListener('submit', function(e) {
            console.log('Form submitting...');
            console.log('Form action:', this.action);
            console.log('Form method:', this.method);
        });
    } else {
        console.log('Form not found!');
    }
    const imageUpload = document.getElementById('imageUpload');
    const uploadArea = document.getElementById('uploadArea');
    const selectImagesBtn = document.getElementById('selectImagesBtn');
    const imagePreview = document.getElementById('imagePreview');
    let selectedFiles = [];

    // Click to select images
    selectImagesBtn.addEventListener('click', function() {
        imageUpload.click();
    });

    // Click upload area to select images
    uploadArea.addEventListener('click', function() {
        imageUpload.click();
    });

    // Handle file selection
    imageUpload.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        selectedFiles = [...selectedFiles, ...files];
        displayImagePreviews();
    });

    // Drag and drop functionality
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('border-violet-400', 'bg-violet-50');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-violet-400', 'bg-violet-50');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-violet-400', 'bg-violet-50');
        
        const files = Array.from(e.dataTransfer.files).filter(file => file.type.startsWith('image/'));
        selectedFiles = [...selectedFiles, ...files];
        displayImagePreviews();
    });

    // Display image previews
    function displayImagePreviews() {
        if (selectedFiles.length === 0) {
            imagePreview.classList.add('hidden');
            return;
        }

        imagePreview.classList.remove('hidden');
        imagePreview.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imageDiv = document.createElement('div');
                imageDiv.className = 'relative group';
                imageDiv.innerHTML = `
                    <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-32 object-cover rounded-lg border border-gray-200">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-200 rounded-lg flex items-center justify-center">
                        <button type="button" class="opacity-0 group-hover:opacity-100 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm hover:bg-red-600 transition-all duration-200" onclick="removeImage(${index})">
                            ×
                        </button>
                    </div>
                `;
                imagePreview.appendChild(imageDiv);
            };
            reader.readAsDataURL(file);
        });
    }

    // Remove image function
    window.removeImage = function(index) {
        selectedFiles.splice(index, 1);
        displayImagePreviews();
    };

    // Remove current image function
    window.removeExistingImage = function(path, btn) {
        if (!confirm('Remove this image?')) return;
        const field = document.createElement('input');
        field.type = 'hidden';
        field.name = 'remove_images[]';
        field.value = path;
        document.querySelector('form').appendChild(field);
        const card = btn.closest('.relative');
        if (card) card.remove();
    };
});
</script>
@endpush
@endsection