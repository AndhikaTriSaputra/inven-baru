@extends('layouts.app')

@section('header')
@endsection

@section('content')
<div class="bg-white border border-gray-200 rounded-lg shadow-sm">
    <!-- Page Title and Breadcrumb -->
    <div class="p-6 border-b border-gray-200">
        <h1 class="text-2xl font-bold text-gray-900">Create Transfer</h1>
        <div class="text-sm text-gray-500 flex items-center gap-3 mt-1">
            <a class="font-medium text-gray-700 hover:text-violet-600" href="{{ route('transfers.index') }}">All Transfers</a>
            <span class="text-gray-300">|</span>
            <span>Create Transfer</span>
        </div>
    </div>

    <form method="POST" action="{{ route('transfers.store') }}">
        @csrf

        <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Date *</label>
                    <div class="relative">
                        <input type="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-violet-500 focus:border-transparent" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
            </div>
            <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">From Warehouse *</label>
                    <select name="from_warehouse_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-violet-500 focus:border-transparent" required>
                    <option value="">Choose Warehouse</option>
                    @foreach($warehouses as $wh)
                        <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">To Warehouse *</label>
                    <select name="to_warehouse_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-violet-500 focus:border-transparent" required>
                    <option value="">Choose Warehouse</option>
                    @foreach($warehouses as $wh)
                        <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Search product --}}
        <div class="mb-6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Product</label>
                <div class="relative" x-data="productSearch()">
                    <input x-model="query" @focus="open=true; if(results.length===0) preload();" @input="search" @keydown.enter.prevent="if(results.length){ add(results[0]) }" type="text" placeholder="Scan/Search Product by Code Or Name" class="w-full px-3 py-2 pl-10 border border-gray-300 rounded-md focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <div x-show="open" @click.outside="open=false" class="absolute z-50 left-0 right-0 bg-white border rounded-lg mt-1 shadow-lg max-h-64 overflow-y-auto overflow-x-hidden whitespace-nowrap">
                        <template x-for="item in results" :key="item.id">
                            <button type="button" class="w-full flex items-center gap-3 px-3 py-2 hover:bg-gray-50 text-left" @click="add(item)">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <span class="truncate" x-text="item.label"></span>
                            </button>
                        </template>
                        <div x-show="results.length===0" class="px-3 py-2 text-sm text-gray-500">No results</div>
                    </div>
                </div>
        </div>

        {{-- Product Table --}}
            <div class="mb-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border border-gray-300 rounded-lg">
                <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="text-left px-4 py-3 font-medium text-gray-700">#</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-700">Product</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-700">Stock</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-700">Qty</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody id="transfer-product-list">
                    <tr>
                            <td class="px-4 py-8 text-center text-gray-500" colspan="5">No data Available</td>
                    </tr>
                </tbody>
            </table>
                </div>
        </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            {{-- Optional Category --}}
            <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Category *</label>
                    <select name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                        <option value="">Choose_Category_Transfer</option>
                    @foreach($categories ?? [] as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Status --}}
            <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Status *</label>
                    <select name="statut" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-violet-500 focus:border-transparent" required>
                        <option value="completed" selected>Completed</option>
                    <option value="pending">Pending</option>
                    <option value="sent">Sent</option>
                </select>
            </div>
        </div>

        {{-- Notes --}}
            <div class="mb-6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Note</label>
                <textarea name="notes" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-violet-500 focus:border-transparent" rows="3" placeholder="A few words ..."></textarea>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <button type="submit" class="flex items-center px-4 py-2 bg-violet-600 text-white rounded-md hover:bg-violet-700 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Submit
            </button>
        </div>
    </form>

    <!-- Product Edit Modal -->
    <div id="productModal" class="fixed inset-0 flex items-center justify-center z-[70] hidden">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-[1px]"></div>
        <div class="relative w-[92%] md:w-[350px] bg-white rounded-xl shadow-xl border border-gray-200">
            <!-- Modal Header -->
            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                <div id="modalProductName" class="font-semibold text-gray-800">Product Name</div>
                <button type="button" onclick="closeProductModal()" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>
            
            <!-- Modal Body -->
            <div class="px-4 py-3 space-y-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Product Cost *</label>
                    <input type="number" id="modalProductCost" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-violet-500 focus:border-transparent" value="0" min="0" step="0.01">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tax Type *</label>
                    <select id="modalTaxType" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                        <option value="exclusive">Exclusive</option>
                        <option value="inclusive">Inclusive</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Order Tax *</label>
                    <div class="flex">
                        <input type="number" id="modalOrderTax" class="flex-1 px-2 py-1.5 text-sm border border-gray-300 rounded-l-md focus:ring-2 focus:ring-violet-500 focus:border-transparent" value="0" min="0" max="100" step="0.01">
                        <span class="px-2 py-1.5 text-sm bg-gray-100 border border-l-0 border-gray-300 rounded-r-md text-gray-700">%</span>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Discount Type *</label>
                    <select id="modalDiscountType" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                        <option value="fixed">Fixed</option>
                        <option value="percent">Percent %</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Discount *</label>
                    <input type="number" id="modalDiscount" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-violet-500 focus:border-transparent" value="0" min="0" step="0.01">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Purchase Unit *</label>
                    <select id="modalPurchaseUnit" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->ShortName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex justify-end px-4 py-2 border-t border-gray-100">
                <button type="button" onclick="saveProductModal()" class="px-4 py-2 bg-violet-600 text-white rounded-md hover:bg-violet-700 transition-colors">
                    Submit
                </button>
            </div>
        </div>
    </div>

    <script>
const units = @json($units);
let addedItems = [];
let currentEditingIndex = -1;

function productSearch() {
    return {
        query: '',
        open: false,
        results: [],
        _timer: null,
        async search() {
            this.open = true;
            clearTimeout(this._timer);
            this._timer = setTimeout(async () => {
                try {
                    const base = {{ route('transfers.productSearch') }};
                    const url = (this.query && this.query.length >= 1) ? ${base}?q=${encodeURIComponent(this.query)} : ${base}?limit=30;
                    const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                    if (!res.ok) { this.results = []; return; }
                    const data = await res.json().catch(() => []);
                    this.results = Array.isArray(data) ? data : [];
                } catch (e) { this.results = []; }
            }, 250);
        },
        async preload() {
            try {
                const res = await fetch({{ route('transfers.productSearch') }}?limit=30, { headers: { 'Accept': 'application/json' } });
                if (!res.ok) { this.results = []; return; }
                const data = await res.json().catch(() => []);
                this.results = Array.isArray(data) ? data : [];
            } catch (e) { this.results = []; }
        },
        add(item) {
            this.open = false; 
            this.query = '';
            addProduct(item);
        }
    }
}

function addProduct(p) {
    console.log("Adding product:", p);
    if (addedItems.find(i => i.product_id === p.id)) {
        alert("Product already added");
        return;
    }

    const table = document.getElementById("transfer-product-list");
    if (table.querySelector("tr")?.children.length === 1) {
        table.innerHTML = "";
    }

    const index = addedItems.length;

    const row = document.createElement("tr");
    row.innerHTML = `
        <td class="px-4 py-3 text-gray-700">${index + 1}</td>
        <td class="px-4 py-3">
            <div class="space-y-2">
                <div class="text-sm font-medium text-gray-900">${p.code || 'N/A'}</div>
                <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                ${p.name}
                            </span>
                            <button type="button" onclick="openProductModal(${index}, ${p.id})" class="w-4 h-4 text-gray-400 hover:text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                </div>
            </div>
            <input type="hidden" name="items[${index}][product_id]" value="${p.id}">
        </td>
        <td class="px-4 py-3">
            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-orange-100 text-orange-800">
                0 Pcs
            </span>
        </td>
        <td class="px-4 py-3">
            <div class="flex items-center space-x-1">
                <button type="button" onclick="decreaseQty(${index})" class="w-8 h-8 bg-violet-600 text-white rounded flex items-center justify-center hover:bg-violet-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                    </svg>
                </button>
                <input type="number" name="items[${index}][quantity]" id="qty-${index}" class="w-16 px-2 py-1 text-center border border-gray-300 rounded focus:ring-2 focus:ring-violet-500 focus:border-transparent" value="0" min="0" step="1" required>
                <button type="button" onclick="increaseQty(${index})" class="w-8 h-8 bg-violet-600 text-white rounded flex items-center justify-center hover:bg-violet-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </button>
            </div>
        </td>
        <td class="px-4 py-3">
            <div class="flex justify-center">
                <button type="button" onclick="removeProduct(${index})" class="w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors shadow-md">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </td>
    `;
    table.appendChild(row);
    addedItems.push({ 
        product_id: p.id, 
        name: p.name, 
        code: p.code,
        cost: 0,
        tax_type: 'exclusive',
        order_tax: 0,
        discount_type: 'fixed',
        discount: 0,
        purchase_unit_id: units.length > 0 ? units[0].id : ''
    });
}

function increaseQty(index) {
    const input = document.getElementById(qty-${index});
    const currentValue = parseInt(input.value) || 0;
    input.value = currentValue + 1;
}

function decreaseQty(index) {
    const input = document.getElementById(qty-${index});
    const currentValue = parseInt(input.value) || 0;
    if (currentValue > 0) {
        input.value = currentValue - 1;
    }
}

function removeProduct(index) {
    addedItems.splice(index, 1);
    const table = document.getElementById("transfer-product-list");
    table.innerHTML = "";
    
    if (addedItems.length === 0) {
        table.innerHTML = '<tr><td class="px-4 py-8 text-center text-gray-500" colspan="5">No data Available</td></tr>';
    } else {
        // Re-render all items
        addedItems.forEach((item, idx) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td class="px-4 py-3 text-gray-700">${idx + 1}</td>
                <td class="px-4 py-3">
                    <div class="space-y-2">
                        <div class="text-sm font-medium text-gray-900">${item.code || 'N/A'}</div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                ${item.name}
                            </span>
                            <button type="button" onclick="openProductModal(${idx}, ${item.product_id})" class="w-4 h-4 text-gray-400 hover:text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="items[${idx}][product_id]" value="${item.product_id}">
                    <input type="hidden" name="items[${idx}][purchase_unit_id]" value="${item.purchase_unit_id || ''}">
                </td>
                <td class="px-4 py-3">
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-orange-100 text-orange-800">
                        0 Pcs
                    </span>
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center space-x-1">
                        <button type="button" onclick="decreaseQty(${idx})" class="w-8 h-8 bg-violet-600 text-white rounded flex items-center justify-center hover:bg-violet-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </button>
                        <input type="number" name="items[${idx}][quantity]" id="qty-${idx}" class="w-16 px-2 py-1 text-center border border-gray-300 rounded focus:ring-2 focus:ring-violet-500 focus:border-transparent" value="0" min="0" step="1" required>
                        <button type="button" onclick="increaseQty(${idx})" class="w-8 h-8 bg-violet-600 text-white rounded flex items-center justify-center hover:bg-violet-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </button>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <div class="flex justify-center">
                        <button type="button" onclick="removeProduct(${idx})" class="w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors shadow-md">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </td>
            `;
            table.appendChild(row);
        });
    }
}

// Modal functions
function openProductModal(index, productId) {
    currentEditingIndex = index;
    const product = addedItems.find(item => item.product_id === productId);
    
    if (product) {
        document.getElementById('modalProductName').textContent = product.name;
        
        // Set default values (you can modify these based on your needs)
        document.getElementById('modalProductCost').value = product.cost || 0;
        document.getElementById('modalTaxType').value = product.tax_type || 'exclusive';
        document.getElementById('modalOrderTax').value = product.order_tax || 0;
        document.getElementById('modalDiscountType').value = product.discount_type || 'fixed';
        document.getElementById('modalDiscount').value = product.discount || 0;
        document.getElementById('modalPurchaseUnit').value = product.purchase_unit_id || '';
        
        document.getElementById('productModal').classList.remove('hidden');
    }
}

function closeProductModal() {
    document.getElementById('productModal').classList.add('hidden');
    currentEditingIndex = -1;
}

function saveProductModal() {
    if (currentEditingIndex >= 0) {
        const product = addedItems[currentEditingIndex];
        
        // Update product data
        product.cost = parseFloat(document.getElementById('modalProductCost').value) || 0;
        product.tax_type = document.getElementById('modalTaxType').value;
        product.order_tax = parseFloat(document.getElementById('modalOrderTax').value) || 0;
        product.discount_type = document.getElementById('modalDiscountType').value;
        product.discount = parseFloat(document.getElementById('modalDiscount').value) || 0;
        product.purchase_unit_id = document.getElementById('modalPurchaseUnit').value;
        
        // Update the table row
        updateProductRow(currentEditingIndex, product);
        
        closeProductModal();
    }
}

function updateProductRow(index, product) {
    const table = document.getElementById("transfer-product-list");
    const rows = table.querySelectorAll("tr");
    
    if (rows[index]) {
        const row = rows[index];
        
        // Update hidden inputs
        const hiddenInputs = row.querySelectorAll('input[type="hidden"]');
        hiddenInputs.forEach(input => {
            if (input.name.includes('[product_id]')) {
                input.value = product.product_id;
            }
        });
        
        // Update quantity input name to include purchase_unit_id
        const qtyInput = row.querySelector('input[type="number"]');
        if (qtyInput) {
            qtyInput.name = items[${index}][quantity];
        }
        
        // Add hidden input for purchase_unit_id
        let purchaseUnitInput = row.querySelector('input[name*="[purchase_unit_id]"]');
        if (!purchaseUnitInput) {
            purchaseUnitInput = document.createElement('input');
            purchaseUnitInput.type = 'hidden';
            purchaseUnitInput.name = items[${index}][purchase_unit_id];
            row.appendChild(purchaseUnitInput);
        }
        purchaseUnitInput.value = product.purchase_unit_id;
    }
}
</script>

</div>
@endsection