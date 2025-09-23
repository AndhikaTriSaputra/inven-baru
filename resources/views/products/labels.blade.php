@extends('layouts.app')

@section('content')
<div class="container">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-heading-2">Print Labels</h1>
            <p class="text-body-sm mt-1">Select products to generate printable labels with barcodes</p>
        </div>
        <div class="flex items-center gap-3">
            <x-button id="printBtn" variant="primary" icon="print">
                Print Selected Labels
            </x-button>
            <x-button id="selectAllBtn" variant="secondary">
                Select All
            </x-button>
            <x-button id="clearSelBtn" variant="secondary">
                Clear Selection
            </x-button>
        </div>
    </div>

    <x-card>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h3 class="text-heading-4">Product Labels</h3>
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-3">
                        <label class="form-label">Label Size:</label>
                        <select id="labelSize" class="form-select" style="width: auto; min-width: 180px;">
                            <option value="small">Small (2x1 inch)</option>
                            <option value="medium" selected>Medium (3x2 inch)</option>
                            <option value="large">Large (4x3 inch)</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-3">
                        <label class="form-label">Show:</label>
                        <select id="showOptions" class="form-select" style="width: auto; min-width: 160px;">
                            <option value="all">All Products</option>
                            <option value="low-stock">Low Stock Only</option>
                            <option value="out-of-stock">Out of Stock Only</option>
                        </select>
                    </div>
                </div>
            </div>
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="labelsGrid">
            @forelse($products as $product)
            <div class="card hover:shadow-lg transition-all duration-200">
                <div class="card-body">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" class="product-checkbox mr-3 w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500" value="{{ $product->id }}"
                                   data-name="{{ $product->name }}"
                                   data-code="{{ $product->code }}"
                                   data-price="{{ $product->price ?? 0 }}"
                                   data-stock="{{ $product->stock ?? 0 }}"
                                   data-unit="{{ $product->unit_name ?? 'pcs' }}">
                            <div>
                                <h4 class="text-body font-medium">{{ $product->name }}</h4>
                                <p class="text-caption">{{ $product->category_name ?? 'No Category' }}</p>
                            </div>
                        </div>
                        <x-badge variant="gray" size="sm">
                            {{ $product->stock ?? 0 }} {{ $product->unit_name ?? 'pcs' }}
                        </x-badge>
                    </div>

                    <div class="space-y-2">
                        <div class="text-caption">
                            <span class="text-gray-500">SKU:</span>
                            <span class="text-mono font-medium">{{ $product->code }}</span>
                        </div>
                        <div class="text-caption">
                            <span class="text-gray-500">Price:</span>
                            <span class="font-semibold text-primary-600">Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}</span>
                        </div>
                        @if($product->brand_name)
                        <div class="text-caption">
                            <span class="text-gray-500">Brand:</span>
                            <span>{{ $product->brand_name }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <x-icon name="products" size="xl" class="mx-auto mb-4 text-gray-400" />
                <h3 class="text-heading-4 text-gray-500 mb-2">No products found</h3>
                <p class="text-body-sm text-gray-400">Add some products to start generating labels</p>
            </div>
            @endforelse
        </div>
    </x-card>
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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const printBtn = document.getElementById('printBtn');
    const selectAllBtn = document.getElementById('selectAllBtn');
    const clearSelBtn = document.getElementById('clearSelBtn');

    if (printBtn) printBtn.addEventListener('click', printLabels);
    if (selectAllBtn) selectAllBtn.addEventListener('click', selectAll);
    if (clearSelBtn) clearSelBtn.addEventListener('click', clearSelection);
});

function selectAll() {
    console.log('Select All clicked');
    document.querySelectorAll('.product-checkbox').forEach(checkbox => {
        checkbox.checked = true;
    });
    console.log('All checkboxes selected');
}

function clearSelection() {
    console.log('Clear Selection clicked');
    document.querySelectorAll('.product-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    console.log('All checkboxes cleared');
}

function printLabels() {
    console.log('Print Labels clicked');
    const selectedProducts = [];
    document.querySelectorAll('.product-checkbox:checked').forEach(checkbox => {
        const d = checkbox.dataset;
        selectedProducts.push({
            id: parseInt(checkbox.value),
            name: d.name || '',
            code: d.code || '',
            price: Number(d.price || 0),
            stock: Number(d.stock || 0),
            unit_name: d.unit || 'pcs'
        });
    });

    console.log('Selected products:', selectedProducts);

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

    console.log('Filtered products for printing:', filteredProducts);

    const printWindow = window.open('', '_blank');
    printWindow.document.open();
    printWindow.document.write(createPrintContent(filteredProducts, labelSize));
    printWindow.document.close();
}

function createPrintContent(products, size) {
    const sizeClass = 'label-' + size;
    
    let content = '<!DOCTYPE html><html><head><title>Product Labels</title>';
    content += '<style>body { margin: 0; padding: 20px; font-family: Arial, sans-serif; }';
    content += '.labels-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(3in, 1fr)); gap: 10px; }';
    content += '.label { border: 1px solid #000; padding: 8px; display: flex; flex-direction: column; justify-content: space-between; page-break-inside: avoid; text-align: center; }';
    content += '.label-small { width: 2in; height: 1in; font-size: 8px; }';
    content += '.label-medium { width: 3in; height: 2in; font-size: 10px; }';
    content += '.label-large { width: 4in; height: 3in; font-size: 12px; }';
    content += '.label-header { font-weight: bold; margin-bottom: 4px; word-wrap: break-word; }';
    content += '.label-details { font-size: 0.9em; }';
    content += '.label-price { font-weight: bold; color: #2563eb; margin-top: 4px; }';
    content += '.label-stock { font-size: 0.8em; color: #666; margin-top: 2px; }';
    content += '.barcode-container { margin: 4px 0; }';
    content += '.barcode { max-width: 100%; height: auto; }';
    content += '@media print { body { margin: 0; padding: 10px; } .labels-container { gap: 5px; } .label { border: 1px solid #000; } }';
    content += '</style>';
    content += '<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"><\/script>';
    content += '</head><body><div class="labels-container">';

    products.forEach(product => {
        content += '<div class="label ' + sizeClass + '">';
        content += '<div class="label-header">' + product.name + '</div>';
        content += '<div class="label-details">';
        content += '<div class="barcode-container">';
        content += '<svg class="barcode" jsbarcode-value="' + (product.code || '') + '" jsbarcode-format="CODE128" jsbarcode-width="2" jsbarcode-height="40" jsbarcode-displayValue="true"></svg>';
        content += '</div>';
        content += '<div><strong>SKU:</strong> ' + (product.code || '') + '</div>';
        content += '<div class="label-price">Rp ' + new Intl.NumberFormat('id-ID').format(product.price || 0) + '</div>';
        content += '<div class="label-stock">Stock: ' + (product.stock || 0) + ' ' + (product.unit_name || 'pcs') + '</div>';
        content += '</div></div>';
    });

    content += '</div>';
    content += '<script>document.addEventListener("DOMContentLoaded", function(){';
    content += 'console.log("Initializing barcodes...");';
    content += 'try { JsBarcode(".barcode").init(); console.log("Barcodes initialized successfully"); } catch(e) { console.error("Barcode initialization error:", e); }';
    content += 'setTimeout(function(){ console.log("Opening print dialog..."); window.print(); window.onafterprint = function() { console.log("Print completed, closing window..."); window.close(); }; }, 500);';
    content += '});<\/script></body></html>';

    return content;
}

// Filter functionality
document.addEventListener('DOMContentLoaded', function(){
    const showOptions = document.getElementById('showOptions');
    if (!showOptions) return;
    
    showOptions.addEventListener('change', function() {
        const filter = this.value;
        console.log('Filter changed to:', filter);
        const products = document.querySelectorAll('.product-checkbox');
        
        products.forEach(checkbox => {
            const d = checkbox.dataset;
            const product = { stock: Number(d.stock || 0) };
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
});
</script>
@endpush