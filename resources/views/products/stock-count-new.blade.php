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
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <x-icon name="search" size="sm" class="text-gray-400" />
            </div>
            <input id="tableSearch" type="text" placeholder="Search stock counts..." class="form-input pl-10 w-64">
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <x-button onclick="document.getElementById('filterPanel').classList.remove('hidden')" variant="secondary" icon="filter">
                Filter
            </x-button>
            <x-button onclick="openCountModal()" variant="primary" icon="plus">
                New Stock Count
            </x-button>
        </div>
    </div>

    <!-- Table -->
    <x-table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Warehouse</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @forelse($stockCounts as $stockCount)
            <tr>
                <td>{{ \Carbon\Carbon::parse($stockCount->date)->format('d M Y') }}</td>
                <td>{{ $stockCount->warehouse_name ?? 'Unknown Warehouse' }}</td>
                <td>
                    <x-badge variant="{{ $stockCount->status == 'pending' ? 'warning' : ($stockCount->status == 'in_progress' ? 'primary' : 'success') }}">
                        {{ ucfirst(str_replace('_', ' ', $stockCount->status)) }}
                    </x-badge>
                </td>
                <td>{{ $stockCount->created_by ?? 'System' }}</td>
                <td>
                    <div class="flex items-center gap-2">
                        <x-button href="{{ route('stock-count.show', $stockCount->id) }}" variant="ghost" size="sm" icon="view">
                            View
                        </x-button>
                        <x-button href="{{ route('stock-count.edit', $stockCount->id) }}" variant="ghost" size="sm" icon="edit">
                            Edit
                        </x-button>
                        <x-button onclick="deleteStockCount({{ $stockCount->id }})" variant="ghost" size="sm" icon="delete">
                            Delete
                        </x-button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-12">
                    <x-icon name="warehouse" size="xl" class="mx-auto mb-4 text-gray-400" />
                    <h3 class="text-heading-4 text-gray-500 mb-2">No stock counts found</h3>
                    <p class="text-body-sm text-gray-400">Create your first stock count to get started</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </x-table>

    <!-- Pagination -->
    @if($stockCounts->hasPages())
        <div class="mt-6">
            {{ $stockCounts->links() }}
        </div>
    @endif

    <!-- Filter Panel -->
    <div id="filterPanel" class="hidden mt-6">
        <x-card>
            <x-slot name="header">
                <div class="flex items-center justify-between">
                    <h3 class="text-heading-4">Filter Stock Counts</h3>
                    <x-button onclick="document.getElementById('filterPanel').classList.add('hidden')" variant="ghost" size="sm" icon="close">
                        Close
                    </x-button>
                </div>
            </x-slot>
            
            <form action="{{ route('products.stock_count') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <x-input type="date" label="Date From" name="date_from" value="{{ request('date_from') }}" />
                </div>
                <div>
                    <x-input type="date" label="Date To" name="date_to" value="{{ request('date_to') }}" />
                </div>
                <div>
                    <x-input type="select" label="Warehouse" name="warehouse_id">
                        <option value="">All Warehouses</option>
                        @foreach($warehouses ?? [] as $warehouse)
                            <option value="{{ $warehouse->id }}" @selected(request('warehouse_id') == $warehouse->id)>
                                {{ $warehouse->name }}
                            </option>
                        @endforeach
                    </x-input>
                </div>
                <div>
                    <x-input type="select" label="Status" name="status">
                        <option value="">All Status</option>
                        <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                        <option value="in_progress" @selected(request('status') == 'in_progress')>In Progress</option>
                        <option value="completed" @selected(request('status') == 'completed')>Completed</option>
                    </x-input>
                </div>
                <div class="md:col-span-3 flex items-center gap-3">
                    <x-button type="submit" variant="primary" icon="filter">
                        Apply Filters
                    </x-button>
                    <x-button href="{{ route('products.stock_count') }}" variant="secondary">
                        Clear Filters
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>

    <!-- Count Stock Modal -->
    <div id="countStockModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-6 border w-[420px] shadow-lg rounded-lg bg-white">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-heading-4">New Stock Count</h3>
                <x-button onclick="closeCountModal()" variant="ghost" size="sm" icon="close">
                    Close
                </x-button>
            </div>
            
            <!-- Modal Body -->
            <form id="countStockForm" method="POST" action="{{ route('stock-count.store') }}">
                @csrf
                <div class="space-y-6">
                    <!-- Date Field -->
                    <x-input type="date" label="Date" name="date" id="countDate" value="{{ date('Y-m-d') }}" required />
                    
                    <!-- Warehouse Field -->
                    <x-input type="select" label="Warehouse" name="warehouse_id" id="countWarehouse" required>
                        <option value="">Select Warehouse</option>
                        @foreach($warehouses ?? [] as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                        @endforeach
                    </x-input>
                </div>
                
                <!-- Modal Footer -->
                <div class="flex justify-end gap-3 mt-8">
                    <x-button type="button" onclick="closeCountModal()" variant="secondary">
                        Cancel
                    </x-button>
                    <x-button type="submit" variant="primary" icon="check">
                        Create Count
                    </x-button>
                </div>
            </form>
        </div>
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
        form.action = `/app/stock-count/${stockCountId}`;
        
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
