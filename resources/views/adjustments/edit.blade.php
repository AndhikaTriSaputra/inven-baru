@extends('layouts.app')

@section('header')
  <div class="flex items-center gap-2">
    <a href="{{ route('adjustments.index') }}" class="text-slate-500 hover:text-slate-700">All Adjustments</a>
    <span class="text-slate-400">/</span>
    <span class="font-semibold">Edit Adjustment</span>
  </div>
@endsection

@section('content')
<div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
  <form method="POST" action="{{ route('adjustments.update',$header->id) }}">
    @csrf
    @method('PUT')

    {{-- Header Section --}}
    <div class="mb-8">
      <h2 class="text-xl font-semibold text-gray-800 mb-6">Edit Stock Adjustment</h2>
      
      {{-- Back Button --}}
      <div class="mb-6">
        <a href="{{ route('adjustments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-700 transition-all duration-200">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          Back to Adjustments
        </a>
      </div>
      
      {{-- Date Field --}}
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          Date <span class="text-red-500 font-bold">*</span>
        </label>
        <input type="date" name="date" value="{{ \Carbon\Carbon::parse($header->date)->format('Y-m-d') }}"
               class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300">
      </div>
    </div>

    {{-- Product Search Section --}}
    <div class="mb-8">
      <label class="block text-sm font-semibold text-gray-700 mb-2">Add Product</label>
      <div class="relative" x-data="productSearch()">
        <div class="input-search-icon">
          <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
        </div>
        <input x-model="query" @focus="open=true; if(results.length===0) preload();" @input="search" @keydown.enter.prevent="if(results.length){ add(results[0]) }" 
               type="text" placeholder="Scan/Search Product by Code Or Name"
               class="form-input input-search w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300">
        <div x-show="open" @click.outside="open=false" class="absolute z-50 left-0 right-0 bg-white border rounded-lg mt-1 shadow-lg max-h-64 overflow-y-auto overflow-x-hidden whitespace-nowrap">
          <template x-for="item in results" :key="item.id">
            <button type="button" class="w-full flex items-center gap-3 px-3 py-2 hover:bg-gray-50 text-left" @click="add(item)">
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
              <span class="truncate" x-text="item.label"></span>
            </button>
          </template>
          <div x-show="!results || results.length===0" class="px-3 py-2 text-sm text-gray-500">No results</div>
        </div>
      </div>
    </div>

    {{-- Products Table --}}
    <div class="mb-8">
      <h3 class="text-lg font-semibold text-gray-800 mb-4">Adjustment Items</h3>
      <div class="overflow-x-auto bg-white border border-gray-200 rounded-lg">
        <table class="w-full text-sm">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-3 text-left text-gray-600 font-semibold">#</th>
              <th class="px-4 py-3 text-left text-gray-600 font-semibold">Code</th>
              <th class="px-4 py-3 text-left text-gray-600 font-semibold">Product</th>
              <th class="px-4 py-3 text-left text-gray-600 font-semibold">Warehouse</th>
              <th class="px-4 py-3 text-left text-gray-600 font-semibold">Current Stock</th>
              <th class="px-4 py-3 text-left text-gray-600 font-semibold">Adjustment Qty</th>
              <th class="px-4 py-3 text-left text-gray-600 font-semibold">Type</th>
              <th class="px-4 py-3 text-center text-gray-600 font-semibold">Action</th>
            </tr>
          </thead>
          <tbody id="adjustmentTableBody">
            @foreach($items as $i => $row)
              <tr class="border-b border-gray-100 hover:bg-gray-50">
                <td class="px-4 py-3 text-gray-600">{{ $i+1 }}</td>
                <td class="px-4 py-3 font-medium text-gray-900">{{ $row->code }}</td>
                <td class="px-4 py-3 text-gray-700">{{ $row->name }}</td>
                <td class="px-4 py-3">
                  @if(!empty($hasWarehouseCol))
                    <select name="rows[{{ $i }}][warehouse_id]" class="w-full border border-gray-200 rounded-md px-3 py-2 text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-100 whSel" data-row-index="{{ $i }}">
                      <option value="">— Choose Warehouse —</option>
                      @foreach($warehouseOptions as $wid => $label)
                        <option value="{{ $wid }}" @selected(($row->warehouse_id ?? null)==$wid)>{{ $label }}</option>
                      @endforeach
                    </select>
                  @else
                    <select name="header_warehouse_id" class="w-full border border-gray-200 rounded-md px-3 py-2 text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-100">
                      @foreach($warehouseOptions as $wid => $label)
                        <option value="{{ $wid }}" @selected($headerWarehouseId==$wid)>{{ $label }}</option>
                      @endforeach
                    </select>
                  @endif
                </td>
                <td class="px-4 py-3">
                  @php
                    $curWid = !empty($hasWarehouseCol) ? ($row->warehouse_id ?? null) : $headerWarehouseId;
                    $stk = $curWid ? ($stockByWh[$row->product_id.':'.$curWid] ?? 0) : 0;
                  @endphp
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-violet-100 text-violet-800" data-stock="{{ $row->product_id }}:{{ $curWid ?? 0 }}">
                    {{ $stk }} Pcs
                  </span>
                </td>
                <td class="px-4 py-3">
                  <div class="flex items-center">
                    <button type="button" class="dec px-3 py-1.5 border border-gray-200 rounded-l-md hover:bg-gray-50 transition-colors" data-target="qty{{ $row->id }}">
                      <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                      </svg>
                    </button>
                    <input type="number" min="0" name="rows[{{ $i }}][qty]" id="qty{{ $row->id }}"
                           value="{{ (int)$row->qty }}" class="w-20 text-center border-t border-b border-gray-200 py-1.5 focus:border-violet-500 focus:ring-1 focus:ring-violet-100">
                    <button type="button" class="inc px-3 py-1.5 border border-gray-200 rounded-r-md hover:bg-gray-50 transition-colors" data-target="qty{{ $row->id }}">
                      <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                      </svg>
                    </button>
                  </div>
                </td>
                <td class="px-4 py-3">
                  <select name="rows[{{ $i }}][type]" class="w-full border border-gray-200 rounded-md px-3 py-2 text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-100">
                    <option value="Addition" @selected($row->type==='Addition')>Addition</option>
                    <option value="Subtraction" @selected($row->type==='Subtraction')>Subtraction</option>
                  </select>
                </td>
                <td class="px-4 py-3 text-center">
                  <input type="hidden" name="rows[{{ $i }}][id]" value="{{ $row->id }}">
                  <input type="hidden" name="rows[{{ $i }}][product_id]" value="{{ $row->product_id }}">
                  <input type="hidden" name="rows[{{ $i }}][_delete]" id="del_{{ $row->id }}" value="">
                  <button type="button" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-md transition-colors" onclick="markDelete({{ $row->id }}, this)" title="Remove item">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    {{-- Notes Section --}}
    <div class="mb-8">
      <label class="block text-sm font-semibold text-gray-700 mb-2">Notes</label>
      <textarea name="notes" rows="4" class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 transition-all duration-200 focus:border-violet-500 focus:ring-2 focus:ring-violet-100 focus:outline-none hover:border-gray-300" 
                placeholder="Add any notes about this adjustment...">{{ old('notes',$header->notes) }}</textarea>
    </div>

    {{-- Submit Button --}}
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
      <div class="flex items-center justify-end space-x-4">
        <a href="{{ route('adjustments.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors duration-200">
          Cancel
        </a>
        <button type="submit" class="flex items-center px-4 py-2 bg-violet-600 text-white rounded-md hover:bg-violet-700 transition-colors duration-200">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
          </svg>
          Update Adjustment
        </button>
      </div>
    </div>
  </form>
</div>

{{-- Scripts --}}
<script>
  // Product search functionality
  function productSearch() {
    return {
      query: '',
      open: false,
      results: [],
      idx: {{ count($items) }},
      _timer: null,
      async search() {
        this.open = true;
        clearTimeout(this._timer);
        this._timer = setTimeout(async () => {
          try {
            const base = `{{ route('adjustments.productSearch') }}`;
            const url = (this.query && this.query.length >= 1) ? `${base}?q=${encodeURIComponent(this.query)}` : `${base}?limit=30`;
            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) { this.results = []; return; }
            const data = await res.json().catch(() => []);
            this.results = Array.isArray(data) ? data : [];
          } catch (e) { this.results = []; }
        }, 250);
      },
      async preload() {
        try {
          const res = await fetch(`{{ route('adjustments.productSearch') }}?limit=30`, { headers: { 'Accept': 'application/json' } });
          if (!res.ok) { this.results = []; return; }
          const data = await res.json().catch(() => []);
          this.results = Array.isArray(data) ? data : [];
        } catch (e) { this.results = []; }
      },
      add(item) {
        this.open = false; 
        this.query = '';
        const tbody = document.getElementById('adjustmentTableBody');
        const i = this.idx++;
        const tr = document.createElement('tr');
        tr.className = 'border-b border-gray-100 hover:bg-gray-50';
        tr.innerHTML = `
          <td class="px-4 py-3 text-gray-600">${i + 1}</td>
          <td class="px-4 py-3 font-medium text-gray-900">${item.code || ''}</td>
          <td class="px-4 py-3 text-gray-700">${item.name}</td>
          <td class="px-4 py-3">${renderWarehouseSelect(i)}</td>
          <td class="px-4 py-3">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-violet-100 text-violet-800">0 Pcs</span>
          </td>
          <td class="px-4 py-3">
            <div class="flex items-center">
              <button type="button" class="dec px-3 py-1.5 border border-gray-200 rounded-l-md hover:bg-gray-50 transition-colors" data-target="qty_new_${i}">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                </svg>
              </button>
              <input type="number" min="0" name="rows[${i}][qty]" id="qty_new_${i}" value="0" class="w-20 text-center border-t border-b border-gray-200 py-1.5 focus:border-violet-500 focus:ring-1 focus:ring-violet-100">
              <button type="button" class="inc px-3 py-1.5 border border-gray-200 rounded-r-md hover:bg-gray-50 transition-colors" data-target="qty_new_${i}">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
              </button>
            </div>
          </td>
          <td class="px-4 py-3">
            <select name="rows[${i}][type]" class="w-full border border-gray-200 rounded-md px-3 py-2 text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-100">
              <option value="Addition" selected>Addition</option>
              <option value="Subtraction">Subtraction</option>
            </select>
          </td>
          <td class="px-4 py-3 text-center">
            <input type="hidden" name="rows[${i}][product_id]" value="${item.id}">
            <button type="button" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-md transition-colors" onclick="this.closest('tr').remove()" title="Remove item">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
              </svg>
            </button>
          </td>
        `;
        tbody.appendChild(tr);
        // Re-bind inc/dec for new row
        tr.querySelectorAll('.inc,.dec').forEach(btn => {
          btn.addEventListener('click', () => {
            const el = document.getElementById(btn.dataset.target);
            let v = parseInt(el.value || 0, 10);
            if (btn.classList.contains('inc')) v++; 
            else v = Math.max(0, v - 1);
            el.value = v;
          });
        });
      }
    }
  }

  function renderWarehouseSelect(i) {
    const has = {{ !empty($hasWarehouseCol) ? 'true' : 'false' }};
    if (!has) {
      return `<span class="text-gray-600">{{ $headerWarehousePath }}</span>`;
    }
    const options = `@foreach($warehouseOptions as $wid => $label)<option value="{{ $wid }}">{{ $label }}</option>@endforeach`;
    return `<select name="rows[${i}][warehouse_id]" class="w-full border border-gray-200 rounded-md px-3 py-2 text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-100 whSel" data-row-index="${i}"><option value="">— Choose Warehouse —</option>${options}</select>`;
  }

  // Quantity increment/decrement
  document.querySelectorAll('.inc,.dec').forEach(btn => {
    btn.addEventListener('click', e => {
      const id = btn.dataset.target;
      const el = document.getElementById(id);
      let v = parseInt(el.value || 0, 10);
      if (btn.classList.contains('inc')) v++;
      else v = Math.max(0, v - 1);
      el.value = v;
    });
  });

  // Mark for deletion
  function markDelete(id, btn) {
    const hid = document.getElementById('del_' + id);
    if (hid) { hid.value = '1'; }
    // Hide row visually
    const tr = btn.closest('tr');
    if (tr) { 
      tr.style.opacity = '.5'; 
      tr.style.textDecoration = 'line-through'; 
    }
  }

  // Update stock badge when warehouse changes
  document.addEventListener('change', async (e) => {
    const sel = e.target.closest('select.whSel');
    if (!sel) return;
    const tr = sel.closest('tr');
    if (!tr) return;
    const prodIdInput = tr.querySelector('input[type="hidden"][name^="rows"][name$="[product_id]"]');
    if (!prodIdInput) return;
    const productId = prodIdInput.value;
    const warehouseId = sel.value || 0;
    try {
      const url = `{{ route('adjustments.productStock') }}?product_id=${encodeURIComponent(productId)}&warehouse_id=${encodeURIComponent(warehouseId)}`;
      const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
      const data = await res.json();
      const badge = tr.querySelector('td:nth-child(5) span');
      if (badge) { 
        badge.textContent = ((data && typeof data.qty === 'number') ? data.qty : 0) + ' Pcs'; 
      }
    } catch (_) { /* ignore */ }
  });
</script>
@endsection
