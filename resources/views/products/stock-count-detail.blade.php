@extends('layouts.app')

@section('content')
<div class="bg-white border border-gray-200 rounded-lg p-6">
    <!-- Success Message -->
    @if (session('success'))
    <div class="mb-6 rounded-2xl border border-green-200 bg-gradient-to-r from-green-50 to-emerald-50 text-green-800 px-6 py-4 shadow-sm">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold">Success!</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Error Message -->
    @if (session('error'))
    <div class="mb-6 rounded-2xl border border-red-200 bg-gradient-to-r from-red-50 to-pink-50 text-red-700 px-6 py-4 shadow-sm">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold">Error!</p>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <!-- Title and Breadcrumb -->
        <div class="flex items-baseline gap-3">
            <div class="text-2xl font-semibold">Stock Count Details</div>
            <div class="text-sm text-slate-500">Products | Stock Count | #{{ $stockCount->id }}</div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('stock-count.index') }}" class="flex items-center px-4 py-2 border border-gray-300 text-gray-700 bg-white rounded-md hover:bg-gray-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Stock Counts
            </a>
            
            <a href="{{ route('stock-count.edit', $stockCount->id) }}" class="flex items-center px-4 py-2 border border-blue-200 text-blue-600 bg-white rounded-md hover:bg-blue-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
        </div>
    </div>

    <!-- Stock Count Info Card -->
    <div class="bg-gray-50 rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Date</label>
                <p class="text-lg font-semibold text-gray-900">{{ \Carbon\Carbon::parse($stockCount->date)->format('M d, Y') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Warehouse</label>
                <p class="text-lg font-semibold text-gray-900">{{ $stockCount->warehouse_name ?? 'Unknown Warehouse' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                <div class="mt-1">
                    @if($stockCount->status === 'pending')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            Pending
                        </span>
                    @elseif($stockCount->status === 'in_progress')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 border border-blue-200">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            In Progress
                        </span>
                    @elseif($stockCount->status === 'completed')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 border border-green-200">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Completed
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 border border-red-200">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Error
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Product Code</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Product Name</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Brand</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Unit</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Expected Qty</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Counted Qty</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Difference</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="px-3 py-3 text-gray-700 font-medium">{{ $product->product_code ?? '-' }}</td>
                    <td class="px-3 py-3 text-gray-700">{{ $product->product_name ?? '-' }}</td>
                    <td class="px-3 py-3 text-gray-700">{{ $product->brand ?? '-' }}</td>
                    <td class="px-3 py-3 text-gray-700">{{ $product->unit ?? '-' }}</td>
                    <td class="px-3 py-3 text-gray-700">{{ $product->expected_quantity ?? 0 }}</td>
                    <td class="px-3 py-3 text-gray-700">{{ $product->counted_quantity ?? 0 }}</td>
                    <td class="px-3 py-3">
                        @php
                            $expected = $product->expected_quantity ?? 0;
                            $counted = $product->counted_quantity ?? 0;
                            $difference = $counted - $expected;
                        @endphp
                        @if($difference > 0)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                +{{ $difference }}
                            </span>
                        @elseif($difference < 0)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ $difference }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ $difference }}
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">No products found for this stock count.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Summary -->
    @if($products->count() > 0)
    <div class="mt-6 bg-gray-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Summary</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-900">{{ $products->count() }}</div>
                <div class="text-sm text-gray-500">Total Products</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">
                    {{ $products->where('counted_quantity', '>', 'expected_quantity')->count() }}
                </div>
                <div class="text-sm text-gray-500">Over Count</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-red-600">
                    {{ $products->where('counted_quantity', '<', 'expected_quantity')->count() }}
                </div>
                <div class="text-sm text-gray-500">Under Count</div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
