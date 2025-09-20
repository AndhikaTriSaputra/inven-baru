@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Print Labels</h2>
        <div class="flex items-center gap-3">
            <button onclick="printLabels()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>Print Selected Labels
            </button>
            <button onclick="selectAll()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Select All
            </button>
            <button onclick="clearSelection()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Clear Selection
            </button>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Product Labels</h3>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <label class="text-sm text-gray-600">Label Size:</label>
                        <select id="labelSize" class="px-3 py-1 border border-gray-300 rounded text-sm">
                            <option value="small">Small (2x1 inch)</option>
                            <option value="medium" selected>Medium (3x2 inch)</option>
                            <option value="large">Large (4x3 inch)</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="text-sm text-gray-600">Show:</label>
                        <select id="showOptions" class="px-3 py-1 border border-gray-300 rounded text-sm">
                            <option value="all">All Products</option>
                            <option value="low-stock">Low Stock Only</option>
                            <option value="out-of-stock">Out of Stock Only</option>
                        </select>
                    </div>
    </div>
    </div>
    </div>

        <div class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="labelsGrid">
                @forelse($products as $product)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center">
                            <input type="checkbox" class="product-checkbox mr-3" value="{{ $product->id }}" data-product='{{ json_encode($product) }}'>
    <div>
                                <h4 class="font-semibold text-gray-800 text-sm">{{ $product->name }}</h4>
                                <p class="text-xs text-gray-500">{{ $product->category_name ?? 'No Category' }}</p>
                            </div>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600">
                            {{ $product->stock ?? 0 }} {{ $product->unit_name ?? 'pcs' }}
                        </span>
    </div>

                    <div class="space-y-2">
                        <div class="text-xs">
                            <span class="text-gray-500">SKU:</span>
                            <span class="font-mono">{{ $product->code }}</span>
                        </div>
                        <div class="text-xs">
                            <span class="text-gray-500">Price:</span>
                            <span class="font-semibold">Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}</span>
                        </div>
                        @if($product->brand_name)
                        <div class="text-xs">
                            <span class="text-gray-500">Brand:</span>
                            <span>{{ $product->brand_name }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-8 text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    <p>No products found</p>
                </div>
                @endforelse
            </div>
            </div>
        </div>
    </div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    .print-labels, .print-labels * {
        visibility: visible;
    }
    .print-labels {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
}

.label-small {
    width: 2in;
    height: 1in;
    font-size: 8px;
}

.label-medium {
    width: 3in;
    height: 2in;
    font-size: 10px;
}

.label-large {
    width: 4in;
    height: 3in;
    font-size: 12px;
}
</style>

<script>
function selectAll() {
    document.querySelectorAll('.product-checkbox').forEach(checkbox => {
        checkbox.checked = true;
    });
}

function clearSelection() {
    document.querySelectorAll('.product-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
}

function printLabels() {
    const selectedProducts = [];
    document.querySelectorAll('.product-checkbox:checked').forEach(checkbox => {
        try {
            const productData = JSON.parse(checkbox.dataset.product);
            selectedProducts.push(productData);
        } catch (e) {
            console.error('Error parsing product data:', e);
        }
    });

    if (selectedProducts.length === 0) {
        alert('Please select at least one product to print labels.');
        return;
    }

    const labelSize = document.getElementById('labelSize').value;
    const showOptions = document.getElementById('showOptions').value;

    // Filter products based on show options
    let filteredProducts = selectedProducts;
    if (showOptions === 'low-stock') {
        filteredProducts = selectedProducts.filter(p => p.stock <= 50);
    } else if (showOptions === 'out-of-stock') {
        filteredProducts = selectedProducts.filter(p => p.stock <= 0);
    }

    if (filteredProducts.length === 0) {
        alert('No products match the selected filter criteria.');
        return;
    }

    const printWindow = window.open('', '_blank');
    printWindow.document.write(generateLabelHTML(filteredProducts, labelSize));
    printWindow.document.close();
    printWindow.print();
}

function createPrintContent(products, size) {
    const sizeClass = `label-${size}`;
    
    let content = `
    <!DOCTYPE html>
    <html>
    <head>
        <title>Product Labels</title>
        <style>
            body { margin: 0; padding: 20px; font-family: Arial, sans-serif; }
            .labels-container { display: flex; flex-wrap: wrap; gap: 10px; }
            .label { 
                border: 1px solid #000; 
                padding: 8px; 
                display: flex; 
                flex-direction: column; 
                justify-content: space-between;
                page-break-inside: avoid;
            }
            .label-small { width: 2in; height: 1in; font-size: 8px; }
            .label-medium { width: 3in; height: 2in; font-size: 10px; }
            .label-large { width: 4in; height: 3in; font-size: 12px; }
            .label-header { font-weight: bold; margin-bottom: 4px; }
            .label-details { font-size: 0.9em; }
            .label-price { font-weight: bold; color: #2563eb; }
            .label-stock { font-size: 0.8em; color: #666; }
            @media print {
                body { margin: 0; padding: 10px; }
                .labels-container { gap: 5px; }
            }
        </style>
    </head>
    <body>
        <div class="labels-container">
    `;

    products.forEach(product => {
        content += `
            <div class="label ${sizeClass}">
                <div class="label-header">${product.name}</div>
                <div class="label-details">
                    <div>SKU: ${product.sku}</div>
                    <div class="label-price">Rp ${new Intl.NumberFormat('id-ID').format(product.price)}</div>
                    <div class="label-stock">Stock: ${product.stock} ${product.unit_name || 'pcs'}</div>
        </div>
    </div>
        `;
    });

    content += `
    </div>
    </body>
    </html>
    `;

    return content;
}

// Filter functionality
document.getElementById('showOptions').addEventListener('change', function() {
    const filter = this.value;
    const products = document.querySelectorAll('.product-checkbox');
    
    products.forEach(checkbox => {
        const product = JSON.parse(checkbox.dataset.product);
        const productDiv = checkbox.closest('.border');
        
        if (filter === 'all') {
            productDiv.style.display = 'block';
        } else if (filter === 'low-stock') {
            productDiv.style.display = product.stock <= 50 ? 'block' : 'none';
        } else if (filter === 'out-of-stock') {
            productDiv.style.display = product.stock <= 0 ? 'block' : 'none';
        }
    });
});
</script>
@endsection