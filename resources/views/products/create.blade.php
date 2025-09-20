

@extends('layouts.app')

@section('header')
<div class="flex items-center space-x-4">
    <div class="flex items-center space-x-3">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Create Product</h1>
            <p class="text-sm text-gray-500">Add a new product to your inventory</p>
        </div>
    </div>
</div>
@endsection

@section('content')
<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 relative z-10" autocomplete="off" id="productForm">
    @csrf
    
    <!-- Success Message -->
    @if (session('status'))
    <div class="rounded-2xl border border-green-200 bg-gradient-to-r from-green-50 to-emerald-50 text-green-800 px-6 py-4 shadow-sm">
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
    <div class="rounded-2xl border border-red-200 bg-gradient-to-r from-red-50 to-pink-50 text-red-700 px-6 py-4 shadow-sm">
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
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Basic Information Card -->
            <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Basic Information</h3>
                        <p class="text-sm text-gray-500">Essential product details</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Product Name 
                        <span class="text-red-500 font-bold">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="name" value="{{ old('name') }}" 
                               class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300" 
                               placeholder="Enter product name" required />
                        <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                    </div>
                    @error('name')
                    <div class="mt-1 flex items-center space-x-1 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs font-medium">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Barcode Symbology 
                        <span class="text-red-500 font-bold">*</span>
                    </label>
                    <div class="relative">
                        <select name="barcode_symbology" class="w-full rounded-lg border-2 border-gray-200 px-2.5 py-2 pr-8 appearance-none text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300" required>
                            <option value="">Choose barcode</option>
                            <option value="code128" {{ old('barcode_symbology')=='code128' ? 'selected' : '' }}>Code 128</option>
                            <option value="ean13" {{ old('barcode_symbology')=='ean13' ? 'selected' : '' }}>EAN-13</option>
                            <option value="upca" {{ old('barcode_symbology')=='upca' ? 'selected' : '' }}>UPC-A</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-2.5 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Product Code 
                        <span class="text-red-500 font-bold">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="code" value="{{ old('code') }}" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false"
                               class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 pr-10 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300" 
                               placeholder="Enter product code" required />
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <button type="button" onclick="generateRandomBarcode()" class="p-1 rounded hover:bg-gray-100 transition-colors duration-200 cursor-pointer" title="Generate random barcode">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 hover:text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="mt-2 flex items-center space-x-2 text-sm text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm">Scan your barcode and ensure the symbology matches</span>
                    </div>
                    
                    @error('code')
                    <div class="mt-1 flex items-center space-x-1 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs font-medium">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Category 
                        <span class="text-red-500 font-bold">*</span>
                    </label>
                    <div class="relative">
                        <select name="category_id" class="w-full rounded-lg border-2 border-gray-200 px-2.5 py-2 pr-8 appearance-none text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300" required>
                            <option value="">Choose category…</option>
                            @foreach(($categories ?? collect()) as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach

                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-2.5 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    @error('category_id')
                    <div class="mt-2 flex items-center space-x-2 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm font-medium">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Brand</label>
                    <div class="relative">
                        <select name="brand_id" id="brand_id" class="w-full rounded-lg border-2 border-gray-200 px-2.5 py-2 pr-8 appearance-none text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300">
                            <option value="">Choose brand…</option>
                            @if($brands->count())
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            @endif

                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-2.5 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    @error('brand_id')
                    <div class="mt-2 flex items-center space-x-2 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm font-medium">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Project</label>
                    <div class="relative">
                        <select name="project_id" class="w-full rounded-lg border-2 border-gray-200 px-2.5 py-2 pr-8 appearance-none text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300">
                            <option value="">Choose project…</option>
                            @if(!empty($projects) && is_array($projects))
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-2.5 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    @error('project_id')
                    <div class="mt-2 flex items-center space-x-2 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm font-medium">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
                <div>
                    <!-- <label class="block text-sm font-semibold text-gray-700 mb-2">Tag</label>
                    <div class="relative">
                        <select name="tag_id" id="tag_id" class="w-full rounded-lg border-2 border-gray-200 px-2.5 py-2 pr-8 appearance-none text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300">
                            <option value="">Choose tag…</option>
                             @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-2.5 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                     -->

                     <div class="flex gap-2">
    <select name="tag_id" id="tag_id" class="form-select flex-1">
        <option value="">-- Choose Tag --</option>
        @foreach($tags as $tag)
            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
        @endforeach
    </select>
    <button type="button" onclick="openTagModal()" class="px-3 py-1 text-white bg-violet-500 rounded hover:bg-violet-600">
        +
    </button>
</div>


<div id="tagModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow w-96">
        <h2 class="text-lg font-bold mb-2">Create New Tag</h2>
        <input type="text" id="tagName" class="w-full mb-2 p-2 border rounded" placeholder="Enter tag name">
        <label class="text-sm mb-1 block">Tag Color</label>
        <input type="color" id="tagColor" class="w-full mb-4">
        <div class="flex justify-end gap-2">
            <button onclick="closeTagModal()" class="border px-4 py-1 rounded">Cancel</button>
            <button onclick="submitTag()" class="bg-violet-600 text-white px-4 py-1 rounded">OK</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
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
        body: JSON.stringify({ name, color })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const select = document.getElementById('tag_id');
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

                    @error('tag_id')
                    <div class="mt-1 flex items-center space-x-1 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs font-medium">{{ $message }}</p>
                    </div>
                        @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <div class="relative">
                        <textarea name="description" rows="3" 
                                  class="w-full rounded-lg border-2 border-gray-200 px-2.5 py-2 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300 resize-none" 
                                  placeholder="Enter product description...">{{ old('description') }}</textarea>
                        <div class="absolute bottom-1.5 right-1.5 text-xs text-gray-400">
                            <span id="charCount">0</span>/500
                        </div>
                    </div>
                    @error('description')
                    <div class="mt-1 flex items-center space-x-1 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs font-medium">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Inventory & Type Card -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Inventory & Type</h3>
                    <p class="text-sm text-gray-500">Product classification and stock settings</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Type 
                        <span class="text-red-500 font-bold">*</span>
                    </label>
                    <div class="relative">
                        <select name="type" class="w-full h-10 rounded-lg border-2 border-gray-200 px-2.5 pr-8 appearance-none text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300" required>
                            <option value="standard" {{ old('type','standard')=='standard' ? 'selected' : '' }}>Standard Product</option>
                            <option value="service" {{ old('type')=='service' ? 'selected' : '' }}>Service</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-2.5 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    @error('type')
                    <div class="mt-1 flex items-center space-x-1 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs font-medium">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Product Unit 
                        <span class="text-red-500 font-bold">*</span>
                    </label>
                    <div class="relative">
                        <select name="product_unit_id"id="product_unit_id" class="w-full h-10 rounded-lg border-2 border-gray-200 px-2.5 pr-8 appearance-none text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300" required>
                            <option value="">Choose product unit…</option>
                            @if($units->count())
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->ShortName }}</option>
                                @endforeach
                            @endif


                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-2.5 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    @error('product_unit_id')
                    <div class="mt-2 flex items-center space-x-2 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm font-medium">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Stock Alert</label>
                    <div class="relative">
                        <input type="number" name="stock_alert" 
                               class="w-full rounded-lg border-2 border-gray-200 px-2.5 py-2 text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300" 
                               value="{{ old('stock_alert', 0) }}" min="0" />
                    </div>
                    <div class="mt-2 flex items-center space-x-2 text-sm text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>We'll notify when stock reaches this threshold</span>
                    </div>
                    @error('stock_alert')
                    <div class="mt-2 flex items-center space-x-2 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm font-medium">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        <span class="font-medium">Required fields</span> are marked with <span class="text-red-500 font-bold">*</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-lg border-2 border-gray-200 text-gray-700 text-sm font-semibold hover:border-gray-300 hover:bg-gray-50 transition-all duration-200">
                            Cancel
                        </a>
                        <div class="sticky bottom-0 left-0 right-0 z-50 bg-violet-50 border-t border-gray-200 px-6 py-4 flex justify-end">
<button type="submit" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg text-white bg-[#9b5de5] hover:bg-[#8c4bd4] transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current" viewBox="0 0 512 512"><path d="M256 0C114.615 0 0 114.615 0 256s114.615 256 256 256 256-114.615 256-256S397.385 0 256 0zm0 482C132.487 482 30 379.513 30 256S132.487 30 256 30s226 102.487 226 226-102.487 226-226 226z"/><path d="M378.305 173.897l-162.798 162.8-81.803-81.802c-5.857-5.858-15.355-5.858-21.213 0s-5.858 15.355 0 21.213l92.414 92.414c2.929 2.93 6.768 4.394 10.606 4.394s7.677-1.465 10.606-4.394l173.404-173.403c5.858-5.858 5.858-15.355 0-21.213-5.857-5.858-15.355-5.858-21.213 0z"/></svg>
    Submit
</button>

</div>

                        

                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Image Upload Section -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Product Images</h3>
                    <p class="text-sm text-gray-500">Upload multiple product photos</p>
                </div>
            </div>
            
            <div id="dropzone" class="border-2 border-dashed border-gray-300 rounded-2xl h-80 flex items-center justify-center text-center p-8 transition-all duration-300 hover:border-violet-400 hover:bg-violet-50 group">
                <div class="max-w-md">
                    <div class="mx-auto mb-4 text-gray-400 group-hover:text-violet-500 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Drop your images here</h4>
                    <p class="text-sm text-gray-500 mb-4">Drag and drop multiple images or click to browse</p>
                    <label for="images" class="inline-flex items-center space-x-2 px-6 py-3 rounded-xl bg-gradient-to-r from-violet-600 to-purple-600 text-white font-semibold cursor-pointer hover:from-violet-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Choose Images</span>
                    </label>
                    <input id="images" name="images[]" type="file" accept="image/*" multiple class="sr-only" />
                    <p class="text-xs text-gray-400 mt-3">Supports JPG, PNG, GIF up to 10MB each</p>
                </div>
            </div>
            
            @error('images')
            <div class="mt-4 flex items-center space-x-2 text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-medium">{{ $message }}</p>
            </div>
            @enderror
            @error('images.*')
            <div class="mt-4 flex items-center space-x-2 text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-medium">{{ $message }}</p>
            </div>
            @enderror
            
            <div id="preview" class="mt-6 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4"></div>
        </div>
    </div>
   

</form>
@endsection

@push('scripts')
<script>
// Rely on native required + backend validation. No JS blocking on submit
document.addEventListener('DOMContentLoaded', function () {
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
    
    // Barcode generator: PRD + 9 random digits
    function generateRandomBarcode() {
        // Find the code input field
        const codeInput = document.querySelector('input[name="code"]');
        if (!codeInput) {
            console.error('Code input field not found!');
            return;
        }

        // Generate PRD + 9 random digits
        const prefix = 'PRD';
        let digits = '';
        for (let i = 0; i < 9; i++) {
            digits += Math.floor(Math.random() * 10).toString();
        }
        const barcode = prefix + digits;

        // Set the value
        codeInput.value = barcode;
        
        // Visual feedback
        codeInput.style.borderColor = '#8B5CF6';
        codeInput.style.backgroundColor = '#F3F4F6';
        setTimeout(() => {
            codeInput.style.borderColor = '';
            codeInput.style.backgroundColor = '';
        }, 1000);
        
        // Focus on the input
        codeInput.focus();
    }
    
    // Make function globally available (triggered by clicking the barcode icon)
    window.generateRandomBarcode = generateRandomBarcode;

    // Keyboard shortcut for barcode generation (Ctrl+G)
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'g') {
            e.preventDefault();
            generateRandomBarcode();
        }
    });

    // Alternative event listener for barcode button
    document.addEventListener('DOMContentLoaded', function() {
        const barcodeButton = document.querySelector('button[onclick="generateRandomBarcode()"]');
        if (barcodeButton) {
            barcodeButton.addEventListener('click', function(e) {
                e.preventDefault();
                generateRandomBarcode();
            });
        }
    });

    // Do not auto-generate on load; keep empty by default. Use the button to generate when needed.
    
    // Tags chips/select
    const tagsSelect = document.getElementById('tagsSelect');
    const tagsChips = document.getElementById('tagsChips');
    const tagsSearch = document.getElementById('tagsSearch');
    const tagsMenu = document.getElementById('tagsMenu');
    const tagsList = document.getElementById('tagsList');

    function renderPreviews(files) {
        preview.innerHTML = '';
        Array.from(files).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = file.name;
                img.className = 'w-full h-28 object-cover rounded-lg border';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }

    input.addEventListener('change', (e) => {
        renderPreviews(e.target.files);
    });

    ['dragenter','dragover'].forEach(evt => dropzone.addEventListener(evt, (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropzone.classList.add('border-violet-400','bg-violet-50');
    }));
    ['dragleave','drop'].forEach(evt => dropzone.addEventListener(evt, (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropzone.classList.remove('border-violet-400','bg-violet-50');
    }));
    dropzone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        if (!dt) return;
        const files = dt.files;
        input.files = files;
        renderPreviews(files);
    });

    // Helpers for tags UI
    function getAllOptions() {
        return Array.from(tagsSelect.options).map(o => ({ id: o.value, name: o.text, selected: o.selected }));
    }
    function renderChips() {
        // remove existing chips except the input
        Array.from(tagsChips.querySelectorAll('[data-chip]')).forEach(el => el.remove());
        getAllOptions().filter(o => o.selected).forEach(opt => {
            const chip = document.createElement('span');
            chip.dataset.chip = '1';
            chip.className = 'inline-flex items-center gap-1 bg-violet-50 text-violet-700 border border-violet-200 px-2 py-0.5 rounded-full text-xs';
            chip.innerHTML = <span>${opt.name}</span>;
            const closeBtn = document.createElement('button');
            closeBtn.type = 'button';
            closeBtn.className = 'text-violet-600 hover:text-violet-800';
            closeBtn.innerHTML = '&times;';
            closeBtn.addEventListener('click', () => {
                const option = Array.from(tagsSelect.options).find(o => o.value === opt.id);
                if (option) option.selected = false;
                renderChips();
                renderMenu(tagsSearch.value);
            });
            chip.appendChild(closeBtn);
            tagsChips.insertBefore(chip, tagsSearch);
        });
    }
    function renderMenu(query='') {
        const q = query.toLowerCase().trim();
        const options = getAllOptions().filter(o => !o.selected && (!q || o.name.toLowerCase().includes(q)));
        tagsList.innerHTML = '';
        if (options.length === 0) {
            const li = document.createElement('li');
            li.className = 'px-2 py-2 text-gray-400';
            li.textContent = 'No matches';
            tagsList.appendChild(li);
            return;
        }
        options.forEach((opt, idx) => {
            const li = document.createElement('li');
            li.tabIndex = 0;
            li.dataset.id = opt.id;
            li.className = 'px-2 py-2 hover:bg-violet-50 cursor-pointer';
            li.textContent = opt.name;
            li.addEventListener('click', () => selectTag(opt.id));
            if (idx === 0) li.classList.add('bg-violet-50');
            tagsList.appendChild(li);
        });
    }
    function selectTag(id) {
        const option = Array.from(tagsSelect.options).find(o => o.value === id);
        if (option) option.selected = true;
        tagsSearch.value = '';
        renderChips();
        renderMenu('');
        hideMenu();
        tagsSearch.focus();
    }
    function showMenu() { tagsMenu.classList.remove('hidden'); }
    function hideMenu() { tagsMenu.classList.add('hidden'); }

    tagsSearch.addEventListener('focus', () => { renderMenu(tagsSearch.value); showMenu(); });
    tagsSearch.addEventListener('input', () => { renderMenu(tagsSearch.value); showMenu(); });
    tagsSearch.addEventListener('keydown', (e) => {
        const items = Array.from(tagsList.querySelectorAll('li'));
        const current = items.findIndex(li => li.classList.contains('bg-violet-50'));
        if (e.key === 'ArrowDown') { e.preventDefault(); if (items.length) { if (current>=0) items[current].classList.remove('bg-violet-50'); const next = items[Math.min(current+1, items.length-1)]; next.classList.add('bg-violet-50'); next.scrollIntoView({block:'nearest'}); } }
        if (e.key === 'ArrowUp') { e.preventDefault(); if (items.length) { if (current>=0) items[current].classList.remove('bg-violet-50'); const prev = items[Math.max(current-1, 0)]; prev.classList.add('bg-violet-50'); prev.scrollIntoView({block:'nearest'}); } }
        if (e.key === 'Enter') { e.preventDefault(); const focused = items.find(li => li.classList.contains('bg-violet-50')); if (focused) selectTag(focused.dataset.id); }
        if (e.key === 'Escape') { hideMenu(); }
    });
    document.addEventListener('click', (e) => {
        if (!tagsChips.contains(e.target) && !tagsMenu.contains(e.target)) hideMenu();
    });
    // initial render for old values
    renderChips();
});
</script>
@endpush