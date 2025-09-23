@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Success Message -->
    @if (session('status'))
        <x-alert type="success" dismissible class="mb-6">
            {{ session('status') }}
        </x-alert>
    @endif
    
    <!-- Error Messages -->
    @if ($errors->any())
        <x-alert type="error" dismissible class="mb-6">
            <div class="space-y-1">
                @foreach ($errors->all() as $error)
                    <div class="flex items-center space-x-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        </x-alert>
    @endif

    <!-- Header Section -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-heading-2">Update Product</h1>
            <p class="text-body-sm mt-1">Edit product information and settings</p>
        </div>
        <div class="flex items-center gap-3">
            <x-button href="{{ route('products.show', $product->id) }}" variant="secondary" icon="arrow-left">
                Back to Product
            </x-button>
            <x-button onclick="window.history.back()" variant="ghost">
                Cancel
            </x-button>
        </div>
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off" id="productForm">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Form Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Basic Information Card -->
                <x-card title="Basic Information" subtitle="Essential product details">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input type="text" label="Product Name" name="name" value="{{ old('name', $product->name ?? '') }}" placeholder="Enter product name" required />
                        </div>
                        <div>
                            <x-input type="text" label="Product Code" name="code" value="{{ old('code', $product->code ?? '') }}" placeholder="Enter product code" required />
                        </div>
                        <div>
                            <x-input type="text" label="Brand" name="brand_id">
                                <option value="">Choose Brand</option>
                                @if(isset($brands) && $brands->count() > 0)
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                @else
                                    <option value="1" {{ old('brand_id', $product->brand_id ?? '1') == '1' ? 'selected' : '' }}>Default</option>
                                @endif
                            </x-input>
                        </div>
                        <div>
                            <x-input type="text" label="Tags" name="tag_id">
                                <option value="">Choose Tags</option>
                                @if(isset($tags) && $tags->count() > 0)
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}" {{ old('tag_id', $product->tag_id ?? '') == $tag->id ? 'selected' : '' }}>{{ $tag->name }}</option>
                                    @endforeach
                                @endif
                            </x-input>
                        </div>
                        <div>
                            <x-input type="text" label="Product Type" name="type" value="{{ old('type', $product->type ?? 'standard') }}" required>
                                <option value="standard" {{ old('type', $product->type ?? 'standard') == 'standard' ? 'selected' : '' }}>Standard Product</option>
                                <option value="service" {{ old('type', $product->type ?? '') == 'service' ? 'selected' : '' }}>Service</option>
                                <option value="non_product" {{ old('type', $product->type ?? '') == 'non_product' ? 'selected' : '' }}>Non Product</option>
                            </x-input>
                        </div>
                        <div>
                            <x-input type="text" label="Barcode Symbology" name="barcode_symbology" value="{{ old('barcode_symbology', $product->barcode_symbology ?? 'Code 128') }}" required>
                                <option value="Code 128" {{ old('barcode_symbology', $product->barcode_symbology ?? 'Code 128') == 'Code 128' ? 'selected' : '' }}>Code 128</option>
                                <option value="Code 39" {{ old('barcode_symbology', $product->barcode_symbology ?? '') == 'Code 39' ? 'selected' : '' }}>Code 39</option>
                                <option value="EAN-13" {{ old('barcode_symbology', $product->barcode_symbology ?? '') == 'EAN-13' ? 'selected' : '' }}>EAN-13</option>
                                <option value="EAN-8" {{ old('barcode_symbology', $product->barcode_symbology ?? '') == 'EAN-8' ? 'selected' : '' }}>EAN-8</option>
                            </x-input>
                        </div>
                        <div>
                            <x-input type="text" label="Category" name="category_id" required>
                                <option value="">Choose Category</option>
                                @if(isset($categories) && $categories->count() > 0)
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                @else
                                    <option value="1" {{ old('category_id', $product->category_id ?? '1') == '1' ? 'selected' : '' }}>Default</option>
                                @endif
                            </x-input>
                        </div>
                        <div>
                            <x-input type="text" label="Project" name="project_id">
                                <option value="">Choose Project</option>
                                @if(isset($projects) && $projects->count() > 0)
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ old('project_id', $product->project_id ?? '') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                    @endforeach
                                @else
                                    <option value="1" {{ old('project_id', $product->project_id ?? '1') == '1' ? 'selected' : '' }}>Default Project</option>
                                @endif
                            </x-input>
                        </div>
                        <div>
                            <x-input type="text" label="Product Unit" name="product_unit_id" required>
                                <option value="">Choose Unit</option>
                                @if(isset($units) && $units->count() > 0)
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" {{ old('product_unit_id', $product->product_unit_id ?? '') == $unit->id ? 'selected' : '' }}>{{ $unit->ShortName }}</option>
                                    @endforeach
                                @else
                                    <option value="1" {{ old('product_unit_id', $product->product_unit_id ?? '1') == '1' ? 'selected' : '' }}>Unit</option>
                                @endif
                            </x-input>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <x-input type="textarea" label="Description" name="description" placeholder="Enter product description">{{ old('description', $product->description ?? '') }}</x-input>
                    </div>
                </x-card>
            </div>

            <!-- Right Sidebar - Image Upload -->
            <div class="lg:col-span-1">
                <x-card title="Product Images" subtitle="Update product photos">
                    <!-- Hidden file input -->
                    <input type="file" id="imageUpload" name="images[]" multiple accept="image/*" class="hidden">

                    <!-- Upload Area -->
                    <div id="uploadArea" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-400 transition-colors duration-200 cursor-pointer bg-gray-50">
                        <div class="space-y-4">
                            <div class="mx-auto w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                                <x-icon name="upload" size="lg" class="text-gray-500" />
                            </div>
                            <p class="text-body-sm text-gray-600 font-medium">Drag & Drop Multiple images For product (or) Select</p>
                            <div class="flex items-center justify-center gap-3">
                                <x-button type="button" id="selectImagesBtn" variant="primary">
                                    Select Images
                                </x-button>
                            </div>
                        </div>
                    </div>

                    <!-- Image Preview Area -->
                    <div id="imagePreview" class="mt-4 grid grid-cols-2 gap-4 hidden"></div>

                    <!-- Current Images Section -->
                    <div class="mt-5">
                        <h4 class="text-body font-medium mb-3">Current Images:</h4>
                        @php
                            $existingImages = [];
                            if (!empty($product->image)) {
                                $existingImages = is_string($product->image) ? explode(',', $product->image) : (array) $product->image;
                                $existingImages = array_filter(array_map('trim', $existingImages));
                            }
                        @endphp
                        @if(!empty($existingImages))
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($existingImages as $img)
                                    <div class="relative">
                                        <img src="{{ asset('images/products/'.$img) }}" alt="Product Image" class="w-full h-24 object-cover rounded-lg border border-gray-200">
                                        <button type="button" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600" onclick="removeExistingImage('{{ $img }}', this)">×</button>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="w-full h-24 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center">
                                <x-icon name="products" size="lg" class="text-gray-400" />
                            </div>
                        @endif
                    </div>
                </x-card>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end mt-8">
            <x-button type="submit" variant="primary" icon="check" size="lg">
                Update Product
            </x-button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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
        uploadArea.classList.add('border-primary-400', 'bg-primary-50');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-primary-400', 'bg-primary-50');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-primary-400', 'bg-primary-50');
        
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
