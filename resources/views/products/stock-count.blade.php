@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
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
            <div class="text-2xl font-semibold">Stock Count</div>
            <div class="text-sm text-slate-500">Products | Stock Count</div>
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
            
            <button onclick="startCount()" class="flex items-center px-4 py-2 bg-violet-600 text-white rounded-md hover:bg-violet-700 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                New Count
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="px-3 py-3 text-left">
                        <input type="checkbox" class="rounded border-gray-300 text-violet-600 focus:ring-violet-500">
                    </th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Date</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Warehouse</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Status</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Created At</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Action</th>
                        </tr>
                    </thead>
            <tbody id="tableBody">
                @forelse($stockCounts as $stockCount)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="px-3 py-3">
                        <input type="checkbox" class="rounded border-gray-300 text-violet-600 focus:ring-violet-500">
                            </td>
                    <td class="px-3 py-3 text-gray-700">{{ \Carbon\Carbon::parse($stockCount->date)->format('M d, Y') }}</td>
                    <td class="px-3 py-3 text-gray-700 font-medium">{{ $stockCount->warehouse_name ?? 'Unknown Warehouse' }}</td>
                    <td class="px-3 py-3">
                        @if($stockCount->status === 'pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                Pending
                            </span>
                        @elseif($stockCount->status === 'in_progress')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                In Progress
                            </span>
                        @elseif($stockCount->status === 'completed')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Completed
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Error
                                </span>
                        @endif
                            </td>
                    <td class="px-3 py-3 text-gray-500">{{ \Carbon\Carbon::parse($stockCount->created_at)->format('M d, Y H:i') }}</td>
                    <td class="px-3 py-3">
                        <div class="flex items-center gap-2 justify-end">
                            <a href="{{ route('stock-count.show', $stockCount->id) }}" class="w-8 h-8 rounded-full border border-blue-300 text-blue-600 hover:bg-blue-50 grid place-items-center" title="View">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            <a href="{{ route('stock-count.edit', $stockCount->id) }}" class="w-8 h-8 rounded-full border border-emerald-300 text-emerald-600 hover:bg-emerald-50 grid place-items-center" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5Z"/></svg>
                            </a>
                            <button onclick="deleteStockCount({{ $stockCount->id }})" class="w-8 h-8 rounded-full border border-rose-300 text-rose-600 hover:bg-rose-50 grid place-items-center" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 6h18"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                </button>
                        </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">No stock counts found. Create your first count by clicking the "New Count" button above.</td>
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
                {{ $stockCounts->firstItem() ?? 0 }} - {{ $stockCounts->lastItem() ?? 0 }} of {{ $stockCounts->total() }}
            </span>
            <div class="flex items-center space-x-1">
                <button class="px-3 py-1 text-sm text-gray-500 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed" {{ $stockCounts->onFirstPage() ? 'disabled' : '' }}>
                    <span class="text-xs">prev</span>
                </button>
                <button class="px-3 py-1 text-sm text-gray-500 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed" {{ $stockCounts->hasMorePages() ? '' : 'disabled' }}>
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
    <form method="GET" action="{{ route('stock-count.index') }}" class="p-4 space-y-4">
        <div>
            <label class="block text-sm text-slate-600 mb-1">Date</label>
            <input type="date" name="date" value="{{ request('date') }}" class="w-full border rounded px-3 py-2">
                </div>
                <div>
            <label class="block text-sm text-slate-600 mb-1">Warehouse</label>
            <select name="warehouse_id" class="w-full border rounded px-3 py-2">
                <option value="">Choose Warehouse</option>
                @foreach($warehouses ?? [] as $warehouse)
                    <option value="{{ $warehouse->id }}" @selected(request('warehouse_id')==$warehouse->id)>{{ $warehouse->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-slate-600 mb-1">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="">Choose Status</option>
                <option value="pending" @selected(request('status')=='pending')>Pending</option>
                <option value="in_progress" @selected(request('status')=='in_progress')>In Progress</option>
                <option value="completed" @selected(request('status')=='completed')>Completed</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <button type="submit" class="flex items-center px-4 py-2 bg-violet-600 text-white rounded">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filter
            </button>
                </div>
    </form>
            </div>

<!-- Count Stock Modal -->
<div id="countStockModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-6 border w-[420px] shadow-lg rounded-lg bg-white">
        <!-- Modal Header -->
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold text-gray-900">New Stock Count</h3>
            <button onclick="closeCountModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Modal Body -->
        <form id="countStockForm" method="POST" action="{{ route('stock-count.store') }}">
            @csrf
            <div class="space-y-6">
                <!-- Date Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Date <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="date" name="date" id="countDate" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 text-sm" value="{{ date('Y-m-d') }}" required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                </div>
            </div>
        </div>
        
                <!-- Warehouse Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Warehouse <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="warehouse_id" id="countWarehouse" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 text-sm appearance-none bg-white" required>
                            <option value="">Select Warehouse</option>
                            @foreach($warehouses ?? [] as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="closeCountModal()" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-violet-600 text-white text-sm font-medium rounded-md hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Create Count
                </button>
        </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Delete stock count function
function deleteStockCount(stockCountId) {
    if (confirm('Are you sure you want to delete this stock count? This action cannot be undone.')) {
        // Show loading state
        const deleteBtn = event.target.closest('button');
        const originalContent = deleteBtn.innerHTML;
        deleteBtn.innerHTML = '<svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
        deleteBtn.disabled = true;
        
        // Create a form to submit DELETE request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/app/products/stock-count/${stockCountId}`;
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add method override for DELETE
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        // Submit form
        document.body.appendChild(form);
        form.submit();
    }
}

// Search functionality
(function(){
    const input = document.getElementById('tableSearch');
    const body = document.getElementById('tableBody');
    if(!input || !body) return;
    
    // Store all stock counts data for search
    const allStockCounts = @json($stockCounts->items() ?? []);
    
    input.addEventListener('input', function(){
        const q = (this.value||'').toLowerCase();
        body.querySelectorAll('tr').forEach(tr =>{
            const text = tr.innerText.toLowerCase();
            tr.style.display = text.includes(q) ? '' : 'none';
        });
    });
})();

// Start count function
function startCount() {
    console.log('Opening count stock modal...');
    openCountModal();
}

// Open count modal
function openCountModal() {
    const modal = document.getElementById('countStockModal');
    if (modal) {
        modal.classList.remove('hidden');
        // Set today's date as default
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('countDate').value = today;
    }
}

// Close count modal
function closeCountModal() {
    const modal = document.getElementById('countStockModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('countStockModal');
    if (event.target === modal) {
        closeCountModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeCountModal();
    }
});
</script>
@endpush