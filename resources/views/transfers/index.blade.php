@extends('layouts.app')

@section('header')
@endsection

@section('content')
<div class="bg-white border border-gray-200 rounded-lg shadow-sm">
    <!-- Page Title and Breadcrumb -->
    <div class="p-6 border-b border-gray-200">
        <h1 class="text-2xl font-bold text-gray-900">All Transfers</h1>
        <div class="text-sm text-gray-500 flex items-center gap-3 mt-1">
            <a class="font-medium text-gray-700 hover:text-violet-600" href="#">Transfer</a>
            <span class="text-gray-300">|</span>
            <span>All Transfers</span>
        </div>
    </div>
    
    <!-- Search and Action Bar -->
    <div class="flex items-center justify-between p-6 border-b border-gray-200">
        <!-- Search Bar -->
        <div class="relative">
            <div class="input-search-icon">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input id="tableSearch" type="text" placeholder="Search this table" class="form-input input-search w-64 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-violet-500 focus:border-transparent">
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
            
            <a href="{{ route('transfers.create') }}" class="flex items-center px-4 py-2 bg-violet-600 text-white rounded-md hover:bg-violet-700 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Create
            </a>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="px-3 py-3 text-left">
                        <input type="checkbox" class="rounded border-gray-300 text-violet-600 focus:ring-violet-500">
                    </th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">
                        <div class="flex items-center space-x-1">
                            <span>Date</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                        </div>
                    </th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">
                        <div class="flex items-center space-x-1">
                            <span>Reference</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                        </div>
                    </th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">
                        <div class="flex items-center space-x-1">
                            <span>From Warehouse</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                        </div>
                    </th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">
                        <div class="flex items-center space-x-1">
                            <span>To Warehouse</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                        </div>
                    </th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">
                        <div class="flex items-center space-x-1">
                            <span>Items</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                        </div>
                    </th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">
                        <div class="flex items-center space-x-1">
                            <span>Category</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                        </div>
                    </th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">
                        <div class="flex items-center space-x-1">
                            <span>Status</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                        </div>
                    </th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Action</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($transfers as $t)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="px-3 py-3">
                        <input type="checkbox" class="rounded border-gray-300 text-violet-600 focus:ring-violet-500">
                    </td>
                    <td class="px-3 py-3 text-gray-700">{{ $t->date }}</td>
                    <td class="px-3 py-3 text-gray-700 font-medium">{{ $t->reference }}</td>
                    <td class="px-3 py-3 text-gray-700">{{ $t->from_wh }}</td>
                    <td class="px-3 py-3 text-gray-700">{{ $t->to_wh }}</td>
                    <td class="px-3 py-3 text-gray-700">{{ number_format($t->items, 2) }}</td>
                    <td class="px-3 py-3 text-gray-700">{{ $t->category }}</td>
                    <td class="px-3 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ strtolower($t->statut)==='completed' ? 'bg-green-100 text-green-800' : (strtolower($t->statut)==='pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ ucfirst($t->statut) }}
                        </span>
                    </td>
                    <td class="px-3 py-3">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('transfers.show', $t->id) }}" class="p-1 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded" title="View">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('transfers.edit', $t->id) }}" class="p-1 text-green-600 hover:text-green-800 hover:bg-green-50 rounded" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('transfers.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Delete this transfer?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 text-red-600 hover:text-red-800 hover:bg-red-50 rounded" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-4 py-8 text-center text-gray-500">No transfers found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50">
        <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-700">Rows per page:</span>
            <select class="text-sm border border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-violet-500 focus:border-transparent bg-white">
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-700">
                {{ $transfers->firstItem() ?? 0 }} - {{ $transfers->lastItem() ?? 0 }} of {{ $transfers->total() }}
            </span>
            <div class="flex items-center space-x-1">
                <button class="px-3 py-1 text-sm text-gray-500 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed" {{ $transfers->onFirstPage() ? 'disabled' : '' }}>
                    <span class="text-xs">prev</span>
                </button>
                <button class="px-3 py-1 text-sm text-gray-500 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed" {{ $transfers->hasMorePages() ? '' : 'disabled' }}>
                    <span class="text-xs">next</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Filter Panel -->
<div id="filterPanel" class="fixed inset-y-0 right-0 z-40 w-full max-w-sm bg-white border-l border-gray-200 shadow-xl hidden">
    <div class="flex items-center justify-between p-4 border-b">
        <button type="button" onclick="document.getElementById('filterPanel').classList.add('hidden')" class="text-slate-500">✕</button>
        <div class="font-semibold">Filter</div>
    </div>
    <form method="GET" action="{{ route('transfers.index') }}" class="p-4 space-y-4">
        <div>
            <label class="block text-sm text-slate-600 mb-1">Reference</label>
            <input type="text" name="reference" value="{{ request('reference') }}" class="w-full border rounded px-3 py-2" placeholder="Reference">
        </div>
        <div>
            <label class="block text-sm text-slate-600 mb-1">From Warehouse</label>
            <select name="from_warehouse_id" class="w-full border rounded px-3 py-2">
                <option value="">Choose Warehouse</option>
                @foreach($warehouseOptions as $wid => $label)
                <option value="{{ $wid }}" @selected(request('from_warehouse_id')==$wid)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-slate-600 mb-1">To Warehouse</label>
            <select name="to_warehouse_id" class="w-full border rounded px-3 py-2">
                <option value="">Choose Warehouse</option>
                @foreach($warehouseOptions as $wid => $label)
                <option value="{{ $wid }}" @selected(request('to_warehouse_id')==$wid)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-slate-600 mb-1">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="">Choose Status</option>
                <option value="pending" @selected(request('status')=='pending')>Pending</option>
                <option value="completed" @selected(request('status')=='completed')>Completed</option>
                <option value="cancelled" @selected(request('status')=='cancelled')>Cancelled</option>
            </select>
        </div>
        <div>
            <label class="block text-sm text-slate-600 mb-1">Category</label>
            <select name="category" class="w-full border rounded px-3 py-2">
                <option value="">Choose Category</option>
                <option value="Stock" @selected(request('category')=='Stock')>Stock</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <button type="submit" class="flex items-center px-4 py-2 bg-violet-600 text-white rounded">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filter
            </button>
            <a href="{{ route('transfers.index') }}" class="flex items-center px-4 py-2 bg-red-600 text-white rounded">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Reset
            </a>
        </div>
    </form>
</div>

@if(!empty($detailHeader))
  <!-- Inline Detail Modal -->
  <div class="fixed inset-0 flex items-start md:items-center justify-center z-[70]">
      <div class="absolute inset-0 bg-black/40 backdrop-blur-[1px]"></div>
      <div class="relative mt-20 md:mt-0 w-[92%] md:w-[720px] bg-white rounded-xl shadow-xl border border-gray-200">
          <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
              <div class="font-semibold text-gray-800">Transfer Detail</div>
              <a href="{{ route('transfers.index') }}" class="text-slate-400 hover:text-slate-600">✕</a>
          </div>
          <div class="px-6 py-5">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
                  <div>
                      <div class="text-xs text-slate-500">Date</div>
                      <div class="mt-1 font-medium">{{ \Carbon\Carbon::parse($detailHeader->date)->format('Y-m-d') }}</div>
                  </div>
                  <div>
                      <div class="text-xs text-slate-500">Reference</div>
                      <div class="mt-1 font-medium">{{ $detailHeader->Ref }}</div>
                  </div>
                  <div>
                      <div class="text-xs text-slate-500">Status</div>
                      <div class="mt-1">
                          <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $detailHeader->statut == 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                              {{ ucfirst($detailHeader->statut ?? 'pending') }}
                          </span>
                      </div>
                  </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                  <div>
                      <div class="text-xs text-slate-500">From Warehouse</div>
                      <div class="mt-1 font-medium">{{ $detailFromWarehouse ?? '—' }}</div>
                  </div>
                  <div>
                      <div class="text-xs text-slate-500">To Warehouse</div>
                      <div class="mt-1 font-medium">{{ $detailToWarehouse ?? '—' }}</div>
                  </div>
              </div>
              <div class="overflow-x-auto border border-gray-200 rounded-lg">
                  <table class="w-full text-sm">
                      <thead class="bg-slate-50">
                          <tr>
                              <th class="px-4 py-2 text-left">Product</th>
                              <th class="px-4 py-2 text-left">Code Product</th>
                              <th class="px-4 py-2 text-left">Quantity</th>
                              <th class="px-4 py-2 text-left">Subtotal</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($detailItems as $row)
                          <tr class="border-t">
                              <td class="px-4 py-2">{{ $row->product_name }}</td>
                              <td class="px-4 py-2">{{ $row->product_code }}</td>
                              <td class="px-4 py-2">{{ (float)$row->quantity }} {{ $row->unit ?? 'Pcs' }}</td>
                              <td class="px-4 py-2">$ {{ number_format($row->total, 2) }}</td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
              @if(!empty($detailHeader->notes))
              <div class="mt-5">
                  <div class="text-xs text-slate-500 mb-1">Note</div>
                  <div class="p-3 bg-slate-50 rounded border border-slate-200">{{ $detailHeader->notes }}</div>
              </div>
              @endif
          </div>
          <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-3">
              <a href="{{ route('transfers.index') }}" class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50">OK</a>
              <a href="{{ route('transfers.edit',$detailHeader->id) }}" class="px-4 py-2 bg-violet-600 text-white rounded-md hover:bg-violet-700">Edit</a>
          </div>
      </div>
  </div>
@endif
@endsection

@push('scripts')
<script>
  (function(){
    const input = document.getElementById('tableSearch');
    const body = document.getElementById('tableBody');
    if(!input || !body) return;
    
    // Store all transfers data for search
    const allTransfers = @json($allTransfers ?? []);
    
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