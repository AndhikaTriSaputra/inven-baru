@extends('layouts.app')

@section('header')
<div class="flex items-center justify-between">
    <div class="flex items-center space-x-4">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Update Product</h1>
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <span class="text-violet-600">Products</span>
                    <span>|</span>
                    <span>Update Product</span>
                </div>
            </div>
        </div>
    </div>
    <div class="flex items-center space-x-3">
        <button class="px-4 py-2 border-2 border-violet-500 text-violet-600 rounded-lg font-semibold hover:bg-violet-50 transition-all duration-200">
            POS
        </button>
        <button class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
            </svg>
        </button>
        <button class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"/>
            </svg>
        </button>
        <div class="relative">
            <button class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.5 19.5a2.5 2.5 0 01-2.5-2.5V7a2.5 2.5 0 012.5-2.5h15a2.5 2.5 0 012.5 2.5v10a2.5 2.5 0 01-2.5 2.5h-15z"/>
                </svg>
            </button>
            <span class="absolute -top-1 -right-1 bg-violet-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">1</span>
        </div>
        <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
        <button class="p-2 text-violet-600 hover:text-violet-700 hover:bg-violet-50 rounded-lg transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </button>
    </div>
</div>
@endsection

@section('content')
<form action="{{ route('products.update', $product['id']) }}" method="POST" class="space-y-6" autocomplete="off" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
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

    <!-- Main Form Container -->
    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-lg">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Basic Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Name Field -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Name <span class="text-red-500 font-bold">*</span>
                    </label>
                    <input type="text" name="name" 
                           class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300" 
                           value="{{ old('name', $product['name'] ?? '') }}" required />
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
                               value="{{ old('code', $product['code'] ?? '') }}" required />
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
                        <select name="brand_id" class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 pr-8 appearance-none text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300">
                            <option value="">Choose Brand</option>
                            @if(!empty($brands) && is_array($brands))
                                @foreach($brands as $brand)
                                    @if(is_array($brand) && isset($brand['id']) && isset($brand['name']))
                                        <option value="{{ $brand['id'] }}" {{ old('brand_id', $product['brand_id'] ?? '')==$brand['id'] ? 'selected' : '' }}>{{ $brand['name'] }}</option>
                                    @endif
                                @endforeach
                            @else
                                <option value="1" {{ old('brand_id', $product['brand_id'] ?? '1')=='1' ? 'selected' : '' }}>good</option>
                            @endif
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Tags Field -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tags</label>
                    <div class="relative">
                        <select name="tag_id" class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 pr-8 appearance-none text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300">
                            <option value="">Choose_Tags</option>
                            @if(!empty($tags) && is_array($tags))
                                @foreach($tags as $tag)
                                    @if(is_array($tag) && isset($tag['id']) && isset($tag['name']))
                                        <option value="{{ $tag['id'] }}" {{ old('tag_id', $product['tag_id'] ?? '')==$tag['id'] ? 'selected' : '' }}>{{ $tag['name'] }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Description Field -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="4" 
                              class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300">{{ old('description', $product['description'] ?? '') }}</textarea>
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

            <!-- Right Column - Inventory & Type -->
            <div class="space-y-6">
                <!-- Barcode Symbology Field -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Barcode Symbology <span class="text-red-500 font-bold">*</span>
                    </label>
                    <div class="relative">
                        <select name="barcode_symbology" class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 pr-8 appearance-none text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300" required>
                            <option value="Code 128" {{ old('barcode_symbology', $product['barcode_symbology'] ?? 'Code 128')=='Code 128' ? 'selected' : '' }}>Code 128</option>
                            <option value="Code 39" {{ old('barcode_symbology', $product['barcode_symbology'] ?? '')=='Code 39' ? 'selected' : '' }}>Code 39</option>
                            <option value="EAN-13" {{ old('barcode_symbology', $product['barcode_symbology'] ?? '')=='EAN-13' ? 'selected' : '' }}>EAN-13</option>
                            <option value="EAN-8" {{ old('barcode_symbology', $product['barcode_symbology'] ?? '')=='EAN-8' ? 'selected' : '' }}>EAN-8</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    @error('barcode_symbology')
                    <div class="mt-1 flex items-center space-x-1 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs font-medium">{{ $message }}</p>
                    </div>
                    @enderror
                </div>

                <!-- Category Field -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Category <span class="text-red-500 font-bold">*</span>
                    </label>
                    <div class="relative">
                        <select name="category_id" class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 pr-8 appearance-none text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300" required>
                            <option value="">Choose Category</option>
                            @if(!empty($categories) && is_array($categories))
                                @foreach($categories as $category)
                                    @if(is_array($category) && isset($category['id']) && isset($category['name']))
                                        <option value="{{ $category['id'] }}" {{ old('category_id', $product['category_id'] ?? '')==$category['id'] ? 'selected' : '' }}>{{ $category['name'] }}</option>
                                    @endif
                                @endforeach
                            @else
                                <option value="1" {{ old('category_id', $product['category_id'] ?? '1')=='1' ? 'selected' : '' }}>test</option>
                            @endif
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    @error('category_id')
                    <div class="mt-1 flex items-center space-x-1 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs font-medium">{{ $message }}</p>
                    </div>
                    @enderror
                </div>

                <!-- Project Field -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Project</label>
                    <div class="relative">
                        <select name="project_id" class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 pr-8 appearance-none text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300">
                            <option value="">Choose Project</option>
                            @if(!empty($projects) && is_array($projects))
                                @foreach($projects as $project)
                                    @if(is_array($project) && isset($project['id']) && isset($project['name']))
                                        <option value="{{ $project['id'] }}" {{ old('project_id', $product['project_id'] ?? '')==$project['id'] ? 'selected' : '' }}>{{ $project['name'] }}</option>
                                    @endif
                                @endforeach
                            @else
                                <option value="1" {{ old('project_id', $product['project_id'] ?? '1')=='1' ? 'selected' : '' }}>Next-G-24</option>
                            @endif
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Type Field -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Type <span class="text-red-500 font-bold">*</span>
                    </label>
                    <div class="relative">
                        <select name="type" class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 pr-8 appearance-none text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300" required>
                            <option value="standard" {{ old('type', $product['type'] ?? 'standard')=='standard' ? 'selected' : '' }}>Standard Product</option>
                            <option value="service" {{ old('type', $product['type'] ?? '')=='service' ? 'selected' : '' }}>Service</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

                <!-- Product Unit Field -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Product Unit <span class="text-red-500 font-bold">*</span>
                    </label>
                    <div class="relative">
                        <select name="product_unit_id" class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 pr-8 appearance-none text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300" required>
                            <option value="">Choose product unit…</option>
                            @if(!empty($units) && is_array($units))
                                @foreach($units as $unit)
                                    @if(is_array($unit) && isset($unit['id']) && isset($unit['name']))
                                        <option value="{{ $unit['id'] }}" {{ old('product_unit_id', $product['product_unit_id'] ?? '')==$unit['id'] ? 'selected' : '' }}>{{ $unit['name'] }}</option>
                                    @endif
                                @endforeach
                            @else
                                <option value="1" {{ old('product_unit_id', $product['product_unit_id'] ?? '1')=='1' ? 'selected' : '' }}>Pcs</option>
                            @endif
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    @error('product_unit_id')
                    <div class="mt-1 flex items-center space-x-1 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs font-medium">{{ $message }}</p>
                    </div>
                    @enderror
                </div>

                <!-- Stock Alert Field -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Stock Alert</label>
                    <div class="relative">
                        <input type="number" name="stock_alert" 
                               class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300" 
                               value="{{ old('stock_alert', $product['stock_alert'] ?? 5) }}" min="0" />
                    </div>
                    @error('stock_alert')
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

        <!-- Multiple Image Upload Section -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Multiple Image</h3>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-violet-400 transition-colors">
                <div class="flex flex-col items-center space-y-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <div class="text-gray-600">
                        <p class="font-medium">Drag & Drop Multiple images For product (or) Select</p>
                    </div>
                    <input type="file" name="images[]" multiple accept="image/*" class="hidden" id="imageUpload">
                    <button type="button" onclick="document.getElementById('imageUpload').click()" class="px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition-colors">
                        Select Images
                    </button>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-8 flex justify-end">
            <button type="submit" class="inline-flex items-center space-x-2 px-6 py-3 rounded-lg bg-gradient-to-r from-violet-600 to-purple-600 text-white font-semibold shadow-md hover:from-violet-700 hover:to-purple-700 hover:shadow-lg transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Submit</span>
            </button>
        </div>
    </div>

    <!-- Application Footer -->
    <div class="mt-8 text-center">
        <div class="bg-gray-100 rounded-2xl p-6">
            <div class="flex items-center justify-center space-x-3 mb-2">
                <span class="text-lg font-semibold text-gray-700">Stocky - Ultimate Inventory With POS</span>
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center">
                    <span class="text-white font-bold text-sm">S</span>
                </div>
            </div>
            <p class="text-sm text-gray-600">© 2025 Developed by Solusi Intek Indonesia</p>
            <p class="text-xs text-gray-500">All rights reserved - v1.1.2</p>
        </div>
    </div>
</form>
@endsection

