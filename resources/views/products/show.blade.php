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

    

    <!-- Product Information -->
    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-6">Product Information</h3>
        <div class="overflow-hidden rounded-xl border border-gray-200">
            <table class="w-full border-collapse">
                <tbody class="divide-y divide-gray-200">
                    <!-- Barcode merged row -->
                    <tr>
                        <td colspan="2" class="px-5 py-5">
                            <div class="flex flex-col items-center text-center">
                                <svg width="220" height="60" viewBox="0 0 300 80" class="mx-auto">
                                    <rect x="10" y="10" width="2" height="60" fill="black"/>
                                    <rect x="14" y="10" width="1" height="60" fill="black"/>
                                    <rect x="17" y="10" width="2" height="60" fill="black"/>
                                    <rect x="21" y="10" width="1" height="60" fill="black"/>
                                    <rect x="24" y="10" width="2" height="60" fill="black"/>
                                    <rect x="28" y="10" width="1" height="60" fill="black"/>
                                    <rect x="31" y="10" width="2" height="60" fill="black"/>
                                    <rect x="35" y="10" width="1" height="60" fill="black"/>
                                    <rect x="38" y="10" width="2" height="60" fill="black"/>
                                    <rect x="42" y="10" width="1" height="60" fill="black"/>
                                    <rect x="45" y="10" width="2" height="60" fill="black"/>
                                    <rect x="49" y="10" width="1" height="60" fill="black"/>
                                    <rect x="52" y="10" width="2" height="60" fill="black"/>
                                    <rect x="56" y="10" width="1" height="60" fill="black"/>
                                    <rect x="59" y="10" width="2" height="60" fill="black"/>
                                    <rect x="63" y="10" width="1" height="60" fill="black"/>
                                    <rect x="66" y="10" width="2" height="60" fill="black"/>
                                    <rect x="70" y="10" width="1" height="60" fill="black"/>
                                    <rect x="73" y="10" width="2" height="60" fill="black"/>
                                    <rect x="77" y="10" width="1" height="60" fill="black"/>
                                    <rect x="80" y="10" width="2" height="60" fill="black"/>
                                    <rect x="84" y="10" width="1" height="60" fill="black"/>
                                    <rect x="87" y="10" width="2" height="60" fill="black"/>
                                    <rect x="91" y="10" width="1" height="60" fill="black"/>
                                    <rect x="94" y="10" width="2" height="60" fill="black"/>
                                    <rect x="98" y="10" width="1" height="60" fill="black"/>
                                    <rect x="101" y="10" width="2" height="60" fill="black"/>
                                    <rect x="105" y="10" width="1" height="60" fill="black"/>
                                    <rect x="108" y="10" width="2" height="60" fill="black"/>
                                    <rect x="112" y="10" width="1" height="60" fill="black"/>
                                    <rect x="115" y="10" width="2" height="60" fill="black"/>
                                    <rect x="119" y="10" width="1" height="60" fill="black"/>
                                    <rect x="122" y="10" width="2" height="60" fill="black"/>
                                    <rect x="126" y="10" width="1" height="60" fill="black"/>
                                    <rect x="129" y="10" width="2" height="60" fill="black"/>
                                    <rect x="133" y="10" width="1" height="60" fill="black"/>
                                    <rect x="136" y="10" width="2" height="60" fill="black"/>
                                    <rect x="140" y="10" width="1" height="60" fill="black"/>
                                    <rect x="143" y="10" width="2" height="60" fill="black"/>
                                    <rect x="147" y="10" width="1" height="60" fill="black"/>
                                    <rect x="150" y="10" width="2" height="60" fill="black"/>
                                    <rect x="154" y="10" width="1" height="60" fill="black"/>
                                    <rect x="157" y="10" width="2" height="60" fill="black"/>
                                    <rect x="161" y="10" width="1" height="60" fill="black"/>
                                    <rect x="164" y="10" width="2" height="60" fill="black"/>
                                    <rect x="168" y="10" width="1" height="60" fill="black"/>
                                    <rect x="171" y="10" width="2" height="60" fill="black"/>
                                    <rect x="175" y="10" width="1" height="60" fill="black"/>
                                    <rect x="178" y="10" width="2" height="60" fill="black"/>
                                    <rect x="182" y="10" width="1" height="60" fill="black"/>
                                    <rect x="185" y="10" width="2" height="60" fill="black"/>
                                    <rect x="189" y="10" width="1" height="60" fill="black"/>
                                    <rect x="192" y="10" width="2" height="60" fill="black"/>
                                    <rect x="196" y="10" width="1" height="60" fill="black"/>
                                    <rect x="199" y="10" width="1" height="60" fill="black"/>
                                    <rect x="202" y="10" width="2" height="60" fill="black"/>
                                    <rect x="206" y="10" width="1" height="60" fill="black"/>
                                    <rect x="209" y="10" width="2" height="60" fill="black"/>
                                    <rect x="213" y="10" width="1" height="60" fill="black"/>
                                    <rect x="216" y="10" width="2" height="60" fill="black"/>
                                    <rect x="220" y="10" width="1" height="60" fill="black"/>
                                    <rect x="223" y="10" width="2" height="60" fill="black"/>
                                    <rect x="227" y="10" width="1" height="60" fill="black"/>
                                    <rect x="230" y="10" width="2" height="60" fill="black"/>
                                    <rect x="234" y="10" width="1" height="60" fill="black"/>
                                    <rect x="237" y="10" width="2" height="60" fill="black"/>
                                    <rect x="241" y="10" width="1" height="60" fill="black"/>
                                    <rect x="244" y="10" width="2" height="60" fill="black"/>
                                    <rect x="248" y="10" width="1" height="60" fill="black"/>
                                    <rect x="251" y="10" width="2" height="60" fill="black"/>
                                    <rect x="255" y="10" width="1" height="60" fill="black"/>
                                    <rect x="258" y="10" width="2" height="60" fill="black"/>
                                    <rect x="262" y="10" width="1" height="60" fill="black"/>
                                    <rect x="265" y="10" width="2" height="60" fill="black"/>
                                    <rect x="269" y="10" width="1" height="60" fill="black"/>
                                    <rect x="272" y="10" width="2" height="60" fill="black"/>
                                    <rect x="276" y="10" width="1" height="60" fill="black"/>
                                    <rect x="279" y="10" width="2" height="60" fill="black"/>
                                    <rect x="283" y="10" width="1" height="60" fill="black"/>
                                    <rect x="286" y="10" width="2" height="60" fill="black"/>
                                </svg>
                                <p class="mt-2 text-sm font-semibold text-gray-800">{{ $product['code'] ?? 'No Code' }}</p>
                            </div>
                        </td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="w-1/2 px-5 py-4 text-gray-700 font-semibold border-r border-gray-200">Type</td>
                        <td class="w-1/2 px-5 py-4 text-gray-700 font-semibold">Product</td>
                    </tr>
                    <tr>
                        <td class="px-5 py-4 text-gray-700 font-medium border-r border-gray-200">Code Product</td>
                        <td class="px-5 py-4 text-gray-900 font-semibold">{{ $product['code'] ?? '-' }}</td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="px-5 py-4 text-gray-700 font-medium border-r border-gray-200">Product</td>
                        <td class="px-5 py-4 text-gray-900 font-semibold">{{ $product['name'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="px-5 py-4 text-gray-700 font-medium border-r border-gray-200">Category</td>
                        <td class="px-5 py-4 text-gray-900 font-semibold">{{ $product['category'] ?? '-' }}</td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="px-5 py-4 text-gray-700 font-medium border-r border-gray-200">Brand</td>
                        <td class="px-5 py-4 text-gray-900 font-semibold">{{ $product['brand'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="px-5 py-4 text-gray-700 font-medium border-r border-gray-200">Unit</td>
                        <td class="px-5 py-4 text-gray-900 font-semibold">{{ $product['unit'] ?? '-' }}</td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="px-5 py-4 text-gray-700 font-medium border-r border-gray-200">Tags</td>
                        <td class="px-5 py-4 text-gray-900 font-semibold">{{ $product['tags'] ?? '' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tags Section -->
    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Tags</h3>
        <div class="flex items-center space-x-2">
            <input type="text" value="{{ $product['tags'] ?? '' }}" 
                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-100 focus:outline-none" 
                   placeholder="Enter tags..." readonly>
        </div>
    </div>

    <!-- Warehouse Inventory Section -->
    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Warehouse Inventory</h3>
        <div class="space-y-3">
            @if(!empty($product['warehouse_inventory']) && is_array($product['warehouse_inventory']))
                @foreach($product['warehouse_inventory'] as $inventory)
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                        <span class="text-sm font-medium text-gray-700">{{ $inventory['warehouse'] ?? 'Unknown Warehouse' }}</span>
                        <span class="text-sm font-semibold text-gray-900">{{ number_format($inventory['quantity'] ?? 0, 2) }} {{ $product['unit'] ?? 'Pcs' }}</span>
                    </div>
                @endforeach
            @else
                <div class="text-center py-8 text-gray-500">
                    <div class="flex flex-col items-center space-y-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span class="text-sm font-medium">No warehouse inventory data available</span>
                    </div>
                </div>
            @endif
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
