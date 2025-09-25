@extends('layouts.app')

@section('header-left')
<div class="flex items-center space-x-3">
    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
    </div>

    
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Product Details</h1>
        <div class="flex items-center space-x-2 text-sm text-gray-500">
            <span class="text-violet-600">Products</span>
            <span>|</span>
            <span>Product Details</span>
        </div>
    </div>
</div>
@endsection

@section('header-right')
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
@endsection

@section('content')
<div class="space-y-6">
    <!-- Print Button -->
    <div class="flex justify-end">
        <button class="inline-flex items-center space-x-2 px-4 py-2 bg-violet-100 text-violet-700 rounded-lg font-semibold hover:bg-violet-200 transition-all duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            <span>Print</span>
        </button>
    </div>

    <!-- Top Barcode -->
    <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-lg">
        <div class="mx-auto flex flex-col items-center justify-center max-w-xl">
            <svg class="block" width="280" height="160" viewBox="0 0 160 160" preserveAspectRatio="xMidYMid meet" aria-label="Product barcode">
                <g transform="translate(6,0)">
                <rect x="10" y="20" width="2" height="120" fill="black"/>
                <rect x="15" y="20" width="1" height="120" fill="black"/>
                <rect x="19" y="20" width="2" height="120" fill="black"/>
                <rect x="24" y="20" width="1" height="120" fill="black"/>
                <rect x="28" y="20" width="2" height="120" fill="black"/>
                <rect x="33" y="20" width="1" height="120" fill="black"/>
                <rect x="37" y="20" width="2" height="120" fill="black"/>
                <rect x="42" y="20" width="1" height="120" fill="black"/>
                <rect x="46" y="20" width="2" height="120" fill="black"/>
                <rect x="51" y="20" width="1" height="120" fill="black"/>
                <rect x="55" y="20" width="2" height="120" fill="black"/>
                <rect x="60" y="20" width="1" height="120" fill="black"/>
                <rect x="64" y="20" width="2" height="120" fill="black"/>
                <rect x="69" y="20" width="1" height="120" fill="black"/>
                <rect x="73" y="20" width="2" height="120" fill="black"/>
                <rect x="78" y="20" width="1" height="120" fill="black"/>
                <rect x="82" y="20" width="2" height="120" fill="black"/>
                <rect x="87" y="20" width="1" height="120" fill="black"/>
                <rect x="91" y="20" width="2" height="120" fill="black"/>
                <rect x="96" y="20" width="1" height="120" fill="black"/>
                <rect x="100" y="20" width="2" height="120" fill="black"/>
                <rect x="105" y="20" width="1" height="120" fill="black"/>
                <rect x="109" y="20" width="2" height="120" fill="black"/>
                <rect x="114" y="20" width="1" height="120" fill="black"/>
                <rect x="118" y="20" width="2" height="120" fill="black"/>
                <rect x="123" y="20" width="1" height="120" fill="black"/>
                <rect x="127" y="20" width="2" height="120" fill="black"/>
                <rect x="132" y="20" width="1" height="120" fill="black"/>
                <rect x="136" y="20" width="2" height="120" fill="black"/>
                </g>
            </svg>
            <div class="mt-4 inline-flex items-center justify-center px-4 py-1.5 rounded-lg border border-gray-200 bg-gray-50 text-gray-900 font-semibold tracking-wider text-sm select-all">
                {{ $product->code ?? 'No Code' }}
            </div>
        </div>
    </div>

    <!-- Details table -->
    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-lg">
        <table class="w-full text-sm">
            <tbody class="divide-y divide-gray-200">
                <tr>
                    <td class="w-1/3 px-6 py-4 text-gray-600">Type</td>
                    <td class="px-6 py-4 font-semibold text-gray-900">{{ ucfirst($product->type ?? 'standard') }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 text-gray-600">Code Product</td>
                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $product->code ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 text-gray-600">Product</td>
                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $product->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 text-gray-600">Category</td>
                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $product->category ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 text-gray-600">Brand</td>
                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $product->brand ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 text-gray-600">Unit</td>
                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $product->unit ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 text-gray-600">Tags</td>
                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $product->tags ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Warehouse Inventory Section -->
    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Warehouse Inventory</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Warehouse</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Quantity</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @if(!empty($product->warehouse_inventory) && is_array($product->warehouse_inventory))
                        @foreach($product->warehouse_inventory as $inventory)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $inventory['warehouse'] ?? 'Unknown Warehouse' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ number_format($inventory['quantity'] ?? 0, 2) }} {{ $product->unit ?? 'Pcs' }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2" class="px-4 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center space-y-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    <span class="text-sm font-medium">No warehouse inventory data available</span>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
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
</div>
@endsection