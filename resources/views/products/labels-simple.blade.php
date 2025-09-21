@extends('layouts.app')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Print Labels</h1>
        <nav class="flex mt-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-violet-600">Products</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-gray-500 md:ml-2">Print Labels</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <!-- Warehouse Selection -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Warehouse <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <select id="warehouse-select" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500">
                    <option value="">Select Warehouse</option>
                    @foreach($warehouses ?? [] as $warehouse)
                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                            </div>
                            </div>
                        </div>

        <!-- Product Search -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Product</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                        </div>
                <input type="text" id="product-search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500" placeholder="Scan/Search Product by Code Or Name">
                        </div>
                    </div>

        <!-- Product Search Results -->
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-3">Search Results</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Select</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        </tr>
                    </thead>
                    <tbody id="product-table-body" class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Search for products to add to labels</td>
                        </tr>
                    </tbody>
                </table>
                        </div>
                        </div>

        <!-- Selected Products for Printing -->
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-3">Selected Products for Printing</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <div id="selected-products-list" class="space-y-2">
                    <div class="text-center text-gray-500 py-4">No products selected yet</div>
                        </div>
                    </div>
                </div>

        <!-- Paper Size Selection -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Paper size</label>
            <select id="paper-size" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500">
                <option value="">Paper size</option>
                <option value="A4">A4</option>
                <option value="A5">A5</option>
                <option value="Letter">Letter</option>
                <option value="Custom">Custom</option>
            </select>
            </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-3">
            <button onclick="updateLabels()" class="inline-flex items-center px-4 py-2 bg-violet-600 text-white text-sm font-medium rounded-md hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Update
            </button>
            <button onclick="printLabels()" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print
            </button>
            </div>
    </div>
</div>

<script>
// Global variables
let selectedProducts = [];
let allProducts = @json($products ?? []);

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Load warehouses if not already loaded
    loadWarehouses();
    
    // Setup search functionality
    setupProductSearch();
    
    // Don't load all products initially - table starts empty
    // displayAllProducts();
});

function loadWarehouses() {
    // Warehouses are already loaded from controller
    console.log('Warehouses loaded from database');
}

function displayAllProducts() {
    if (allProducts.length === 0) {
        clearProductTable();
        return;
    }
    
    displaySearchResults(allProducts);
}

function setupProductSearch() {
    const searchInput = document.getElementById('product-search');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            if (searchTerm.length > 2) {
                searchProducts(searchTerm);
            } else {
                clearProductTable();
            }
        });
        
        // Also handle Enter key for immediate search
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const searchTerm = e.target.value.toLowerCase();
                if (searchTerm.length > 0) {
                    searchProducts(searchTerm);
                }
            }
        });
    }
}


function searchProducts(searchTerm) {
    console.log('=== SEARCH DEBUG START ===');
    console.log('Searching for:', searchTerm);
    console.log('Search URL:', `/app/products/labels/search?q=${encodeURIComponent(searchTerm)}`);
    console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'));
    console.log('Current URL:', window.location.href);
    console.log('=== SEARCH DEBUG END ===');
    
    if (searchTerm.length === 0) {
        clearProductTable();
        return;
    }
    
    // Show loading state
    const tableBody = document.getElementById('product-table-body');
    if (tableBody) {
        tableBody.innerHTML = '<tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">Searching...</td></tr>';
    }
    
    // Search from backend
    fetch(`/app/products/labels/search?q=${encodeURIComponent(searchTerm)}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response ok:', response.ok);
        
        if (!response.ok) {
            if (response.status === 401) {
                // Redirect to login if unauthorized
                window.location.href = '/login';
                return;
            } else if (response.status === 404) {
                throw new Error('Search endpoint not found');
            } else {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
        }
        return response.json();
    })
    .then(products => {
        console.log('Search results:', products);
        if (Array.isArray(products)) {
            displaySearchResults(products);
        } else if (products && typeof products === 'object' && products.error) {
            console.error('Search error:', products.error);
            const tableBody = document.getElementById('product-table-body');
            if (tableBody) {
                tableBody.innerHTML = '<tr><td colspan="4" class="px-6 py-4 text-center text-red-500">Error: ' + products.error + '</td></tr>';
            }
        } else {
            console.error('Invalid response format:', products);
            displaySearchResults([]);
        }
    })
    .catch(error => {
        console.error('Search error:', error);
        clearProductTable();
        // Show error message to user
        const tableBody = document.getElementById('product-table-body');
        if (tableBody) {
            tableBody.innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-red-500">Error: ${error.message}</td></tr>`;
        }
    });
}

function displaySearchResults(products) {
    const tableBody = document.getElementById('product-table-body');
    if (!tableBody) return;
    
    // Store products globally for toggleProduct function
    allProducts = products;
    
    if (products.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">No products found</td></tr>';
        return;
    }
    
    let html = '';
    products.forEach(product => {
        html += '<tr class="hover:bg-gray-50">' +
            '<td class="px-6 py-4 whitespace-nowrap">' +
                '<input type="checkbox" class="product-checkbox" value="' + product.id + '" onchange="toggleProduct(' + product.id + ')">' +
            '</td>' +
            '<td class="px-6 py-4 whitespace-nowrap">' +
                '<div>' +
                    '<div class="text-sm font-medium text-gray-900">' + product.name + '</div>' +
                    '<div class="text-sm text-gray-500">' + (product.category_name || 'General') + ' - ' + (product.brand_name || 'No Brand') + '</div>' +
                '</div>' +
            '</td>' +
            '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' + product.code + '</td>' +
            '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' + product.stock + ' ' + (product.unit_name || 'pcs') + '</td>' +
            '<td class="px-6 py-4 whitespace-nowrap">' +
                '<input type="number" class="quantity-input w-20 px-2 py-1 border border-gray-300 rounded text-sm" value="1" min="1" data-product-id="' + product.id + '">' +
            '</td>' +
        '</tr>';
    });
    
    tableBody.innerHTML = html;
}

function clearProductTable() {
    const tableBody = document.getElementById('product-table-body');
    if (tableBody) {
        tableBody.innerHTML = '<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Search for products to add to labels</td></tr>';
    }
}

function toggleProduct(productId) {
    console.log('toggleProduct called with productId:', productId);
    console.log('allProducts:', allProducts);
    
    const checkbox = document.querySelector(`input[value="${productId}"]`);
    const quantityInput = document.querySelector(`input[data-product-id="${productId}"]`);
    
    console.log('checkbox:', checkbox);
    console.log('checkbox checked:', checkbox ? checkbox.checked : 'not found');
    console.log('quantityInput:', quantityInput);
    
    if (checkbox && checkbox.checked) {
        // Find product from allProducts array
        const productData = allProducts.find(p => p.id == productId);
        console.log('productData found:', productData);
        
        if (productData) {
            const product = {
                id: productData.id,
                name: productData.name,
                code: productData.code,
                sku: productData.sku,
                price: productData.price,
                stock: productData.stock,
                category_name: productData.category_name,
                brand_name: productData.brand_name,
                unit_name: productData.unit_name,
                quantity: quantityInput ? parseInt(quantityInput.value) : 1
            };
            
            console.log('product object created:', product);
            
            const existingIndex = selectedProducts.findIndex(p => p.id === productId);
            if (existingIndex === -1) {
                selectedProducts.push(product);
                console.log('Product added to selectedProducts');
            } else {
                console.log('Product already exists in selectedProducts');
            }
        } else {
            console.log('Product data not found in allProducts');
        }
    } else {
        // Remove from selected products
        selectedProducts = selectedProducts.filter(p => p.id !== productId);
        console.log('Product removed from selectedProducts');
    }
    
    // Update selected products table
    updateSelectedProductsTable();
    
    console.log('Selected products:', selectedProducts);
}

function updateSelectedProductsTable() {
    const listContainer = document.getElementById('selected-products-list');
    if (!listContainer) return;
    
    if (selectedProducts.length === 0) {
        listContainer.innerHTML = '<div class="text-center text-gray-500 py-4">No products selected yet</div>';
        return;
    }
    
    let html = '';
    selectedProducts.forEach(product => {
        html += '<div class="flex items-center justify-between bg-white p-3 rounded-lg border border-gray-200">' +
            '<div class="flex-1">' +
                '<div class="text-sm font-medium text-gray-900">' + product.name + '</div>' +
                '<div class="text-xs text-gray-500">' + product.code + ' • ' + (product.category_name || 'General') + ' • Stock: ' + product.stock + ' ' + (product.unit_name || 'pcs') + '</div>' +
            '</div>' +
            '<div class="flex items-center space-x-2">' +
                '<input type="number" class="selected-quantity-input w-16 px-2 py-1 border border-gray-300 rounded text-sm" value="' + product.quantity + '" min="1" data-product-id="' + product.id + '" onchange="updateSelectedProductQuantity(' + product.id + ', this.value)">' +
                '<button onclick="removeSelectedProduct(' + product.id + ')" class="text-red-600 hover:text-red-800 text-sm font-medium px-2 py-1">' +
                    'Remove' +
                '</button>' +
            '</div>' +
        '</div>';
    });
    
    listContainer.innerHTML = html;
}

function updateSelectedProductQuantity(productId, quantity) {
    const product = selectedProducts.find(p => p.id == productId);
    if (product) {
        product.quantity = parseInt(quantity) || 1;
    }
}

function removeSelectedProduct(productId) {
    // Remove from selected products
    selectedProducts = selectedProducts.filter(p => p.id !== productId);
    
    // Uncheck checkbox in search results
    const checkbox = document.querySelector(`input[value="${productId}"]`);
    if (checkbox) {
        checkbox.checked = false;
    }
    
    // Update selected products table
    updateSelectedProductsTable();
    
    console.log('Removed product:', productId);
}

function updateLabels() {
    if (selectedProducts.length === 0) {
        alert('Please select at least one product to update labels.');
        return;
    }
    
    // Update quantities from inputs
    selectedProducts.forEach(product => {
        const quantityInput = document.querySelector(`input[data-product-id="${product.id}"]`);
        if (quantityInput) {
            product.quantity = parseInt(quantityInput.value) || 1;
        }
    });
    
    console.log('Updated labels:', selectedProducts);
    alert(`Updated ${selectedProducts.length} products.`);
}

function resetLabels() {
    // Clear all selections
    selectedProducts = [];
    
    // Uncheck all checkboxes
    document.querySelectorAll('.product-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    
    // Reset search
    const searchInput = document.getElementById('product-search');
    if (searchInput) {
        searchInput.value = '';
    }
    
    // Clear tables
    clearProductTable();
    updateSelectedProductsTable();
    
    console.log('Labels reset');
    alert('Labels have been reset.');
}


function printLabels() {
    if (selectedProducts.length === 0) {
        alert('Please select at least one product to print labels.');
        return;
    }

    const paperSize = document.getElementById('paper-size').value;
    if (!paperSize) {
        alert('Please select a paper size.');
        return;
    }
    
    console.log('Printing labels:', selectedProducts);
    console.log('Paper size:', paperSize);
    
    // Generate barcode labels and open print window
    generateBarcodeLabels(selectedProducts, paperSize);
}

function generateBarcodeLabels(products, paperSize) {
    // Simple print - just print the current page
    window.print();
}
</script>
@endsection












