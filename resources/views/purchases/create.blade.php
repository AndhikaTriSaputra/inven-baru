create purchases

@extends('layouts.app')

@section('header')
Create Purchase
@endsection

@section('content')
<form action="{{ route('purchases.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-gray-200 rounded-xl p-6">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date <span class="text-red-500">*</span></label>
                    <input type="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Supplier <span class="text-red-500">*</span></label>
                    <select name="provider_id" class="w-full border rounded-lg px-3 py-2">
                        <option value="">Choose Supplier</option>
                        @foreach($providers as $p)
                            <option value="{{ $p->id }}" @selected(old('provider_id')==$p->id)>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Warehouse <span class="text-red-500">*</span></label>
                    <select id="warehouse_id" name="warehouse_id" class="w-full border rounded-lg px-3 py-2">
                        <option value="">Choose Warehouse</option>
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}" @selected(old('warehouse_id')==$w->id)>{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div> -->

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Date <span class="text-red-500">*</span></label>
        <input type="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" class="w-full border rounded-lg px-3 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Supplier <span class="text-red-500">*</span></label>
        <select name="provider_id" class="w-full border rounded-lg px-3 py-2">
            <option value="">Choose Supplier</option>
            @foreach($providers as $p)
                <option value="{{ $p->id }}" @selected(old('provider_id')==$p->id)>{{ $p->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Warehouse <span class="text-red-500">*</span></label>
        <select id="warehouse_id" name="warehouse_id" class="w-full border rounded-lg px-3 py-2">
            <option value="">Choose Warehouse</option>
            @foreach($warehouses as $w)
                <option value="{{ $w->id }}" @selected(old('warehouse_id')==$w->id)>{{ $w->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
        <select name="brand_id" class="w-full border rounded-lg px-3 py-2">
            <option value="">Choose Brand</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>

    @if (isset($projects) && $projects->count())
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Project</label>
        <select name="project_id" class="w-full border rounded-lg px-3 py-2">
            <option value="">Choose Project</option>
            @foreach ($projects as $proj)
                <option value="{{ $proj->id }}" @selected(old('project_id') == $proj->id)>{{ $proj->name }}</option>
            @endforeach
        </select>
    </div>
    @endif

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Product Type</label>
        <select name="type" class="w-full border rounded-lg px-3 py-2">
            <option value="">Choose Type</option>
            @foreach ($types as $t)
                <option value="{{ $t }}" @selected(old('type') == $t)>{{ $t }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Barcode Symbology</label>
        <select name="barcode_symbology" class="w-full border rounded-lg px-3 py-2">
            <option value="">Choose Barcode</option>
            @foreach ($barcode_types as $btype)
                <option value="{{ strtolower(str_replace(' ', '', $btype)) }}" @selected(old('barcode_symbology') == strtolower(str_replace(' ', '', $btype)))>{{ $btype }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
        <select name="category_id" class="w-full border rounded-lg px-3 py-2" required>
            <option value="">Choose Category</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
        @error('category_id')
            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>


            <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
    <select name="brand_id" class="w-full border rounded-lg px-3 py-2">
        <option value="">Choose Brand</option>
        @foreach ($brands as $brand)
            <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>{{ $brand->name }}</option>
        @endforeach
    </select>
</div>

@if (isset($projects) && $projects->count())
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Project</label>
    <select name="project_id" class="w-full border rounded-lg px-3 py-2">
        <option value="">Choose Project</option>
        @foreach ($projects as $proj)
            <option value="{{ $proj->id }}" @selected(old('project_id') == $proj->id)>{{ $proj->name }}</option>
        @endforeach
    </select>
</div>
@endif

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Product Type</label>
    <select name="type" class="w-full border rounded-lg px-3 py-2">
        <option value="">Choose Type</option>
        @foreach ($types as $t)
            <option value="{{ $t }}" @selected(old('type') == $t)>{{ $t }}</option>
        @endforeach
    </select>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Barcode Symbology</label>
    <select name="barcode_symbology" class="w-full border rounded-lg px-3 py-2">
        <option value="">Choose Barcode</option>
        @foreach ($barcode_types as $btype)
            <option value="{{ strtolower(str_replace(' ', '', $btype)) }}" @selected(old('barcode_symbology') == strtolower(str_replace(' ', '', $btype)))>{{ $btype }}</option>
        @endforeach
    </select>
</div>


            <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">
        Category <span class="text-red-500">*</span>
      </label>
      <select name="category_id" class="w-full border rounded-lg px-3 py-2" required>
          <option value="">Choose Category</option>
          @foreach($categories as $c)
            <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>
              {{ $c->name }}
            </option>
          @endforeach
      </select>
      @error('category_id')
        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
      @enderror
    </div>
</div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product</label>
                <div class="relative">
                    <input id="productSearch" type="text" placeholder="Scan/Search Product by Code Or Name" class="w-full border rounded-lg px-3 py-2 pr-10" autocomplete="off">
                    <div id="searchResults" class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg hidden max-h-64 overflow-auto"></div>
                </div>
            </div>

            <div>
                <div class="text-sm font-medium text-gray-700 mb-2">Order items <span class="text-red-500">*</span></div>
                <div class="overflow-x-auto border border-gray-200 rounded-lg">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr class="text-left">
                                <th class="px-3 py-2">#</th>
                                <th class="px-3 py-2">Product</th>
                                <th class="px-3 py-2">Current Stock</th>
                                <th class="px-3 py-2">Qty</th>
                                <th class="px-3 py-2">Cost</th>
                                <th class="px-3 py-2">Unit</th>
                                <th class="px-3 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemsBody">
                            <tr id="noItemsRow"><td class="px-3 py-4 text-center text-gray-500" colspan="7">No data Available</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Note</label>
                <textarea name="notes" rows="4" class="w-full border rounded-lg px-3 py-2" placeholder="A few words ...">{{ old('notes') }}</textarea>
            </div>
        </div>

        <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
    <select name="status" class="w-full border rounded-lg px-3 py-2">
        <option value="received" @selected(old('status') == 'received')>Received</option>
        <option value="pending" @selected(old('status') == 'pending')>Pending</option>
        <option value="ordered" @selected(old('status') == 'ordered')>Ordered</option>
    </select>
</div>

        

        <div>
            <div class="border border-gray-200 rounded-xl p-4">
                <div class="font-semibold mb-3">Upload Image</div>
                <div class="border-2 border-dashed rounded-lg p-6 text-center text-sm text-gray-500">Drag & drop single image here or
                    <label class="inline-block ml-2 px-3 py-1 rounded bg-violet-600 text-white cursor-pointer">
                        Select Image
                        <input id="purchaseImage" type="file" class="hidden" accept="image/*" name="image" />
                    </label>
                </div>
                <div id="purchaseImagePreview" class="mt-3 hidden">
                    <img src="" alt="Preview" class="mx-auto max-h-48">

                </div>
            </div>
        </div>
    </div>

    @error('items')
    <div class="mt-4 text-red-600 text-sm">{{ $message }}</div>
    @enderror
     <div>
                <button type="submit" class="px-5 py-2 rounded-lg bg-violet-600 text-white">Submit</button>
            </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const products = @json($products ?? []);
    const units = @json($units ?? []);
    const itemsBody = document.getElementById('itemsBody');
    const noItemsRow = document.getElementById('noItemsRow');
    const search = document.getElementById('productSearch');
    const results = document.getElementById('searchResults');

    

    function ensureNoRow(){ if (itemsBody.querySelectorAll('tr[data-row]').length === 0) { noItemsRow.classList.remove('hidden'); } }

    function renderResults(q){
        const query = (q||'').toLowerCase().trim();
        const filtered = (products||[]).filter(p => {
            const name = (p.name||'').toLowerCase();
            const code = (p.code||'').toLowerCase();
            return !query || name.includes(query) || code.includes(query);
        }).slice(0,50);
        if (!filtered.length){ results.classList.add('hidden'); results.innerHTML = ''; return; }
        results.innerHTML = filtered.map(p => <button type="button" data-id="${p.id}" class="w-full text-left px-3 py-2 hover:bg-violet-50"><div class="font-medium">${p.name}</div><div class="text-xs text-gray-500">${p.code||''}</div></button>).join('');
        results.classList.remove('hidden');
    }

    search.addEventListener('input', e => renderResults(e.target.value));
    document.addEventListener('click', e => {
        if (!results.contains(e.target) && e.target !== search){ results.classList.add('hidden'); }
    });

    results.addEventListener('click', async (e)=>{
        const btn = e.target.closest('button[data-id]');
        if(!btn) return; results.classList.add('hidden');
        const id = btn.getAttribute('data-id');
        const product = (products||[]).find(p => String(p.id)===String(id));
        if(!product) return;
        addRow(product);
        search.value='';
    });

    function addRow(product){
        noItemsRow.classList.add('hidden');
        const rowIdx = Date.now().toString(36);
        const tr = document.createElement('tr');
        tr.setAttribute('data-row','1');
        tr.innerHTML = `
            <td class="px-3 py-2">•</td>
            <td class="px-3 py-2">${product.name} <input type="hidden" name="items[${rowIdx}][product_id]" value="${product.id}"></td>
            <td class="px-3 py-2"><span data-stock>—</span></td>
            <td class="px-3 py-2"><input name="items[${rowIdx}][quantity]" type="number" step="0.0001" value="1" min="0.0001" class="w-24 border rounded px-2 py-1"></td>
            <td class="px-3 py-2"><input name="items[${rowIdx}][cost]" type="number" step="0.01" value="0" min="0" class="w-28 border rounded px-2 py-1"></td>
            <td class="px-3 py-2">
                <select name="items[${rowIdx}][purchase_unit_id]" class="border rounded px-2 py-1">
                    <option value="">-</option>
                    ${units.map(u=><option value="${u.id}">${u.ShortName||u.name||'Unit'}</option>).join('')}
                </select>
            </td>
            <td class="px-3 py-2"><button type="button" class="text-rose-600" data-remove>Remove</button></td>
        `;
        itemsBody.appendChild(tr);
        fetchStock(product.id, tr.querySelector('[data-stock]'));

        tr.querySelector('[data-remove]').addEventListener('click', ()=>{ tr.remove(); ensureNoRow(); });
    }

    async function fetchStock(productId, el){
        const wh = document.getElementById('warehouse_id').value;
        if(!wh){ el.textContent='—'; return; }
        try{
            const url = @json(route('adjustments.productStock')); // returns stock by product+warehouse if available in this app
            const res = await fetch(${url}?product_id=${productId}&warehouse_id=${wh}, { headers:{'Accept':'application/json'} });
            if(!res.ok) throw new Error('failed');
            const data = await res.json();
            el.textContent = (data && typeof data.stock!== 'undefined') ? data.stock : '0';
        }catch(e){ el.textContent='0'; }
    }

    document.getElementById('warehouse_id').addEventListener('change', ()=>{
        itemsBody.querySelectorAll('tr[data-row]').forEach(tr=>{
            const pid = tr.querySelector('input[name$="[product_id]"]').value;
            fetchStock(pid, tr.querySelector('[data-stock]'));
        });
    });

    // Image preview before submit
    const input = document.getElementById('purchaseImage');
    const previewWrap = document.getElementById('purchaseImagePreview');
    const previewImg = previewWrap ? previewWrap.querySelector('img') : null;
    if (input && previewWrap && previewImg){
        input.addEventListener('change', function(){
            const file = this.files && this.files[0];
            if (!file) { previewWrap.classList.add('hidden'); return; }
            const reader = new FileReader();
            reader.onload = function(e){
                previewImg.src = e.target.result;
                previewWrap.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });
    }
});
</script>
@endpush
@endsection