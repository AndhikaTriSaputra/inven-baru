@extends('layouts.app')

@section('header')
@endsection

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
            <div class="text-2xl font-semibold">All Products</div>
            <div class="text-sm text-slate-500">Products | All Products</div>
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
            
            <a href="{{ route('products.export.pdf') }}" download class="flex items-center px-4 py-2 border border-green-200 text-green-600 bg-white rounded-md hover:bg-green-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                PDF
            </a>
            
            
            <a href="{{ route('products.export.excel') }}" download class="flex items-center px-4 py-2 border border-orange-200 text-orange-600 bg-white rounded-md hover:bg-orange-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                EXCEL
            </a>
            
            <a href="{{ route('products.create') }}" class="flex items-center px-4 py-2 bg-violet-600 text-white rounded-md hover:bg-violet-700 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Create
            </a>
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
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Image</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Type</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Item</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Tag</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Project</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Code</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Brand</th>
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Unit</th>
                    @if(auth()->user()->role_id != 1)
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Status</th>
                    @endif
                    <th class="px-3 py-3 text-left text-gray-600 font-semibold">Action</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($allProducts as $p)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="px-3 py-3">
                        <input type="checkbox" class="rounded border-gray-300 text-violet-600 focus:ring-violet-500">
</td>
                    <td class="px-3 py-3">
                        @php
                            $firstImage = null;
                            if ($p->image) {
                                $images = explode(',', $p->image);
                                $firstImage = trim($images[0]);
                            }
                        @endphp
                        @if($firstImage && file_exists(public_path('images/products/' . $firstImage)))
                            <img src="{{ asset('images/products/' . $firstImage) }}" alt="{{ $p->name }}" class="w-10 h-10 rounded-xl object-cover border">
                        @else
                            <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-[10px] text-gray-400 border">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
</td>
                    <td class="px-3 py-3 text-gray-700">{{ ucfirst($p->type ?? 'Product') }}</td>
                    <td class="px-3 py-3 text-gray-700 font-medium">{{ $p->name ?? '-' }}</td>
                    <td class="px-3 py-3">
                        <span class="inline-block text-[11px] px-2 py-1 rounded-xl bg-violet-50 text-violet-700 border border-violet-200 whitespace-nowrap">Tag</span>
                            </td>
                    <td class="px-3 py-3 text-gray-700">{{ $p->project ?? '-' }}</td>
                    <td class="px-3 py-3 text-gray-700">{{ $p->code ?? '-' }}</td>
                    <td class="px-3 py-3 text-gray-700">{{ $p->brand ?? '-' }}</td>
                    <td class="px-3 py-3 text-gray-700">{{ $p->unit ?? 'Pcs' }}</td>
                    @if(auth()->user()->role_id != 1)
                    <td class="px-3 py-3">
                        @if($p->is_active == 1)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Approved
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                Pending
                            </span>
                        @endif
                    </td>
                    @endif
                    <td class="px-3 py-3">
                        <div class="flex items-center gap-2 justify-end">
                            <a href="{{ route('products.show', $p->id) }}" class="w-8 h-8 rounded-full border border-blue-300 text-blue-600 hover:bg-blue-50 grid place-items-center" title="View">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            <a href="{{ route('products.edit', $p->id) }}" class="w-8 h-8 rounded-full border border-emerald-300 text-emerald-600 hover:bg-emerald-50 grid place-items-center" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5Z"/></svg>
                            </a>
                            <button onclick="deleteProduct({{ $p->id }})" class="w-8 h-8 rounded-full border border-rose-300 text-rose-600 hover:bg-rose-50 grid place-items-center" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 6h18"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->role_id == 1 ? '10' : '11' }}" class="px-4 py-8 text-center text-gray-500">No products found</td>
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
                {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }}
            </span>
            <div class="flex items-center space-x-1">
                <button class="px-3 py-1 text-sm text-gray-500 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed" {{ $products->onFirstPage() ? 'disabled' : '' }}>
                    <span class="text-xs">prev</span>
                </button>
                <button class="px-3 py-1 text-sm text-gray-500 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed" {{ $products->hasMorePages() ? '' : 'disabled' }}>
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
    <form method="GET" action="{{ route('products.index') }}" class="p-4 space-y-4">
        <div>
            <label class="block text-sm text-slate-600 mb-1">Name</label>
            <input type="text" name="name" value="{{ request('name') }}" class="w-full border rounded px-3 py-2" placeholder="Product Name">
        </div>
        <div>
            <label class="block text-sm text-slate-600 mb-1">Code</label>
            <input type="text" name="code" value="{{ request('code') }}" class="w-full border rounded px-3 py-2" placeholder="Product Code">
        </div>
        <div>
            <label class="block text-sm text-slate-600 mb-1">Brand</label>
            <input type="text" name="brand" value="{{ request('brand') }}" class="w-full border rounded px-3 py-2" placeholder="Brand">
        </div>
        <div>
            <label class="block text-sm text-slate-600 mb-1">Category</label>
            <select name="category_id" class="w-full border rounded px-3 py-2">
                <option value="">Choose Category</option>
                @foreach($categories ?? [] as $cat)
                    <option value="{{ $cat->id }}" @selected(request('category_id')==$cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-slate-600 mb-1">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="">Choose Status</option>
                <option value="active" @selected(request('status')=='active')>Active</option>
                <option value="inactive" @selected(request('status')=='inactive')>Inactive</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <button type="submit" class="flex items-center px-4 py-2 bg-violet-600 text-white rounded">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filter
            </button>
            <a href="{{ route('products.index') }}" class="flex items-center px-4 py-2 bg-red-600 text-white rounded">
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
  // Delete product function
  function deleteProduct(productId) {
    if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
      // Show loading state
      const deleteBtn = event.target.closest('button');
      const originalContent = deleteBtn.innerHTML;
      deleteBtn.innerHTML = '<svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
      deleteBtn.disabled = true;
      
      // Create a form to submit DELETE request
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = `/app/products/${productId}`;
      
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

  (function(){
    const input = document.getElementById('tableSearch');
    const body = document.getElementById('tableBody');
    if(!input || !body) return;
    
    // Store all products data for search
    const allProducts = @json($allProducts ?? []);
    
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