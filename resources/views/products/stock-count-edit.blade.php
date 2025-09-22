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
            <div class="text-2xl font-semibold">Edit Stock Count</div>
            <div class="text-sm text-slate-500">Products | Stock Count | #{{ $stockCount->id }} | Edit</div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('stock-count.index') }}" class="flex items-center px-4 py-2 border border-gray-300 text-gray-700 bg-white rounded-md hover:bg-gray-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Stock Counts
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <form method="POST" action="{{ route('stock-count.update', $stockCount->id) }}" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Stock Count Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Date Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Date <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="date" name="date" id="editDate" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 text-sm" value="{{ old('date', $stockCount->date) }}" required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Warehouse Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Warehouse <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="warehouse_id" id="editWarehouse" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 text-sm appearance-none bg-white" required>
                            <option value="">Select Warehouse</option>
                            @foreach($warehouses ?? [] as $warehouse)
                                <option value="{{ $warehouse->id }}" @selected(old('warehouse_id', $stockCount->warehouse_id) == $warehouse->id)>{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    @error('warehouse_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Status Section -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 {{ old('status', $stockCount->status) == 'pending' ? 'border-violet-500 bg-violet-50' : '' }}">
                    <input type="radio" name="status" value="pending" class="sr-only" {{ old('status', $stockCount->status) == 'pending' ? 'checked' : '' }}>
                    <div class="flex items-center">
                        <div class="w-4 h-4 border-2 border-gray-300 rounded-full mr-3 {{ old('status', $stockCount->status) == 'pending' ? 'border-violet-500 bg-violet-500' : '' }}"></div>
                        <div>
                            <div class="font-medium text-gray-900">Pending</div>
                            <div class="text-sm text-gray-500">Stock count is waiting to be processed</div>
                        </div>
                    </div>
                </label>
                
                <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 {{ old('status', $stockCount->status) == 'in_progress' ? 'border-violet-500 bg-violet-50' : '' }}">
                    <input type="radio" name="status" value="in_progress" class="sr-only" {{ old('status', $stockCount->status) == 'in_progress' ? 'checked' : '' }}>
                    <div class="flex items-center">
                        <div class="w-4 h-4 border-2 border-gray-300 rounded-full mr-3 {{ old('status', $stockCount->status) == 'in_progress' ? 'border-violet-500 bg-violet-500' : '' }}"></div>
                        <div>
                            <div class="font-medium text-gray-900">In Progress</div>
                            <div class="text-sm text-gray-500">Stock count is currently being processed</div>
                        </div>
                    </div>
                </label>
                
                <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 {{ old('status', $stockCount->status) == 'completed' ? 'border-violet-500 bg-violet-50' : '' }}">
                    <input type="radio" name="status" value="completed" class="sr-only" {{ old('status', $stockCount->status) == 'completed' ? 'checked' : '' }}>
                    <div class="flex items-center">
                        <div class="w-4 h-4 border-2 border-gray-300 rounded-full mr-3 {{ old('status', $stockCount->status) == 'completed' ? 'border-violet-500 bg-violet-500' : '' }}"></div>
                        <div>
                            <div class="font-medium text-gray-900">Completed</div>
                            <div class="text-sm text-gray-500">Stock count has been completed</div>
                        </div>
                    </div>
                </label>
            </div>
            @error('status')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
            <a href="{{ route('stock-count.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center px-6 py-3 bg-violet-600 text-white text-sm font-medium rounded-md hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Update Stock Count
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Handle radio button selection
document.querySelectorAll('input[name="status"]').forEach(radio => {
    radio.addEventListener('change', function() {
        // Remove all active states
        document.querySelectorAll('label').forEach(label => {
            label.classList.remove('border-violet-500', 'bg-violet-50');
            const circle = label.querySelector('.w-4.h-4');
            if (circle) {
                circle.classList.remove('border-violet-500', 'bg-violet-500');
            }
        });
        
        // Add active state to selected option
        if (this.checked) {
            const label = this.closest('label');
            label.classList.add('border-violet-500', 'bg-violet-50');
            const circle = label.querySelector('.w-4.h-4');
            if (circle) {
                circle.classList.add('border-violet-500', 'bg-violet-500');
            }
        }
    });
});
</script>
@endpush
@endsection









