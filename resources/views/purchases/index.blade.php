index

@extends('layouts.app')

@section('content')
<div class="bg-white border border-gray-200 rounded-lg p-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <!-- Title and Breadcrumb -->
        <div class="flex items-baseline gap-3">
            <div class="text-2xl font-semibold">All Purchases</div>
            <div class="text-sm text-slate-500">Purchase | All Purchases</div>
        </div>
        
        <!-- Search Bar -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input id="tableSearch" type="text" placeholder="Search this table" class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-violet-500 focus:border-transparent">
        </div>
        
        <!-- Action Buttons -->
        <div class="flex items-center space-x-4">
            <button type="button" onclick="document.getElementById('filterPanel').classList.remove('hidden')" class="flex items-center px-4 py-2 border border-blue-200 text-blue-600 bg-white rounded-md hover:bg-blue-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filter
            </button>
            
            <a href="{{ request()->fullUrlWithQuery(['export'=>'pdf']) }}" target="_blank" class="flex items-center px-4 py-2 border border-green-200 text-green-600 bg-white rounded-md hover:bg-green-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                PDF
            </a>
            
            <a href="{{ request()->fullUrlWithQuery(['export'=>'excel']) }}" download class="flex items-center px-4 py-2 border border-orange-200 text-orange-600 bg-white rounded-md hover:bg-orange-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                EXCEL
            </a>
            
            <a href="{{ route('purchases.create') }}" class="flex items-center px-4 py-2 bg-violet-600 text-white rounded-md hover:bg-violet-700 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Create
            </a>
        </div>
    </div>
    <!-- Table Section -->
    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr class="border-b border-gray-200">
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">
                        <input type="checkbox" class="rounded border-gray-300 text-violet-600 focus:ring-violet-500">
                    </th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Image</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Item</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Qty</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Category</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Date</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Supplier</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Warehouse</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Note</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Action</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($purchases as $p)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="px-3 py-3">
                        <input type="checkbox" class="rounded border-gray-300 text-violet-600 focus:ring-violet-500">
                    </td>
                    <td class="px-3 py-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-[10px] text-gray-400 border">image</div>
                    </td>
                    <td class="px-3 py-3 text-[13px] font-medium text-gray-900 whitespace-nowrap truncate max-w-[220px] pr-2">{{ $p->item }}</td>
                    <td class="px-3 py-3 text-[13px] text-gray-700">{{ (int)$p->qty }}</td>
                    <td class="px-3 py-3 text-[13px] text-gray-700">{{ $p->category }}</td>
                    <td class="px-3 py-3 text-[13px] text-gray-700">{{ $p->date }}</td>
                    <td class="px-3 py-3 text-[13px] text-gray-700 whitespace-nowrap truncate max-w-[140px]">{{ $p->supplier }}</td>
                    <td class="px-3 py-3 text-[13px] text-gray-700 whitespace-nowrap truncate max-w-[140px]">{{ $p->warehouse }}</td>
                    <td class="px-3 py-3 text-[13px] text-gray-700 whitespace-nowrap truncate max-w-[160px]">{{ $p->note }}</td>
                    <td class="px-3 py-3 text-[13px] text-gray-700">
                        <div class="flex items-center gap-2 justify-end">
                            <a href="{{ route('purchases.show',$p->purchase_id) }}" class="w-8 h-8 rounded-full border border-blue-300 text-blue-600 hover:bg-blue-50 grid place-items-center" title="View">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            <a href="{{ route('purchases.edit',$p->purchase_id) }}" class="w-8 h-8 rounded-full border border-emerald-300 text-emerald-600 hover:bg-emerald-50 grid place-items-center" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5Z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('purchases.destroy',$p->purchase_id) }}" onsubmit="return confirm('Delete this purchase?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-full border border-rose-300 text-rose-600 hover:bg-rose-50 grid place-items-center" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 6h18"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-4 py-8 text-center text-gray-500">No purchases found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="flex items-center justify-between text-sm text-gray-600 px-6 py-4 border-t border-gray-200 bg-gray-50">
        <div class="flex items-center gap-2">
            <span>Rows per page:</span>
            <select class="border border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="text-gray-700">
            {{ $purchases->firstItem() ?? 0 }} - {{ $purchases->lastItem() ?? 0 }} of {{ $purchases->total() }}
        </div>
        <div class="flex items-center gap-4">
            <button class="px-3 py-1 text-sm text-gray-500 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed" {{ $purchases->onFirstPage() ? 'disabled' : '' }}>
                <span class="text-xs">prev</span>
            </button>
            <button class="px-3 py-1 text-sm text-gray-500 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed" {{ $purchases->hasMorePages() ? '' : 'disabled' }}>
                <span class="text-xs">next</span>
            </button>
        </div>
    </div>
</div>

<!-- Filter Panel -->
<div id="filterPanel" class="fixed inset-y-0 right-0 z-40 w-full max-w-sm bg-white border-l border-gray-200 shadow-xl hidden">
    <div class="flex items-center justify-between p-4 border-b">
        <button type="button" onclick="document.getElementById('filterPanel').classList.add('hidden')" class="text-slate-500">✕</button>
        <div class="font-semibold">Filter</div>
    </div>
    <form method="GET" action="{{ route('purchases.index') }}" class="p-4 space-y-4">
        <div>
            <label class="block text-sm text-slate-600 mb-1">Date</label>
            <input type="date" name="date" value="{{ request('date') }}" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-sm text-slate-600 mb-1">Reference</label>
            <input type="text" name="ref" value="{{ request('ref') }}" class="w-full border rounded px-3 py-2" placeholder="Reference">
        </div>
        <div>
            <label class="block text-sm text-slate-600 mb-1">Supplier</label>
            <select name="supplier_id" class="w-full border rounded px-3 py-2">
                <option value="">Choose Supplier</option>
                @foreach($supplierOptions as $sid => $label)
                <option value="{{ $sid }}" @selected(request('supplier_id')==$sid)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-slate-600 mb-1">Warehouse</label>
            <select name="warehouse_id" class="w-full border rounded px-3 py-2">
                <option value="">Choose Warehouse</option>
                @foreach($warehouseOptions as $wid => $label)
                <option value="{{ $wid }}" @selected(request('warehouse_id')==$wid)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-slate-600 mb-1">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="">Choose Status</option>
                <option value="received" @selected(request('status')=='received')>Received</option>
                <option value="pending" @selected(request('status')=='pending')>Pending</option>
                <option value="cancelled" @selected(request('status')=='cancelled')>Cancelled</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <button type="submit" class="flex items-center px-4 py-2 bg-violet-600 text-white rounded">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filter
            </button>
            <a href="{{ route('purchases.index') }}" class="flex items-center px-4 py-2 bg-red-600 text-white rounded">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Reset
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
  (function(){
    const input = document.getElementById('tableSearch');
    const body = document.getElementById('tableBody');
    if(!input || !body) return;
    
    input.addEventListener('input', function(){
      const q = (this.value||'').toLowerCase();
      body.querySelectorAll('tr').forEach(tr =>{
        const text = tr.innerText.toLowerCase();
        tr.style.display = text.includes(q) ? '' : 'none';
      });
    });
  })();
</script>
@endpush