@extends('layouts.app')

@section('header-left')
    <div class="flex items-center space-x-3">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Create Product</h1>
            <div class="text-sm text-gray-500 flex items-center gap-3">
                <a class="font-medium text-violet-600" href="{{ route('products.index') }}">Products</a>
                <span class="text-gray-300">/</span>
                <span>Create Product</span>
            </div>
        </div>
    </div>
@endsection

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
                <div class="font-semibold mb-2">Please fix the following errors:</div>
                <ul class="space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-center space-x-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            <span>{{ $error }}</span>
                        </li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8"
            autocomplete="off" id="productForm">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Form Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Basic Information Card -->
                    <x-card>
                        <x-slot name="header">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center">
                                    <x-icon name="info" size="lg" class="text-white" />
                                </div>
                                <div>
                                    <h3 class="text-heading-4">Basic Information</h3>
                                    <p class="text-body-sm text-gray-500">Essential product details</p>
                                </div>
                            </div>
                        </x-slot>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input name="name" label="Product Name" placeholder="Enter product name" required
                                    value="{{ old('name') }}" error="{{ $errors->first('name') }}" />
                            </div>

                            <div>
                                <label class="form-label">
                                    Barcode Symbology <span class="text-red-500">*</span>
                                </label>
                                <select name="barcode_symbology" class="form-select" required>
                                    <option value="">Choose barcode</option>
                                    <option value="code128" {{ old('barcode_symbology') == 'code128' ? 'selected' : '' }}>Code
                                        128</option>
                                    <option value="ean13" {{ old('barcode_symbology') == 'ean13' ? 'selected' : '' }}>EAN-13
                                    </option>
                                    <option value="upca" {{ old('barcode_symbology') == 'upca' ? 'selected' : '' }}>UPC-A
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="form-label">
                                    Product Code <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <x-input name="code" placeholder="Enter product code" required
                                        value="{{ old('code') }}" error="{{ $errors->first('code') }}" class="pr-10" />
                                    <button type="button" onclick="generateRandomBarcode()"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 p-1 rounded hover:bg-gray-100 transition-colors"
                                        title="Generate random barcode">
                                        <x-icon name="qr-code" size="sm" class="text-gray-400 hover:text-violet-500" />
                                    </button>
                                </div>
                                <div class="mt-2 flex items-center space-x-2 text-body-sm text-gray-500">
                                    <x-icon name="info" size="sm" />
                                    <span>Scan your barcode and ensure the symbology matches</span>
                                </div>
                            </div>

                            <div>
                                <label class="form-label">
                                    Category <span class="text-red-500">*</span>
                                </label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Choose category…</option>
                                    @foreach ($categories ?? collect() as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">
                                    Warehouse <span class="text-red-500">*</span>
                                </label>
                                <select name="warehouse_id" class="form-select" {{ (isset($warehouses) && $warehouses->count()) ? 'required' : '' }}>
                                    <option value="">Choose warehouse…</option>
                                    @foreach (($warehouses ?? collect()) as $warehouse)
                                        <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                            {{ $warehouse->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('warehouse_id')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">Brand</label>
                                <select name="brand_id" class="form-select">
                                    <option value="">Choose brand…</option>
                                    @if ($brands->count())
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('brand_id')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">Project</label>
                                <select name="project_id" class="form-select">
                                    <option value="">Choose project…</option>
                                    @if (!empty($projects) && is_array($projects))
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}"
                                                {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                {{ $project->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('project_id')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">Tag</label>
                                <div class="flex gap-2">
                                    <select name="tag_id" class="form-select flex-1">
                                        <option value="">-- Choose Tag --</option>
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}"
                                                {{ old('tag_id') == $tag->id ? 'selected' : '' }}>{{ $tag->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-button type="button" onclick="openTagModal()" variant="primary" size="sm">
                                        +
                                    </x-button>
                                </div>
                                @error('tag_id')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="form-label">Description</label>
                                <textarea name="description" rows="3" class="form-textarea" placeholder="Enter product description...">{{ old('description') }}</textarea>
                                <div class="mt-1 text-right text-caption text-gray-400">
                                    <span id="charCount">0</span>/500
                                </div>
                                @error('description')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </x-card>

                    <!-- Inventory & Type Card -->
                    <x-card>
                        <x-slot name="header">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center">
                                    <x-icon name="inventory" size="lg" class="text-white" />
                                </div>
                                <div>
                                    <h3 class="text-heading-4">Inventory & Type</h3>
                                    <p class="text-body-sm text-gray-500">Product classification and stock settings</p>
                                </div>
                            </div>
                        </x-slot>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="form-label">
                                    Type <span class="text-red-500">*</span>
                                </label>
                                <select name="type" class="form-select" required>
                                    <option value="standard" {{ old('type', 'standard') == 'standard' ? 'selected' : '' }}>
                                        Standard Product</option>
                                    <option value="Non Product`" {{ old('type') == 'Non Product' ? 'selected' : '' }}>Non Product
                                    </option>
                                </select>
                                @error('type')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">
                                    Product Unit <span class="text-red-500">*</span>
                                </label>
                                <select name="product_unit_id" class="form-select" required>
                                    <option value="">Choose product unit…</option>
                                    @if ($units->count())
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}"
                                                {{ old('product_unit_id') == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->ShortName }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('product_unit_id')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="form-label">Stock Alert</label>
                                <x-input name="stock_alert" type="number" placeholder="0"
                                    value="{{ old('stock_alert', 0) }}" min="0" />
                                <div class="mt-2 flex items-center space-x-2 text-body-sm text-gray-500">
                                    <x-icon name="info" size="sm" />
                                    <span>We'll notify when stock reaches this threshold</span>
                                </div>
                                @error('stock_alert')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </x-card>
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <!-- Image Upload Section -->
                    <x-card>
                        <x-slot name="header">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center">
                                    <x-icon name="image" size="lg" class="text-white" />
                                </div>
                                <div>
                                    <h3 class="text-heading-4">Product Images</h3>
                                    <p class="text-body-sm text-gray-500">Upload multiple product photos</p>
                                </div>
                            </div>
                        </x-slot>

                        <div id="dropzone"
                            class="border-2 border-dashed border-gray-300 rounded-xl h-64 flex items-center justify-center text-center p-6 transition-all duration-300 hover:border-violet-400 hover:bg-violet-50 group">
                            <div class="max-w-sm">
                                <div
                                    class="mx-auto mb-4 text-gray-400 group-hover:text-violet-500 transition-colors duration-300">
                                    {{-- <x-icon name="upload" size="xl" /> --}}
                                </div>
                                <h4 class="text-body font-semibold text-gray-700 mb-2">Drop your images here</h4>
                                <p class="text-body-sm text-gray-500 mb-4">Drag and drop multiple images or click to browse
                                </p>
                                <label for="images"
                                    class="inline-flex items-center space-x-2 px-4 py-2 rounded-lg bg-gradient-to-r from-violet-600 to-purple-600 text-white font-semibold cursor-pointer hover:from-violet-700 hover:to-purple-700 transition-all duration-200 shadow-sm hover:shadow-md">
                                    <x-icon name="plus" size="sm" />
                                    <span>Choose Images</span>
                                </label>
                                <input id="images" name="images[]" type="file" accept="image/*" multiple
                                    class="sr-only" />
                                <p class="text-caption text-gray-400 mt-3">Supports JPG, PNG, GIF up to 10MB each</p>
                            </div>
                        </div>

                        @error('images')
                            <div class="form-error mt-4">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div class="form-error mt-4">{{ $message }}</div>
                        @enderror

                        <div id="preview" class="mt-6 grid grid-cols-2 gap-4"></div>
                    </x-card>

                    <!-- Action Buttons -->
                    <x-card>
                        <div class="space-y-4">
                            <div class="text-body-sm text-gray-500">
                                <span class="font-medium">Required fields</span> are marked with <span
                                    class="text-red-500 font-bold">*</span>
                            </div>
                            <div class="flex flex-col space-y-3">
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <x-icon name="check" size="sm" />
                                    Create Product
                                </button>
                            </div>
                        </div>
                    </x-card>
                </div>
            </div>
        </form>
    </div>

    <!-- Tag Modal -->
    <div id="tagModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-xl shadow-xl w-96">
            <h2 class="text-heading-4 mb-4">Create New Tag</h2>
            <div class="space-y-4">
                <x-input id="tagName" placeholder="Enter tag name" />
                <div>
                    <label class="form-label">Tag Color</label>
                    <input type="color" id="tagColor" class="w-full h-10 rounded-lg border border-gray-300">
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <x-button onclick="closeTagModal()" variant="secondary">
                    Cancel
                </x-button>
                <x-button onclick="submitTag()" variant="primary">
                    Create Tag
                </x-button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('images');
            const dropzone = document.getElementById('dropzone');
            const preview = document.getElementById('preview');

            // Description character counter
            const descriptionTextarea = document.querySelector('textarea[name="description"]');
            const charCount = document.getElementById('charCount');

            if (descriptionTextarea && charCount) {
                descriptionTextarea.addEventListener('input', function() {
                    const count = this.value.length;
                    charCount.textContent = count;

                    if (count > 500) {
                        charCount.classList.add('text-red-500');
                        charCount.classList.remove('text-gray-400');
                    } else {
                        charCount.classList.remove('text-red-500');
                        charCount.classList.add('text-gray-400');
                    }
                });
            }

            // Image preview functionality
            function renderPreviews(files) {
                preview.innerHTML = '';
                Array.from(files).forEach(file => {
                    if (!file.type.startsWith('image/')) return;
                    const reader = new FileReader();
                    reader.onload = e => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = file.name;
                        img.className = 'w-full h-24 object-cover rounded-lg border';
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }

            // File input change handler
            input.addEventListener('change', (e) => {
                renderPreviews(e.target.files);
            });

            // Drag and drop functionality
            ['dragenter', 'dragover'].forEach(evt => dropzone.addEventListener(evt, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('border-violet-400', 'bg-violet-50');
            }));

            ['dragleave', 'drop'].forEach(evt => dropzone.addEventListener(evt, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('border-violet-400', 'bg-violet-50');
            }));

            dropzone.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                if (!dt) return;
                const files = dt.files;
                input.files = files;
                renderPreviews(files);
            });
        });

        // Barcode generator
        function generateRandomBarcode() {
            const codeInput = document.querySelector('input[name="code"]');
            if (!codeInput) return;

            const prefix = 'PRD';
            const totalLen = 12;
            const digitsNeeded = Math.max(1, totalLen - prefix.length);
            let digits = '';
            for (let i = 0; i < digitsNeeded; i++) {
                digits += Math.floor(Math.random() * 10).toString();
            }
            const value = prefix + digits;

            codeInput.value = value;
            // Visual feedback
            codeInput.classList.add('ring-2', 'ring-violet-200', 'border-violet-400');
            setTimeout(() => {
                codeInput.classList.remove('ring-2', 'ring-violet-200', 'border-violet-400');
            }, 700);
        }

        // Tag modal functions
        function openTagModal() {
            document.getElementById('tagModal').classList.remove('hidden');
        }

        function closeTagModal() {
            document.getElementById('tagModal').classList.add('hidden');
        }

        function submitTag() {
            const name = document.getElementById('tagName').value;
            const color = document.getElementById('tagColor').value;

            fetch("{{ route('tags.ajax-create') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        name,
                        color
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const select = document.querySelector('select[name="tag_id"]');
                        const opt = document.createElement('option');
                        opt.value = data.tag.id;
                        opt.innerText = data.tag.name;
                        select.appendChild(opt);
                        select.value = data.tag.id;
                        closeTagModal();
                    }
                });
        }
    </script>
@endpush
