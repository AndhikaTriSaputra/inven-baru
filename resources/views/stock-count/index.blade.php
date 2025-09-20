@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Count Stock</h2>
        <div class="flex items-center gap-3">
            <button onclick="saveStockCount()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>Save Count
            </button>
            <button onclick="exportCount()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>Export Count
            </button>
            <button onclick="resetCount()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Reset Count
            </button>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Stock Count</h3>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <label class="text-sm text-gray-600">Filter:</label>
                        <select id="filterOptions" class="px-3 py-1 border border-gray-300 rounded text-sm">
                            <option value="all">All Products</option>
                            <option value="low-stock">Low Stock Only</option>
                            <option value="out-of-stock">Out of Stock Only</option>
                            <option value="counted">Counted Only</option>
                            <option value="not-counted">Not Counted</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="text-sm text-gray-600">Search:</label>
                        <input type="text" id="searchInput" placeholder="Search products..." class="px-3 py-1 border border-gray-300 rounded text-sm w-48">
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Product</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Code</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Category</th>
                            <th class="px-4 py-3 text-center font-semibold text-gray-700">System Stock</th>
                            <th class="px-4 py-3 text-center font-semibold text-gray-700">Counted Stock</th>
                            <th class="px-4 py-3 text-center font-semibold text-gray-700">Difference</th>
                            <th class="px-4 py-3 text-center font-semibold text-gray-700">Status</th>
                            <th class="px-4 py-3 text-center font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="stockCountTable">
                        @forelse($products as $product)
                        <tr class="border-b border-gray-100 product-row" data-product-id="{{ $product->id }}" data-product-name="{{ strtolower($product->name) }}" data-category="{{ strtolower($product->category_name ?? '') }}">
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4v10l8 4 8-4V7z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800">{{ $product->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $product->brand_name ?? 'No Brand' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 font-mono text-sm">{{ $product->code }}</td>
                            <td class="px-4 py-3 text-sm">{{ $product->category_name ?? 'No Category' }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                    0 {{ $product->unit_name ?? 'pcs' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <input type="number" 
                                       class="counted-stock w-20 px-2 py-1 border border-gray-300 rounded text-center text-sm" 
                                       value="0" 
                                       min="0" 
                                       data-product-id="{{ $product->id }}"
                                       data-original-stock="0">
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="difference-indicator px-2 py-1 rounded-full text-sm font-medium">0</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="status-indicator px-2 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600">Not Counted</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button onclick="quickCount({{ $product->id }}, 0)" class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs hover:bg-green-200 transition-colors">
                                    Quick Count
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4v10l8 4 8-4V7z"></path></svg>
                                <p>No products found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Summary Card -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4v10l8 4 8-4V7z"></path></svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800" id="totalProducts">{{ $products->count() }}</div>
                    <div class="text-sm text-gray-500">Total Products</div>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800" id="countedProducts">0</div>
                    <div class="text-sm text-gray-500">Counted</div>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800" id="discrepancies">0</div>
                    <div class="text-sm text-gray-500">Discrepancies</div>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800" id="remainingProducts">{{ $products->count() }}</div>
                    <div class="text-sm text-gray-500">Remaining</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let stockCountData = {};

// Initialize stock count data
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.counted-stock').forEach(input => {
        const productId = input.dataset.productId;
        const originalStock = parseInt(input.dataset.originalStock);
        stockCountData[productId] = {
            original: originalStock,
            counted: originalStock,
            changed: false
        };
    });
    updateSummary();
});

// Update difference and status when counted stock changes
document.addEventListener('input', function(e) {
    if (e.target.classList.contains('counted-stock')) {
        const productId = e.target.dataset.productId;
        const originalStock = parseInt(e.target.dataset.originalStock);
        const countedStock = parseInt(e.target.value) || 0;
        
        stockCountData[productId] = {
            original: originalStock,
            counted: countedStock,
            changed: countedStock !== originalStock
        };
        
        updateRowStatus(productId, originalStock, countedStock);
        updateSummary();
    }
});

function updateRowStatus(productId, originalStock, countedStock) {
    const row = document.querySelector(`[data-product-id="${productId}"]`);
    const differenceSpan = row.querySelector('.difference-indicator');
    const statusSpan = row.querySelector('.status-indicator');
    
    const difference = countedStock - originalStock;
    
    // Update difference indicator
    differenceSpan.textContent = difference >= 0 ? `+${difference}` : `${difference}`;
    differenceSpan.className = 'difference-indicator px-2 py-1 rounded-full text-sm font-medium';
    
    if (difference > 0) {
        differenceSpan.classList.add('bg-green-100', 'text-green-800');
    } else if (difference < 0) {
        differenceSpan.classList.add('bg-red-100', 'text-red-800');
    } else {
        differenceSpan.classList.add('bg-gray-100', 'text-gray-600');
    }
    
    // Update status indicator
    statusSpan.className = 'status-indicator px-2 py-1 rounded-full text-sm font-medium';
    if (countedStock !== originalStock) {
        statusSpan.classList.add('bg-yellow-100', 'text-yellow-800');
        statusSpan.textContent = 'Discrepancy';
    } else {
        statusSpan.classList.add('bg-green-100', 'text-green-800');
        statusSpan.textContent = 'Counted';
    }
}

function updateSummary() {
    const totalProducts = Object.keys(stockCountData).length;
    let countedProducts = 0;
    let discrepancies = 0;
    
    Object.values(stockCountData).forEach(data => {
        if (data.counted !== data.original) {
            discrepancies++;
        }
        countedProducts++;
    });
    
    document.getElementById('totalProducts').textContent = totalProducts;
    document.getElementById('countedProducts').textContent = countedProducts;
    document.getElementById('discrepancies').textContent = discrepancies;
    document.getElementById('remainingProducts').textContent = totalProducts - countedProducts;
}

function quickCount(productId, originalStock) {
    const input = document.querySelector(`[data-product-id="${productId}"] .counted-stock`);
    const newValue = prompt(`Enter counted stock for this product (Original: ${originalStock}):`, originalStock);
    
    if (newValue !== null && !isNaN(newValue)) {
        input.value = newValue;
        input.dispatchEvent(new Event('input'));
    }
}

function saveStockCount() {
    const discrepancies = Object.values(stockCountData).filter(data => data.counted !== data.original);
    
    if (discrepancies.length === 0) {
        alert('No discrepancies found. Stock count is accurate.');
        return;
    }
    
    if (confirm(`Found ${discrepancies.length} discrepancies. Do you want to update the stock levels?`)) {
        // Here you would typically send the data to the server
        console.log('Stock count data:', stockCountData);
        alert('Stock count saved successfully!');
    }
}

function exportCount() {
    const data = Object.entries(stockCountData).map(([productId, data]) => {
        const row = document.querySelector(`[data-product-id="${productId}"]`);
        const productName = row.querySelector('td:first-child .font-medium').textContent;
        const code = row.querySelector('td:nth-child(2)').textContent;
        
        return {
            'Product Name': productName,
            'Code': code,
            'System Stock': data.original,
            'Counted Stock': data.counted,
            'Difference': data.counted - data.original,
            'Status': data.counted !== data.original ? 'Discrepancy' : 'Accurate'
        };
    });
    
    const csv = convertToCSV(data);
    downloadCSV(csv, 'stock-count-report.csv');
}

function convertToCSV(data) {
    const headers = Object.keys(data[0]);
    const csvContent = [
        headers.join(','),
        ...data.map(row => headers.map(header => `"${row[header]}"`).join(','))
    ].join('\n');
    
    return csvContent;
}

function downloadCSV(csv, filename) {
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
    window.URL.revokeObjectURL(url);
}

function resetCount() {
    if (confirm('Are you sure you want to reset all stock counts?')) {
        document.querySelectorAll('.counted-stock').forEach(input => {
            const originalStock = parseInt(input.dataset.originalStock);
            input.value = originalStock;
            input.dispatchEvent(new Event('input'));
        });
    }
}

// Filter functionality
document.getElementById('filterOptions').addEventListener('change', function() {
    const filter = this.value;
    const rows = document.querySelectorAll('.product-row');
    
    rows.forEach(row => {
        const productId = row.dataset.productId;
        const data = stockCountData[productId];
        let show = true;
        
        switch(filter) {
            case 'low-stock':
                show = data.original <= 50;
                break;
            case 'out-of-stock':
                show = data.original <= 0;
                break;
            case 'counted':
                show = data.counted !== data.original;
                break;
            case 'not-counted':
                show = data.counted === data.original;
                break;
        }
        
        row.style.display = show ? 'table-row' : 'none';
    });
});

// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('.product-row');
    
    rows.forEach(row => {
        const productName = row.dataset.productName;
        const category = row.dataset.category;
        const show = productName.includes(searchTerm) || category.includes(searchTerm);
        row.style.display = show ? 'table-row' : 'none';
    });
});
</script>
@endsection



