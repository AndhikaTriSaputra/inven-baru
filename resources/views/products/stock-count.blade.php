@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Success Message -->
    @if (session('success'))
        <x-alert type="success" dismissible class="mb-6">
            {{ session('success') }}
        </x-alert>
    @endif

    <!-- Error Message -->
    @if (session('error'))
        <x-alert type="error" dismissible class="mb-6">
            {{ session('error') }}
        </x-alert>
    @endif

    <!-- Header Section -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-heading-2">Stock Count</h1>
            <p class="text-body-sm mt-1">Manage inventory stock counting operations</p>
        </div>
        
        <!-- Search Bar -->
        <div class="relative">
            <div class="input-search-icon">
                <x-icon name="search" size="sm" class="text-gray-400" />
            </div>
            <input id="tableSearch" type="text" placeholder="Search stock counts..." class="form-input input-search w-64">
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <x-button onclick="document.getElementById('filterPanel').classList.remove('hidden')" variant="secondary" icon="filter">
                Filter
            </x-button>
            <x-button onclick="openCountModal()" variant="primary" icon="plus">
                Count
            </x-button>
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
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">file</th>
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
                        @php
                            $fileVal = $stockCount->file ?? ($stockCount->file_stock ?? null);
                            $href = $fileVal ? (\Illuminate\Support\Str::startsWith($fileVal, ['http://','https://','/']) ? $fileVal : asset('uploads/'.$fileVal)) : null;
                        @endphp
                        @if($href)
                            <a class="text-violet-600 hover:underline" href="{{ $href }}" download>Download</a>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                        </tr>
                        @empty
                        <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">No stock counts found. Click "Count" to create.</td>
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
                @if(isset($warehouses) && count($warehouses))
                    @foreach($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}" @selected(request('warehouse_id')==$warehouse->id)>{{ $warehouse->name }}</option>
                    @endforeach
                @else
                    <option value="" disabled>No warehouses available</option>
                @endif
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
                            @if(isset($warehouses) && count($warehouses))
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            @else
                                <option value="" disabled>No warehouses available</option>
                            @endif
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