@extends('layouts.app')

@section('header-left')
<div class="flex items-center space-x-3">
    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M5 11h14M7 15h10"/></svg>
    </div>
    <div>
        <h1 class="text-2xl font-bold text-gray-900">All Products</h1>
        <div class="text-sm text-gray-500 flex items-center gap-3">
            <a class="font-medium text-violet-600" href="#">Products</a>
            <span class="text-gray-300">/</span>
            <span>All Products</span>
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
<div class="space-y-3">
    <!-- Toolbar -->
    <div class="flex items-center justify-between flex-wrap gap-2">
        <!-- Left: Search -->
        <div class="relative w-full sm:w-auto">
            <div class="input-search-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input id="searchInput" type="text" placeholder="Search this table" class="form-input input-search w-[320px] max-w-full h-10 rounded-xl border border-gray-200 pr-3 text-[13px] bg-white/80 backdrop-blur focus:border-violet-400 focus:ring-2 focus:ring-violet-100 shadow-sm" />
        </div>
        <!-- Right: Buttons -->
        <div class="flex items-center gap-2">
            <button id="approveBtn" class="px-4 py-2 text-sm font-semibold rounded-lg bg-emerald-500 text-white hover:bg-emerald-600 shadow-sm inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 13l4 4L19 7"/></svg>
                <span>Approval</span>
            </button>
            <button id="filterBtn" class="px-4 py-2 text-sm font-semibold rounded-lg border border-gray-200 hover:bg-gray-50 inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 5h18M6 12h12M10 19h4"/></svg>
                <span>Filter</span>
            </button>
            <a href="#" id="exportPdfBtn" class="px-4 py-2 text-sm font-semibold rounded-lg border border-emerald-200 text-emerald-600 hover:bg-emerald-50 inline-flex items-center gap-2 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 5v14M5 12h14"/></svg>
                <span>PDF</span>
            </a>
            <a href="#" id="exportExcelBtn" class="px-4 py-2 text-sm font-semibold rounded-lg border border-rose-200 text-rose-600 hover:bg-rose-50 inline-flex items-center gap-2 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 4l16 16M20 4L4 20"/></svg>
                <span>EXCEL</span>
            </a>
            <button id="importBtn" class="px-4 py-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 inline-flex items-center gap-2 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 3v12m0 0l-4-4m4 4l4-4"/><path d="M20 21H4a2 2 0 01-2-2V7"/></svg>
                <span>Import products</span>
            </button>
            <a href="{{ route('products.create') }}" class="px-5 py-2 text-sm font-semibold rounded-lg bg-gradient-to-r from-violet-600 to-purple-600 text-white hover:from-violet-700 hover:to-purple-700 shadow-sm inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 5v14M5 12h14"/></svg>
                <span>Create</span>
            </a>
        </div>
    </div>
    <!-- Tabs -->
    <div class="border-b border-gray-200">
        <nav class="flex items-center gap-4 text-sm">
            <a href="#" class="py-1.5 border-b-2 border-violet-600 text-violet-700 font-semibold">All Products</a>
        </nav>
    </div>
    

    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
        <table class="min-w-[900px] w-full table-auto">
            <thead class="bg-gray-50 border-b border-gray-200">
                
                <tr>
                    <th class="px-3 py-2 w-8 text-left text-[11px] font-semibold text-gray-500"><input type="checkbox" id="selectAll"></th>
                    <th class="px-3 py-2 w-16 text-left text-[11px] font-semibold text-gray-500">Image</th>
                    <th class="px-3 py-2 w-20 text-left text-[11px] font-semibold text-gray-500">Type</th>
                    <th class="px-3 py-2 text-left text-[11px] font-semibold text-gray-500">Name</th>
                    <th class="px-3 py-2 w-20 text-left text-[11px] font-semibold text-gray-500">Tag</th>
                    <th class="px-3 py-2 w-24 text-left text-[11px] font-semibold text-gray-500">Project</th>
                    <th class="px-3 py-2 w-28 text-left text-[11px] font-semibold text-gray-500">Code</th>
                    <th class="px-3 py-2 w-28 text-left text-[11px] font-semibold text-gray-500">Brand</th>
                    <th class="px-3 py-2 w-16 text-left text-[11px] font-semibold text-gray-500">Unit</th>
                    
                    @if(auth()->user()->role_id != 1)
                    <th class="px-3 py-2 w-24 text-left text-[11px] font-semibold text-gray-500">Status</th>
                    @endif

                    <th class="px-3 py-2 w-24 text-right text-[11px] font-semibold text-gray-500">Action</th>

                    
                </tr>
            </thead>
            <tbody id="productsTable" class="divide-y divide-gray-100 text-[13px]">
                @php $rows = $allProducts ?? []; @endphp
                @if(empty($rows))
                    <tr><td colspan="{{ auth()->user()->role_id == 1 ? '11' : '12' }}" class="px-4 py-8 text-center text-gray-500">No products found</td></tr>
                @else
                    @foreach($rows as $p)
                        @php $p = is_object($p)? (array)$p : $p; @endphp
                        <tr class="hover:bg-gray-50 transition-colors" data-name="{{ strtolower($p['name'] ?? '') }}" data-code="{{ strtolower($p['code'] ?? '') }}" data-brand="{{ strtolower($p['brand'] ?? '') }}" data-category="{{ strtolower($p['category'] ?? '') }}">
                            <td class="px-3 py-2"><input type="checkbox" class="selectRow" value="{{ $p['id'] ?? $p['temp_id'] ?? '' }}"></td>
@php
    $productImages = [];
    if (!empty($p['image'])) {
        $productImages = is_array($p['image']) 
            ? $p['image'] 
            : explode(',', $p['image']);
        $productImages = array_filter(array_map('trim', $productImages));
    }
@endphp


<td class="px-3 py-2">
@if(!empty($productImages))
    <img src="{{ asset('images/products/' . $productImages[0]) }}" class="w-10 h-10 object-cover rounded-xl border" />
@else
    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-[10px] text-gray-400 border">No image</div>
@endif

</td>


                            <td class="px-3 py-2 text-[12px] text-gray-700">{{ ucfirst($p['type'] ?? 'Product') }}</td>
                            <td class="px-3 py-2 text-[13px] font-medium text-gray-900 whitespace-nowrap truncate max-w-[220px] pr-2">{{ $p['name'] ?? '-' }}</td>
                            <td class="px-3 py-2"><span class="inline-block text-[11px] px-2 py-1 rounded-xl bg-violet-50 text-violet-700 border border-violet-200 whitespace-nowrap">Tag</span></td>
                            <td class="px-3 py-2 text-[13px] text-gray-700 whitespace-nowrap truncate max-w-[160px]">{{ $p['project'] ?? '-' }}</td>
                            <td class="px-3 py-2 text-[13px] text-gray-700 whitespace-nowrap truncate max-w-[140px]">{{ $p['code'] ?? '-' }}</td>
                            <td class="px-3 py-2 text-[13px] text-gray-700 whitespace-nowrap truncate max-w-[140px]">{{ $p['brand'] ?? '-' }}</td>
                            <td class="px-3 py-2 text-[13px] text-gray-700">{{ $p['unit'] ?? 'Pcs' }}</td>
                            <td class="px-3 py-2 text-[13px] text-gray-700">
                                <div class="flex items-center gap-2 justify-end">
                                    @if (isset($p['is_active']) && $p['is_active'] == 0)
                                        <!-- Pending product - limited actions -->
                                        <span class="w-8 h-8 rounded-full border border-gray-300 text-gray-400 grid place-items-center cursor-not-allowed" title="Pending approval - actions disabled">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </span>
                                        <span class="w-8 h-8 rounded-full border border-gray-300 text-gray-400 grid place-items-center cursor-not-allowed" title="Pending approval - actions disabled">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5Z"/></svg>
                                        </span>
                                        <span class="w-8 h-8 rounded-full border border-gray-300 text-gray-400 grid place-items-center cursor-not-allowed" title="Pending approval - actions disabled">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 6h18"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                        </span>
                                    @else
                                        <!-- Approved/Rejected product - full actions -->
                                        <a href="{{ route('products.show', $p['id'] ?? $p['temp_id'] ?? '') }}" class="w-8 h-8 rounded-full border border-blue-300 text-blue-600 hover:bg-blue-50 grid place-items-center" title="View">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                        <a href="{{ route('products.edit', $p['id'] ?? $p['temp_id'] ?? '') }}" class="w-8 h-8 rounded-full border border-emerald-300 text-emerald-600 hover:bg-emerald-50 grid place-items-center" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5Z"/></svg>
                                        </a>
                                        <form action="{{ route('products.destroy', $p['id'] ?? $p['temp_id'] ?? '') }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-full border border-rose-300 text-rose-600 hover:bg-rose-50 grid place-items-center" title="Delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 6h18"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                            </button>
                                        </form>
                                    @endif

                    @if(auth()->user()->role_id != 1)
                    <td class="px-3 py-2">
                        @if (isset($p['status']) && $p['status'] == 'Pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                Pending
                            </span>
                        @elseif (isset($p['is_active']) && $p['is_active'] == 1)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Approved
                            </span>
                        @elseif (isset($p['is_active']) && $p['is_active'] == 2)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Rejected
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                Unknown
                            </span>
                        @endif
                    </td>
                    @endif

                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        </div>
    </div>

    <div class="flex items-center justify-between text-sm text-gray-600 px-6 py-4 border-t border-gray-200 bg-gray-50">
        <div class="flex items-center gap-2">
            <span>Rows per page:</span>
            <select id="rowsPerPage" class="border border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div id="paginationInfo" class="text-gray-700">
            1 - {{ min(10, count($rows)) }} of {{ count($rows) }}
        </div>
        <div class="flex items-center gap-4">
            <button id="prevBtn" class="px-3 py-1 text-sm text-gray-500 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                <span class="text-xs">prev</span>
            </button>
            <button id="nextBtn" class="px-3 py-1 text-sm text-gray-500 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed">
                <span class="text-xs">next</span>
            </button>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div id="importModal" class="fixed inset-0 bg-black/30 items-center justify-center hidden" style="display: none;">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl">
        <h3 class="text-lg font-semibold mb-4">Import Products (CSV)</h3>
        <form id="importForm" enctype="multipart/form-data">
            @csrf
            <input type="file" name="csv_file" accept=".csv,text/csv" class="w-full border-2 border-gray-200 rounded-lg p-2 text-sm" required />
            <div class="mt-4 flex justify-end gap-2">
                <button type="button" id="closeImport" class="px-3 py-2 rounded-lg border border-gray-200">Cancel</button>
                <button type="submit" class="px-3 py-2 rounded-lg bg-violet-600 text-white">Upload</button>
            </div>
        </form>
    </div>
    </div>
@endsection

<!-- Filter Modal -->
<div id="filterModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden">
    <div class="flex items-start justify-center min-h-screen p-4 pt-16 sm:pt-20">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg mx-auto transform transition-all duration-300 scale-95 opacity-0 max-h-[90vh] overflow-hidden" id="filterModalContent">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-4">
                <button id="closeFilterModal" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                <h3 class="text-xl font-bold text-gray-900">Filter Products</h3>
                <div class="w-10"></div> <!-- Spacer for centering -->
            </div>

            <!-- Modal Body -->
            <div class="px-6 pb-6 overflow-y-auto max-h-[calc(90vh-200px)]">
                <div class="space-y-5">
                    <!-- Code Product -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-3">Code Product</label>
                        <div class="relative">
                            <input type="text" id="filterCode" placeholder="Search by Code" 
                                class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 pr-12 text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-100 focus:outline-none hover:border-gray-300 bg-gray-50/50">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Product -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-3">Product</label>
                        <input type="text" id="filterProduct" placeholder="Search by Name" 
                            class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-100 focus:outline-none hover:border-gray-300 bg-gray-50/50">
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-3">Category</label>
                        <div class="relative">
                            <select id="filterCategory" class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 pr-10 appearance-none text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-100 focus:outline-none hover:border-gray-300 bg-gray-50/50">
                                <option value="">Choose Category</option>
                                <option value="Electronics">Electronics</option>
                                <option value="Clothing">Clothing</option>
                                <option value="Books">Books</option>
                                <option value="Home & Garden">Home & Garden</option>
                                <option value="Sports">Sports</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Brand -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-3">Brand</label>
                        <div class="relative">
                            <select id="filterBrand" class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 pr-10 appearance-none text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-100 focus:outline-none hover:border-gray-300 bg-gray-50/50">
                                <option value="">Choose Brand</option>
                                <option value="Apple">Apple</option>
                                <option value="Samsung">Samsung</option>
                                <option value="Nike">Nike</option>
                                <option value="Adidas">Adidas</option>
                                <option value="Sony">Sony</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Project -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-3">Project</label>
                        <div class="relative">
                            <select id="filterProject" class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 pr-10 appearance-none text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-100 focus:outline-none hover:border-gray-300 bg-gray-50/50">
                                <option value="">Choose Project</option>
                                <option value="Next-G-24">Next-G-24</option>
                                <option value="Project Alpha">Project Alpha</option>
                                <option value="Project Beta">Project Beta</option>
                                <option value="Project Gamma">Project Gamma</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-3">Tags</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center space-x-3 cursor-pointer p-3 rounded-xl hover:bg-gray-50 transition-colors">
                                <input type="checkbox" id="tagTag" class="w-5 h-5 text-violet-600 border-2 border-gray-300 rounded focus:ring-violet-500 focus:ring-2">
                                <span class="px-3 py-1.5 bg-violet-100 text-violet-700 rounded-full text-sm font-medium">Tag</span>
                            </label>
                            <label class="flex items-center space-x-3 cursor-pointer p-3 rounded-xl hover:bg-gray-50 transition-colors">
                                <input type="checkbox" id="tagMerah" class="w-5 h-5 text-red-600 border-2 border-gray-300 rounded focus:ring-red-500 focus:ring-2">
                                <span class="px-3 py-1.5 bg-red-100 text-red-700 rounded-full text-sm font-medium">merah</span>
                            </label>
                            <label class="flex items-center space-x-3 cursor-pointer p-3 rounded-xl hover:bg-gray-50 transition-colors">
                                <input type="checkbox" id="tagNew" class="w-5 h-5 text-green-600 border-2 border-gray-300 rounded focus:ring-green-500 focus:ring-2">
                                <span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-sm font-medium">New</span>
                            </label>
                            <label class="flex items-center space-x-3 cursor-pointer p-3 rounded-xl hover:bg-gray-50 transition-colors">
                                <input type="checkbox" id="tagSale" class="w-5 h-5 text-orange-600 border-2 border-gray-300 rounded focus:ring-orange-500 focus:ring-2">
                                <span class="px-3 py-1.5 bg-orange-100 text-orange-700 rounded-full text-sm font-medium">Sale</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-between p-6 pt-4 border-t border-gray-100 bg-gray-50/50">
                <button id="resetFilter" class="px-6 py-3 rounded-xl bg-red-500 text-white font-semibold hover:bg-red-600 transition-all duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>Reset</span>
                </button>
                <button id="applyFilter" class="px-6 py-3 rounded-xl bg-gradient-to-r from-violet-600 to-purple-600 text-white font-semibold hover:from-violet-700 hover:to-purple-700 transition-all duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <span>Filter</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Import Products Modal -->
<div id="importModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden">
    <div class="flex items-start justify-center min-h-screen p-4 pt-16 sm:pt-20">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl mx-auto transform transition-all duration-300 scale-95 opacity-0 max-h-[90vh] overflow-hidden" id="importModalContent">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 pb-4">
                <h3 class="text-2xl font-bold text-gray-900">Import products</h3>
                <button id="closeImportModal" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="px-6 pb-6 overflow-y-auto max-h-[calc(90vh-200px)]">
                <!-- File Upload Section -->
                <div class="mb-6">
                    <div class="flex items-center gap-4 mb-3">
                        <button id="chooseFileBtn" class="px-4 py-2 border-2 border-gray-300 text-gray-600 rounded-lg font-medium hover:border-gray-400 hover:bg-gray-50 transition-all duration-200 text-sm">
                            Choose File
                        </button>
                        <span id="fileName" class="text-gray-500 text-sm">No file chosen</span>
                    </div>
                    <div id="fileError" class="text-red-500 text-sm hidden">Field must be in csv format.</div>
                    <input type="file" id="importFile" accept=".csv" class="hidden">
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-2 mb-8">
                    <button id="submitImport" class="px-4 py-2 rounded-lg bg-violet-600 text-white font-medium hover:bg-violet-700 transition-all duration-200 flex items-center space-x-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Submit</span>
                    </button>
                    <button id="downloadExample" class="px-4 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition-all duration-200 flex items-center space-x-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Download example</span>
                    </button>
                </div>

                <!-- Product Fields Table -->
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Product Fields</h4>
                    <div class="space-y-4">
                        <!-- Name Field -->
                        <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-200">
                            <div class="flex-1">
                                <span class="text-sm font-semibold text-gray-800">Name</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 bg-green-100 text-green-700 border border-green-200 rounded-full text-xs font-medium">This Field is required</span>
                            </div>
                        </div>

                        <!-- Code Product Field -->
                        <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-200">
                            <div class="flex-1">
                                <span class="text-sm font-semibold text-gray-800">Code Product</span>
                                <div class="text-xs text-gray-500 mt-1">code must be not exist already</div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 bg-green-100 text-green-700 border border-green-200 rounded-full text-xs font-medium">This Field is required</span>
                            </div>
                        </div>

                        <!-- Category Field -->
                        <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-200">
                            <div class="flex-1">
                                <span class="text-sm font-semibold text-gray-800">Category</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 bg-green-100 text-green-700 border border-green-200 rounded-full text-xs font-medium">This Field is required</span>
                            </div>
                        </div>

                        <!-- Product Unit Field -->
                        <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-200">
                            <div class="flex-1">
                                <span class="text-sm font-semibold text-gray-800">Product Unit</span>
                                <div class="text-xs text-gray-500 mt-1">unit must already be created Please use short name of unit</div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 bg-green-100 text-green-700 border border-green-200 rounded-full text-xs font-medium">This Field is required</span>
                            </div>
                        </div>

                        <!-- Brand Field -->
                        <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-200">
                            <div class="flex-1">
                                <span class="text-sm font-semibold text-gray-800">Brand</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 border border-blue-200 rounded-full text-xs font-medium">Field optional</span>
                            </div>
                        </div>

                        <!-- Stock Alert Field -->
                        <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-200">
                            <div class="flex-1">
                                <span class="text-sm font-semibold text-gray-800">Stock Alert</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 border border-blue-200 rounded-full text-xs font-medium">Field optional</span>
                            </div>
                        </div>

                        <!-- Note Field -->
                        <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-200">
                            <div class="flex-1">
                                <span class="text-sm font-semibold text-gray-800">Note</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 border border-blue-200 rounded-full text-xs font-medium">Field optional</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end p-6 pt-4 border-t border-gray-100 bg-gray-50/50">
                <button id="cancelImport" class="px-4 py-2 rounded-lg bg-violet-600 text-white font-medium hover:bg-violet-700 transition-all duration-200 text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Filter Modal Functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterModal = document.getElementById('filterModal');
    const filterModalContent = document.getElementById('filterModalContent');
    const filterBtn = document.getElementById('filterBtn');
    const closeFilterModal = document.getElementById('closeFilterModal');
    const applyFilter = document.getElementById('applyFilter');
    const resetFilter = document.getElementById('resetFilter');

    // Open modal
    filterBtn.addEventListener('click', function() {
        filterModal.classList.remove('hidden');
        setTimeout(() => {
            filterModalContent.classList.remove('scale-95', 'opacity-0');
            filterModalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    });

    // Close modal
    function closeModal() {
        filterModalContent.classList.remove('scale-100', 'opacity-100');
        filterModalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            filterModal.classList.add('hidden');
        }, 300);
    }

    closeFilterModal.addEventListener('click', closeModal);
    
    // Close on backdrop click
    filterModal.addEventListener('click', function(e) {
        if (e.target === filterModal) {
            closeModal();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !filterModal.classList.contains('hidden')) {
            closeModal();
        }
    });

    // Reset filter
    resetFilter.addEventListener('click', function() {
        document.getElementById('filterCode').value = '';
        document.getElementById('filterProduct').value = '';
        document.getElementById('filterCategory').value = '';
        document.getElementById('filterBrand').value = '';
        document.getElementById('filterProject').value = '';
        document.getElementById('tagTag').checked = false;
        document.getElementById('tagMerah').checked = false;
        document.getElementById('tagNew').checked = false;
        document.getElementById('tagSale').checked = false;
    });

    // Apply filter
    applyFilter.addEventListener('click', function() {
        const filters = {
            code: document.getElementById('filterCode').value,
            product: document.getElementById('filterProduct').value,
            category: document.getElementById('filterCategory').value,
            brand: document.getElementById('filterBrand').value,
            project: document.getElementById('filterProject').value,
            tags: []
        };

        // Get selected tags
        if (document.getElementById('tagTag').checked) filters.tags.push('Tag');
        if (document.getElementById('tagMerah').checked) filters.tags.push('merah');
        if (document.getElementById('tagNew').checked) filters.tags.push('New');
        if (document.getElementById('tagSale').checked) filters.tags.push('Sale');

        // Apply filters to table
        applyFiltersToTable(filters);
        closeModal();
    });

    // Apply filters to table function
    function applyFiltersToTable(filters) {
        const rows = document.querySelectorAll('#productsTable tr');

        rows.forEach(row => {
            const name = (row.dataset.name || '').toLowerCase();
            const code = (row.dataset.code || '').toLowerCase();
            const brand = (row.dataset.brand || '').toLowerCase();
            const category = (row.dataset.category || '').toLowerCase();

            let showRow = true;

            if (filters.code && !code.includes(filters.code.toLowerCase())) showRow = false;
            if (filters.product && !name.includes(filters.product.toLowerCase())) showRow = false;
            if (filters.category && !category.includes(filters.category.toLowerCase())) showRow = false;
            if (filters.brand && !brand.includes(filters.brand.toLowerCase())) showRow = false;

            // Tags (if any specified, require overlap)
            if (showRow && Array.isArray(filters.tags) && filters.tags.length) {
                // current table shows placeholder Tag only; skip matching or customize as needed
            }

            row.style.display = showRow ? '' : 'none';
        });

        // Update filter button appearance
        const hasActiveFilters = Object.values(filters).some(value => 
            Array.isArray(value) ? value.length > 0 : value !== ''
        );
        
        if (hasActiveFilters) {
            filterBtn.classList.add('bg-violet-100', 'text-violet-700', 'border-violet-300');
            filterBtn.classList.remove('border-gray-200', 'text-gray-600');
        } else {
            filterBtn.classList.remove('bg-violet-100', 'text-violet-700', 'border-violet-300');
            filterBtn.classList.add('border-gray-200', 'text-gray-600');
        }
    }
});

// Import Modal Functionality
document.addEventListener('DOMContentLoaded', function() {
    const importModal = document.getElementById('importModal');
    const importModalContent = document.getElementById('importModalContent');
    const importBtn = document.getElementById('importBtn');
    const closeImportModal = document.getElementById('closeImportModal');
    const cancelImport = document.getElementById('cancelImport');
    const chooseFileBtn = document.getElementById('chooseFileBtn');
    const importFile = document.getElementById('importFile');
    const fileName = document.getElementById('fileName');
    const fileError = document.getElementById('fileError');
    const submitImport = document.getElementById('submitImport');
    const downloadExample = document.getElementById('downloadExample');

    // Open modal
    importBtn.addEventListener('click', function() {
        importModal.classList.remove('hidden');
        setTimeout(() => {
            importModalContent.classList.remove('scale-95', 'opacity-0');
            importModalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    });

    // Close modal
    function closeModal() {
        importModalContent.classList.remove('scale-100', 'opacity-100');
        importModalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            importModal.classList.add('hidden');
            resetForm();
        }, 300);
    }

    closeImportModal.addEventListener('click', closeModal);
    cancelImport.addEventListener('click', closeModal);
    
    // Close on backdrop click
    importModal.addEventListener('click', function(e) {
        if (e.target === importModal) {
            closeModal();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !importModal.classList.contains('hidden')) {
            closeModal();
        }
    });

    // File selection
    chooseFileBtn.addEventListener('click', function() {
        importFile.click();
    });

    importFile.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.type === 'text/csv' || file.name.endsWith('.csv')) {
                fileName.textContent = file.name;
                fileName.classList.remove('text-gray-500');
                fileName.classList.add('text-green-600');
                fileError.classList.add('hidden');
                submitImport.disabled = false;
            } else {
                fileName.textContent = 'Invalid file format';
                fileName.classList.remove('text-gray-500');
                fileName.classList.add('text-red-500');
                fileError.classList.remove('hidden');
                submitImport.disabled = true;
            }
        }
    });

    // Submit import
    submitImport.addEventListener('click', function() {
        const file = importFile.files[0];
        if (!file) {
            fileError.textContent = 'Please select a CSV file';
            fileError.classList.remove('hidden');
            return;
        }

        if (!file.name.endsWith('.csv')) {
            fileError.textContent = 'Field must be in csv format.';
            fileError.classList.remove('hidden');
            return;
        }

        // Show loading state
        submitImport.disabled = true;
        submitImport.innerHTML = `
            <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Importing...</span>
        `;

        // Simulate import process
        setTimeout(() => {
            alert('Import completed successfully!');
            closeModal();
        }, 2000);
    });

    // Download example
    downloadExample.addEventListener('click', function() {
        const csvContent = "Name,Code Product,Category,Product Unit,Brand,Stock Alert,Note\n" +
            "Sample Product 1,PROD001,Electronics,Pcs,Apple,10,Sample product\n" +
            "Sample Product 2,PROD002,Clothing,Pcs,Nike,5,Sample clothing\n" +
            "Sample Product 3,PROD003,Books,Pcs,Generic,20,Sample book";
        
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'products_import_example.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    });

    // Reset form
    function resetForm() {
        importFile.value = '';
        fileName.textContent = 'No file chosen';
        fileName.classList.remove('text-green-600', 'text-red-500');
        fileName.classList.add('text-gray-500');
        fileError.classList.add('hidden');
        submitImport.disabled = false;
        submitImport.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Submit</span>
        `;
    }
});

// Instant local filter + debounced backend enrichment for better UX
(function(){
    const input = document.getElementById('searchInput');
    const tbody = document.getElementById('productsTable');
    if (!input || !tbody) return;

    const searchUrl = @json(route('products.search'));
    const exportPdfUrl = @json(route('products.export.pdf'));
    const exportExcelUrl = @json(route('products.export.excel'));
    const initialProducts = @json($allProducts ?? []);
    const isAdmin = {{ auth()->user()->role_id == 1 ? 'true' : 'false' }};
    
    // Pagination variables
    let currentPage = 1;
    let rowsPerPage = 10;
    let filteredProducts = initialProducts;

    const escape = (v) => String(v ?? '').replace(/[&<>"']/g, s => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;'}[s]));
    
    // Pagination functions
    const getPaginatedProducts = (products, page, perPage) => {
        const startIndex = (page - 1) * perPage;
        const endIndex = startIndex + perPage;
        return products.slice(startIndex, endIndex);
    };
    
    const updatePaginationInfo = (products, page, perPage) => {
        const total = products.length;
        const start = (page - 1) * perPage + 1;
        const end = Math.min(page * perPage, total);
        document.getElementById('paginationInfo').textContent = `${start} - ${end} of ${total}`;
    };
    
    const updatePaginationButtons = (products, page, perPage) => {
        const totalPages = Math.ceil(products.length / perPage);
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        
        prevBtn.disabled = page <= 1;
        nextBtn.disabled = page >= totalPages;
        
        if (page <= 1) {
            prevBtn.classList.add('text-gray-400');
            prevBtn.classList.remove('text-violet-600');
        } else {
            prevBtn.classList.remove('text-gray-400');
            prevBtn.classList.add('text-violet-600');
        }
        
        if (page >= totalPages) {
            nextBtn.classList.add('text-gray-400');
            nextBtn.classList.remove('text-violet-600');
        } else {
            nextBtn.classList.remove('text-gray-400');
            nextBtn.classList.add('text-violet-600');
        }
    };
    
    function getFirstImagePath(product){
        const img = product.image;
        if (!img) return '';
        if (Array.isArray(img)) return img.length ? img[0] : '';
        if (typeof img === 'string'){
            const parts = img.split(',').map(s => (s||'').trim()).filter(Boolean);
            return parts.length ? parts[0] : '';
        }
        return '';
    }

    const render = (products) => {
        filteredProducts = products;
        currentPage = 1; // Reset to first page when filtering
        
        if (!products || products.length === 0) {
            tbody.innerHTML = `<tr><td colspan="${isAdmin ? '11' : '12'}" class="px-4 py-8 text-center text-gray-500">No products found</td></tr>`;
            updatePaginationInfo(products, 1, rowsPerPage);
            updatePaginationButtons(products, 1, rowsPerPage);
            return;
        }
        
        const paginatedProducts = getPaginatedProducts(products, currentPage, rowsPerPage);
        updatePaginationInfo(products, currentPage, rowsPerPage);
        updatePaginationButtons(products, currentPage, rowsPerPage);
        
        tbody.innerHTML = paginatedProducts.map(p => {
            const name = escape(p.name);
            const code = escape(p.code);
            const brand = escape(p.brand);
            const category = escape(p.category);
            const unit = escape(p.unit || 'Pcs');
            
            const id = escape(p.id || '');
            const type = escape((p.type || 'Product').charAt(0).toUpperCase() + (p.type || 'Product').slice(1));
            const project = escape(p.project || '-');
            const imgFile = getFirstImagePath(p);
            const imgHtml = imgFile 
                ? `<img src="/images/products/${escape(imgFile)}" class="w-10 h-10 object-cover rounded-xl border" />`
                : `<div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-[10px] text-gray-400 border">No image</div>`;
            return `
                <tr class="hover:bg-gray-50 transition-colors" data-name="${name.toLowerCase()}" data-code="${code.toLowerCase()}" data-brand="${brand.toLowerCase()}" data-category="${category.toLowerCase()}">
                    <td class="px-3 py-2"><input type="checkbox" class="selectRow" value="${id}"></td>
                    <td class="px-3 py-2">${imgHtml}</td>
                    <td class="px-3 py-2 text-[12px] text-gray-700">${type}</td>
                    <td class="px-3 py-2 text-[13px] font-medium text-gray-900 whitespace-nowrap truncate max-w-[220px] pr-2">${name || '-'}</td>
                    <td class="px-3 py-2"><span class="inline-block text-[11px] px-2 py-1 rounded-xl bg-violet-50 text-violet-700 border border-violet-200 whitespace-nowrap">Tag</span></td>
                    <td class="px-3 py-2 text-[13px] text-gray-700 whitespace-nowrap truncate max-w-[160px]">${project}</td>
                    <td class="px-3 py-2 text-[13px] text-gray-700 whitespace-nowrap truncate max-w-[140px]">${code || '-'}</td>
                    <td class="px-3 py-2 text-[13px] text-gray-700 whitespace-nowrap truncate max-w-[140px]">${brand || '-'}</td>
                    <td class="px-3 py-2 text-[13px] text-gray-700">${unit}</td>
                    ${!isAdmin ? `
                    <td class="px-3 py-2 text-[13px] text-gray-700">
                        ${(p.status && p.status === 'Pending') ? 
                            '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>Pending</span>' : 
                            (p.is_active && p.is_active == 1) ? 
                            '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>Approved</span>' : 
                            (p.is_active && p.is_active == 2) ?
                            '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>Rejected</span>' :
                            '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>Unknown</span>'
                        }
                    </td>` : ''}
                    <td class="px-3 py-2 text-[13px] text-gray-700">
                        <div class="flex items-center gap-2 justify-end">
                            <a href="/products/${id}" class="w-8 h-8 rounded-full border border-blue-300 text-blue-600 hover:bg-blue-50 grid place-items-center" title="View">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            <button class="w-8 h-8 rounded-full border border-emerald-300 text-emerald-600 hover:bg-emerald-50 grid place-items-center" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5Z"/></svg>
                            </button>
                            <button class="w-8 h-8 rounded-full border border-rose-300 text-rose-600 hover:bg-rose-50 grid place-items-center" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 6h18"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>`;
        }).join('');
    };

    const localFilter = (q) => {
        const query = q.trim().toLowerCase();
        if (!query) return initialProducts;
        return (initialProducts || []).filter(p => {
            const name = (p.name || '').toLowerCase();
            const code = (p.code || '').toLowerCase();
            const brand = (p.brand || '').toLowerCase();
            const category = (p.category || '').toLowerCase();
            return name.includes(query) || code.includes(query) || brand.includes(query) || category.includes(query);
        });
    };

    let timerId;
    input.addEventListener('input', (e) => {
        const q = e.target.value || '';
        // Immediate local feedback
        render(localFilter(q));

        // Backend refinement
        clearTimeout(timerId);
        timerId = setTimeout(async () => {
            if (!q.trim()) { render(initialProducts); return; }
            try {
                const res = await fetch(`${searchUrl}?q=${encodeURIComponent(q)}`, { headers: { 'Accept':'application/json' } });
                if (!res.ok) throw new Error('Search failed');
                const data = await res.json();
                const products = Array.isArray(data.products) ? data.products : [];
                if (products.length) render(products);
            } catch (e) {
                // keep local results if request fails
            }
        }, 200);
    });

    // Pagination event listeners
    document.getElementById('rowsPerPage').addEventListener('change', (e) => {
        rowsPerPage = parseInt(e.target.value);
        currentPage = 1;
        render(filteredProducts);
    });
    
    document.getElementById('prevBtn').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            const paginatedProducts = getPaginatedProducts(filteredProducts, currentPage, rowsPerPage);
            tbody.innerHTML = paginatedProducts.map(p => {
                const name = escape(p.name);
                const code = escape(p.code);
                const brand = escape(p.brand);
                const category = escape(p.category);
                const unit = escape(p.unit || 'Pcs');
                
                const id = escape(p.id || '');
                const type = escape((p.type || 'Product').charAt(0).toUpperCase() + (p.type || 'Product').slice(1));
                const project = escape(p.project || '-');
                const imgFile = getFirstImagePath(p);
                const imgHtml = imgFile 
                    ? `<img src="/images/products/${escape(imgFile)}" class="w-10 h-10 object-cover rounded-xl border" />`
                    : `<div class=\"w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-[10px] text-gray-400 border\">No image</div>`;
                return `
                    <tr class="hover:bg-gray-50 transition-colors" data-name="${name.toLowerCase()}" data-code="${code.toLowerCase()}" data-brand="${brand.toLowerCase()}" data-category="${category.toLowerCase()}">
                        <td class="px-3 py-2"><input type="checkbox" class="selectRow" value="${id}"></td>
                        <td class="px-3 py-2">${imgHtml}</td>
                        <td class="px-3 py-2 text-[12px] text-gray-700">${type}</td>
                        <td class="px-3 py-2 text-[13px] font-medium text-gray-900 whitespace-nowrap truncate max-w-[220px] pr-2">${name || '-'}</td>
                        <td class="px-3 py-2"><span class="inline-block text-[11px] px-2 py-1 rounded-xl bg-violet-50 text-violet-700 border border-violet-200 whitespace-nowrap">Tag</span></td>
                        <td class="px-3 py-2 text-[13px] text-gray-700 whitespace-nowrap truncate max-w-[160px]">${project}</td>
                        <td class="px-3 py-2 text-[13px] text-gray-700 whitespace-nowrap truncate max-w-[140px]">${code || '-'}</td>
                        <td class="px-3 py-2 text-[13px] text-gray-700 whitespace-nowrap truncate max-w-[140px]">${brand || '-'}</td>
                        <td class="px-3 py-2 text-[13px] text-gray-700">${unit}</td>
                        ${!isAdmin ? `
                        <td class="px-3 py-2 text-[13px] text-gray-700">
                            ${(p.status && p.status === 'Pending') ? 
                                '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>Pending</span>' : 
                                (p.is_active == 1) ? 
                                '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>Approved</span>' : 
                                (p.is_active == 2) ?
                                '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>Rejected</span>' :
                                '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>Unknown</span>'
                            }
                        </td>` : ''}
                        <td class="px-3 py-2 text-[13px] text-gray-700">
                            <div class="flex items-center gap-2 justify-end">
                                <a href="/products/${id}" class="w-8 h-8 rounded-full border border-blue-300 text-blue-600 hover:bg-blue-50 grid place-items-center" title="View">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                <button class="w-8 h-8 rounded-full border border-emerald-300 text-emerald-600 hover:bg-emerald-50 grid place-items-center" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5Z"/></svg>
                                </button>
                                <button class="w-8 h-8 rounded-full border border-rose-300 text-rose-600 hover:bg-rose-50 grid place-items-center" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 6h18"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>`;
            }).join('');
            updatePaginationInfo(filteredProducts, currentPage, rowsPerPage);
            updatePaginationButtons(filteredProducts, currentPage, rowsPerPage);
        }
    });
    
    document.getElementById('nextBtn').addEventListener('click', () => {
        const totalPages = Math.ceil(filteredProducts.length / rowsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            const paginatedProducts = getPaginatedProducts(filteredProducts, currentPage, rowsPerPage);
            tbody.innerHTML = paginatedProducts.map(p => {
                const name = escape(p.name);
                const code = escape(p.code);
                const brand = escape(p.brand);
                const category = escape(p.category);
                const unit = escape(p.unit || 'Pcs');
                
                const id = escape(p.id || '');
                const type = escape((p.type || 'Product').charAt(0).toUpperCase() + (p.type || 'Product').slice(1));
                const project = escape(p.project || '-');
                const imgFile = getFirstImagePath(p);
                const imgHtml = imgFile 
                    ? `<img src="/images/products/${escape(imgFile)}" class="w-10 h-10 object-cover rounded-xl border" />`
                    : `<div class=\"w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-[10px] text-gray-400 border\">No image</div>`;
                return `
                    <tr class="hover:bg-gray-50 transition-colors" data-name="${name.toLowerCase()}" data-code="${code.toLowerCase()}" data-brand="${brand.toLowerCase()}" data-category="${category.toLowerCase()}">
                        <td class="px-3 py-2"><input type="checkbox" class="selectRow" value="${id}"></td>
                        <td class="px-3 py-2">${imgHtml}</td>
                        <td class="px-3 py-2 text-[12px] text-gray-700">${type}</td>
                        <td class="px-3 py-2 text-[13px] font-medium text-gray-900 whitespace-nowrap truncate max-w-[220px] pr-2">${name || '-'}</td>
                        <td class="px-3 py-2"><span class="inline-block text-[11px] px-2 py-1 rounded-xl bg-violet-50 text-violet-700 border border-violet-200 whitespace-nowrap">Tag</span></td>
                        <td class="px-3 py-2 text-[13px] text-gray-700 whitespace-nowrap truncate max-w-[160px]">${project}</td>
                        <td class="px-3 py-2 text-[13px] text-gray-700 whitespace-nowrap truncate max-w-[140px]">${code || '-'}</td>
                        <td class="px-3 py-2 text-[13px] text-gray-700 whitespace-nowrap truncate max-w-[140px]">${brand || '-'}</td>
                        <td class="px-3 py-2 text-[13px] text-gray-700">${unit}</td>
                        ${!isAdmin ? `
                        <td class="px-3 py-2 text-[13px] text-gray-700">
                            ${(p.status && p.status === 'Pending') ? 
                                '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>Pending</span>' : 
                                (p.is_active == 1) ? 
                                '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>Approved</span>' : 
                                (p.is_active == 2) ?
                                '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>Rejected</span>' :
                                '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>Unknown</span>'
                            }
                        </td>` : ''}
                        <td class="px-3 py-2 text-[13px] text-gray-700">
                            <div class="flex items-center gap-2 justify-end">
                                <a href="/products/${id}" class="w-8 h-8 rounded-full border border-blue-300 text-blue-600 hover:bg-blue-50 grid place-items-center" title="View">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                <button class="w-8 h-8 rounded-full border border-emerald-300 text-emerald-600 hover:bg-emerald-50 grid place-items-center" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5Z"/></svg>
                                </button>
                                <button class="w-8 h-8 rounded-full border border-rose-300 text-rose-600 hover:bg-rose-50 grid place-items-center" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 6h18"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>`;
            }).join('');
            updatePaginationInfo(filteredProducts, currentPage, rowsPerPage);
            updatePaginationButtons(filteredProducts, currentPage, rowsPerPage);
        }
    });

    // Export handlers include current filters from the modal selections and search input
    function currentFiltersQuery() {
        const params = new URLSearchParams();
        const code = document.getElementById('filterCode')?.value || '';
        const name = document.getElementById('filterProduct')?.value || '';
        const category = document.getElementById('filterCategory')?.value || '';
        const brand = document.getElementById('filterBrand')?.value || '';
        if (code) params.set('code', code);
        if (name) params.set('name', name);
        if (category) params.set('category_id', category);
        if (brand) params.set('brand_id', brand);
        return params.toString();
    }

    document.getElementById('exportPdfBtn')?.addEventListener('click', (e)=>{
        e.preventDefault();
        const qs = currentFiltersQuery();
        const url = qs ? `${exportPdfUrl}?${qs}` : exportPdfUrl;
        window.open(url, '_blank');
    });
    document.getElementById('exportExcelBtn')?.addEventListener('click', (e)=>{
        e.preventDefault();
        const qs = currentFiltersQuery();
        const url = qs ? `${exportExcelUrl}?${qs}` : exportExcelUrl;
        window.location.href = url;
    });
})();

// Select all
document.getElementById('selectAll')?.addEventListener('change', (e)=>{
    const checked = e.target.checked;
    document.querySelectorAll('.selectRow').forEach(cb => { cb.checked = checked; });
});

// Approve selected
document.getElementById('approveBtn').addEventListener('click', async () => {
    const ids = Array.from(document.querySelectorAll('.selectRow:checked')).map(i => i.value).filter(Boolean);
    if (ids.length === 0) { alert('Select at least one product'); return; }
    
    // For each selected product, call the individual approve route
    for (const id of ids) {
        try {
            const res = await fetch(`/app/products/${id}/approve`, { 
                method:'POST', 
                headers:{ 
                    'Content-Type':'application/json', 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                }
            });
            if (!res.ok) {
                alert(`Failed to approve product ${id}`);
                return;
            }
        } catch (error) {
            alert(`Error approving product ${id}: ${error.message}`);
            return;
        }
    }
    alert('All selected products approved successfully');
    location.reload(); // Refresh the page to show updated status
});

// Import modal
const importModal = document.getElementById('importModal');
document.getElementById('importBtn').addEventListener('click', ()=> importModal.classList.remove('hidden'));
document.getElementById('closeImport').addEventListener('click', ()=> importModal.classList.add('hidden'));
    document.getElementById('importForm').addEventListener('submit', async (e)=>{
    e.preventDefault();
    const formData = new FormData(e.target);
    const res = await fetch('{{ route('products.import') }}', { method:'POST', headers:{ 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }, body: formData });
    if (res.ok) { alert('Imported'); importModal.classList.add('hidden'); } else { alert('Import failed'); }
});

// Initialize pagination on page load
document.addEventListener('DOMContentLoaded', function() {
    const initialProducts = @json($allProducts ?? []);
    const tbody = document.getElementById('productsTable');
    const isAdmin = {{ auth()->user()->role_id == 1 ? 'true' : 'false' }};
    
    if (tbody && initialProducts.length > 0) {
        // Update pagination info
        const total = initialProducts.length;
        const start = 1;
        const end = Math.min(10, total);
        document.getElementById('paginationInfo').textContent = `${start} - ${end} of ${total}`;
        
        // Update pagination buttons
        const totalPages = Math.ceil(total / 10);
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        
        prevBtn.disabled = true;
        nextBtn.disabled = totalPages <= 1;
        
        prevBtn.classList.add('text-gray-400');
        prevBtn.classList.remove('text-violet-600');
        
        if (totalPages <= 1) {
            nextBtn.classList.add('text-gray-400');
            nextBtn.classList.remove('text-violet-600');
        } else {
            nextBtn.classList.remove('text-gray-400');
            nextBtn.classList.add('text-violet-600');
        }
    }
});
</script>
@endpush