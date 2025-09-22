@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Print Labels</h1>
                    <p class="mt-2 text-sm text-gray-600">Generate and print barcode labels for your products</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Products
                    </a>
                </div>
            </div>
            <nav class="flex mt-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-violet-600 transition-colors duration-200">Products</a>
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
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Form Section -->
            <div class="bg-gray-50 px-6 py-6 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Warehouse Selection -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Warehouse <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select id="warehouse-select" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 bg-white shadow-sm transition-all duration-200">
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
                            <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Product Search
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" id="product-search" class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 bg-white shadow-sm transition-all duration-200" placeholder="Scan/Search Product by Code Or Name">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Results Section -->
            <div class="px-6 py-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Search Results
                    </h3>
                    <span class="text-sm text-gray-500" id="search-count">0 products found</span>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <input type="checkbox" id="select-all" class="rounded border-gray-300 text-violet-600 focus:ring-violet-500">
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Code</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stock</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Quantity</th>
                                </tr>
                            </thead>
                            <tbody id="product-table-body" class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                        <p class="text-sm">Search for products to add to labels</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                            </div>
                        </div>
                    </div>

            <!-- Selected Products Section -->
            <div class="px-6 py-6 border-t border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Selected Products for Printing
                    </h3>
                    <span class="text-sm text-gray-500" id="selected-count">0 products selected</span>
                        </div>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div id="selected-products-list" class="space-y-3">
                        <div class="text-center text-gray-500 py-8">
                            <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm">No products selected yet</p>
                        </div>
                        </div>
                    </div>
                </div>

            <!-- Settings and Actions Section -->
            <div class="bg-gray-50 px-6 py-6 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Paper Size Selection -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Paper Size
                        </label>
                        <select id="paper-size" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 bg-white shadow-sm transition-all duration-200">
                            <option value="">Select Paper Size</option>
                            <option value="A4">A4 (210 × 297 mm)</option>
                            <option value="A5">A5 (148 × 210 mm)</option>
                            <option value="Letter">Letter (8.5 × 11 in)</option>
                            <option value="Custom">Custom Size</option>
                        </select>
            </div>

                    <!-- Action Buttons -->
                    <div class="flex items-end">
                        <div class="flex space-x-3 w-full">
                            <button onclick="updateLabels()" class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-violet-600 text-white text-sm font-semibold rounded-lg hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update
                            </button>
                            <button onclick="printLabels()" class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                                Print Labels
                            </button>
                        </div>
                    </div>
                </div>
            </div>
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

    // Select all handler
    const selectAll = document.getElementById('select-all');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(cb => {
                cb.checked = selectAll.checked;
                const id = parseInt(cb.value);
                // Ensure corresponding quantity element exists before toggling
                if (selectAll.checked) {
                    // When bulk selecting, default quantity to 1
                    let qty = document.querySelector(`input[data-product-id="${id}"]`);
                    if (!qty) return;
                }
                toggleProduct(id);
            });
        });
    }
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
    const countElement = document.getElementById('search-count');
    
    if (!tableBody) return;
    
    // Store products globally for toggleProduct function
    allProducts = products;
    
    // Update search count
    if (countElement) {
        countElement.textContent = products.length + ' product' + (products.length !== 1 ? 's' : '') + ' found';
    }
    
    if (products.length === 0) {
        tableBody.innerHTML = '<tr>' +
            '<td colspan="5" class="px-6 py-8 text-center text-gray-500">' +
                '<svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>' +
                '</svg>' +
                '<p class="text-sm">No products found</p>' +
            '</td>' +
        '</tr>';
        return;
    }
    
    let html = '';
    products.forEach(product => {
        html += '<tr class="hover:bg-gray-50 transition-colors duration-150">' +
            '<td class="px-6 py-4 whitespace-nowrap">' +
                '<input type="checkbox" class="product-checkbox rounded border-gray-300 text-violet-600 focus:ring-violet-500" value="' + product.id + '" onchange="toggleProduct(' + product.id + ')">' +
            '</td>' +
            '<td class="px-6 py-4 whitespace-nowrap">' +
                '<div>' +
                    '<div class="text-sm font-semibold text-gray-900">' + product.name + '</div>' +
                    '<div class="text-sm text-gray-500">' + (product.category_name || 'General') + ' - ' + (product.brand_name || 'No Brand') + '</div>' +
                '</div>' +
            '</td>' +
            '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-mono">' + product.code + '</td>' +
            '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' + product.stock + ' ' + (product.unit_name || 'pcs') + '</td>' +
            '<td class="px-6 py-4 whitespace-nowrap">' +
                '<input type="number" class="quantity-input w-20 px-2 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-violet-500" value="1" min="1" data-product-id="' + product.id + '">' +
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
    const countElement = document.getElementById('selected-count');
    
    if (!listContainer) return;
    
    // Update count
    if (countElement) {
        countElement.textContent = selectedProducts.length + ' product' + (selectedProducts.length !== 1 ? 's' : '') + ' selected';
    }
    
    if (selectedProducts.length === 0) {
        listContainer.innerHTML = '<div class="text-center text-gray-500 py-8">' +
            '<svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>' +
            '</svg>' +
            '<p class="text-sm">No products selected yet</p>' +
        '</div>';
        return;
    }
    
    let html = '';
    selectedProducts.forEach(product => {
        html += '<div class="flex items-center justify-between bg-white p-4 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200">' +
            '<div class="flex-1">' +
                '<div class="text-sm font-semibold text-gray-900">' + product.name + '</div>' +
                '<div class="text-xs text-gray-500 mt-1">' + product.code + ' • ' + (product.category_name || 'General') + ' • Stock: ' + product.stock + ' ' + (product.unit_name || 'pcs') + '</div>' +
            '</div>' +
            '<div class="flex items-center space-x-3">' +
                '<div class="flex items-center space-x-2">' +
                    '<label class="text-xs text-gray-600">Qty:</label>' +
                    '<input type="number" class="selected-quantity-input w-16 px-2 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-violet-500" value="' + product.quantity + '" min="1" data-product-id="' + product.id + '" onchange="updateSelectedProductQuantity(' + product.id + ', this.value)">' +
                '</div>' +
                '<button onclick="removeSelectedProduct(' + product.id + ')" class="text-red-600 hover:text-red-800 text-sm font-medium px-3 py-1 rounded hover:bg-red-50 transition-colors duration-200">' +
                    '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>' +
                    '</svg>' +
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
    // Build printable HTML with JsBarcode
    const w = window.open('', '_blank');
    const styles = `
        <style>
            body { margin: 16px; font-family: Arial, sans-serif; }
            .grid { display: flex; flex-wrap: wrap; gap: 8px; }
            .label { border: 1px solid #ddd; padding: 6px 8px; width: 250px; box-sizing: border-box; page-break-inside: avoid; }
            .name { font-weight: 600; font-size: 12px; margin-bottom: 4px; }
            .meta { font-size: 11px; color: #444; margin-top: 4px; display: flex; justify-content: space-between; }
            @media print { .label { border: none; } }
        </style>
    `;

    let content = `<!DOCTYPE html><html><head><meta charset="utf-8"><title>Labels</title>${styles}
        <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"><\/script>
    </head><body><div class="grid">`;

    products.forEach(p => {
        const qty = Math.max(1, parseInt(p.quantity || 1));
        for (let i = 0; i < qty; i++) {
            content += `
                <div class="label">
                    <div class="name">${escapeHtml(p.name || '')}</div>
                    <svg class="bc" jsbarcode-value="${(p.code || '').toString()}" jsbarcode-format="CODE128" jsbarcode-width="2" jsbarcode-height="50" jsbarcode-displayValue="true"></svg>
                    <div class="meta"><span>${p.code || ''}</span><span>${(p.unit_name || 'pcs')}</span></div>
                </div>
            `;
        }
    });

    content += `</div>
        <script>
        function init(){ try{ JsBarcode('.bc').init(); }catch(e){} window.print(); window.onafterprint = () => window.close(); }
        if (document.readyState === 'complete') { init(); } else { window.addEventListener('load', init); }
        <\/script>
    </body></html>`;

    w.document.open();
    w.document.write(content);
    w.document.close();
}

function escapeHtml(str){
    return (str||'').replace(/[&<>"']/g, s => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;'}[s]));
}
</script>
@endsection













