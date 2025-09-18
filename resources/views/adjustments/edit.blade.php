@extends('layouts.app')

@section('header')
  <div class="flex items-center gap-2">
    <a href="{{ route('adjustments.index') }}" class="text-slate-500 hover:text-slate-700">All Adjustments</a>
    <span class="text-slate-400">/</span>
    <span class="font-semibold">Edit Adjustment</span>
  </div>
@endsection

@section('content')
<form method="POST" action="{{ route('adjustments.update',$header->id) }}" class="bg-white border border-gray-200 rounded-xl p-6">
  @csrf
  @method('PUT')

  {{-- date --}}
  <div class="mb-4">
    <label class="block text-sm text-slate-600 mb-1">Date *</label>
    <input type="date" name="date" value="{{ \Carbon\Carbon::parse($header->date)->format('Y-m-d') }}"
           class="w-full border rounded-lg px-3 py-2">
  </div>

  {{-- search & add product row --}}
  <div class="mb-4">
    <label class="block text-sm text-slate-600 mb-1">Product</label>
    <script>
      window.renderWarehouseSelect = function(i){
        const has = {{ !empty($hasWarehouseCol) ? 'true' : 'false' }};
        if(!has){
          return `<span class="text-slate-600">{{ $headerWarehousePath }}</span>`;
        }
        const options = `@foreach($warehouseOptions as $wid => $label)<option value="{{ $wid }}">{{ $label }}</option>@endforeach`;
        return `<select name="rows[${i}][warehouse_id]" class="border rounded-md px-2 py-1"><option value="">— Choose —</option>${options}</select>`;
      };
      window.productSearch = function(){
        return {
          query: '',
          open: false,
          results: [],
          idx: {{ count($items) }},
          _timer: null,
          async search(){
            this.open = true;
            clearTimeout(this._timer);
            this._timer = setTimeout(async () => {
              try{
                const base = `{{ route('adjustments.productSearch') }}`;
                const url = (this.query && this.query.length >= 1) ? `${base}?q=${encodeURIComponent(this.query)}` : `${base}?limit=30`;
                const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                if(!res.ok){ this.results = []; return; }
                const data = await res.json().catch(()=>[]);
                this.results = Array.isArray(data) ? data : [];
              }catch(e){ this.results = []; }
            }, 250);
          },
          async preload(){
            try{
              const res = await fetch(`{{ route('adjustments.productSearch') }}?limit=30`, { headers: { 'Accept': 'application/json' } });
              if(!res.ok){ this.results = []; return; }
              const data = await res.json().catch(()=>[]);
              this.results = Array.isArray(data) ? data : [];
            }catch(e){ this.results = []; }
          },
          add(item){
            this.open = false; this.query = '';
            const tbody = document.querySelector('table tbody');
            const i = this.idx++;
            const tr = document.createElement('tr');
            tr.className = 'border-b';
            tr.innerHTML = `
              <td class="py-2 px-2">+</td>
              <td class="px-2">${item.code||''}</td>
              <td class="px-2">${item.name}</td>
              <td class="px-2">${window.renderWarehouseSelect(i)} </td>
              <td class="px-2"><span class="inline-block text-xs px-2 py-1 rounded bg-violet-50 text-violet-600">0 Pcs</span></td>
              <td class="px-2">
                <div class="flex items-center">
                  <button type="button" class="dec px-2 py-1 border rounded-l" data-target="qty_new_${i}">-</button>
                  <input type="number" min="0" name="rows[${i}][qty]" id="qty_new_${i}" value="0" class="w-14 text-center border-t border-b py-1">
                  <button type="button" class="inc px-2 py-1 border rounded-r" data-target="qty_new_${i}">+</button>
                </div>
              </td>
              <td class="px-2">
                <select name="rows[${i}][type]" class="border rounded-md px-2 py-1">
                  <option value="Addition" selected>Addition</option>
                  <option value="Subtraction">Subtraction</option>
                </select>
              </td>
              <td class="px-2">
                <input type="hidden" name="rows[${i}][product_id]" value="${item.id}">
              </td>
            `;
            tbody.appendChild(tr);
            // re-bind inc/dec for new row
            tr.querySelectorAll('.inc,.dec').forEach(btn=>{
              btn.addEventListener('click', ()=>{
                const el = document.getElementById(btn.dataset.target);
                let v = parseInt(el.value||0,10);
                if(btn.classList.contains('inc')) v++; else v = Math.max(0, v-1);
                el.value = v;
              });
            });
          }
        }
      };
    </script>
    <div class="relative" x-data="productSearch()">
      <input x-model="query" @focus="open=true; if(results.length===0) preload();" @input="search" @keydown.enter.prevent="if(results.length){ add(results[0]) }" type="text" placeholder="Scan/Search Product by Code Or Name"
             class="w-full border rounded-lg px-3 py-2 pl-10">
      <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"/>
      </svg>
      <div x-show="open" @click.outside="open=false" class="absolute z-50 left-0 right-0 bg-white border rounded-lg mt-1 shadow-lg max-h-64 overflow-y-auto overflow-x-hidden whitespace-nowrap">
        <template x-for="item in results" :key="item.id">
          <button type="button" class="w-full flex items-center gap-3 px-3 py-2 hover:bg-slate-50 text-left" @click="add(item)">
            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"/></svg>
            <span class="truncate" x-text="item.label"></span>
          </button>
        </template>
        <div x-show="results.length===0" class="px-3 py-2 text-sm text-slate-500">No results</div>
      </div>
    </div>
  </div>

  {{-- table rows --}}
  <div class="overflow-x-auto">
    <table class="w-full text-sm table-fixed">
      <colgroup>
        <col class="w-20">
        <col class="w-40">
        <col class="">
        <col class="w-160">
        <col class="w-50">
        <col class="w-40">
        <col class="w-32">
        <col class="w-10">
      </colgroup>
      <thead>
        <tr class="border-b bg-slate-50">
          <th class="text-left py-2 px-2">#</th>
          <th class="text-left px-2">Code Product</th>
          <th class="text-left px-2">Product</th>
          <th class="text-left px-2">Warehouse</th>
          <th class="text-left px-2">Stock</th>
          <th class="text-left px-2">Qty</th>
          <th class="text-left px-2">Type</th>
          <th class="px-2"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($items as $i => $row)
          <tr class="border-b">
            <td class="py-2 px-2">{{ $i+1 }}</td>
            <td class="px-2">{{ $row->code }}</td>
            <td class="px-2">{{ $row->name }}</td>
            <td class="px-2 align-middle">
              @if(!empty($hasWarehouseCol))
                <div class="w-full overflow-hidden">
                  <select name="rows[{{ $i }}][warehouse_id]" class="border rounded-md px-2 py-1 whSel w-full truncate" data-row-index="{{ $i }}" title="{{ $warehouseOptions[$row->warehouse_id ?? ''] ?? '' }}">
                  <option value="">— Choose —</option>
                  @foreach($warehouseOptions as $wid => $label)
                    <option value="{{ $wid }}" @selected(($row->warehouse_id ?? null)==$wid)>{{ $label }}</option>
                  @endforeach
                  </select>
                </div>
              @else
                <div class="w-full overflow-hidden">
                  <select name="header_warehouse_id" class="border rounded-md px-2 py-1 w-full truncate" title="{{ $warehouseOptions[$headerWarehouseId] ?? '' }}">
                  @foreach($warehouseOptions as $wid => $label)
                    <option value="{{ $wid }}" @selected($headerWarehouseId==$wid)>{{ $label }}</option>
                  @endforeach
                  </select>
                </div>
              @endif
            </td>
            <td class="px-2 align-middle whitespace-nowrap">
              @php
                $curWid = !empty($hasWarehouseCol) ? ($row->warehouse_id ?? null) : $headerWarehouseId;
                $stk = $curWid ? ($stockByWh[$row->product_id.':'.$curWid] ?? 0) : 0;
              @endphp
              <span class="inline-block text-xs px-2 py-1 rounded bg-violet-50 text-violet-600" data-stock="{{ $row->product_id }}:{{ $curWid ?? 0 }}">{{ $stk }} Pcs</span>
            </td>
            <td class="px-2">
              <div class="flex items-center">
                <button type="button" class="dec px-2 py-1 border rounded-l" data-target="qty{{ $row->id }}">-</button>
                <input type="number" min="0" name="rows[{{ $i }}][qty]" id="qty{{ $row->id }}"
                       value="{{ (int)$row->qty }}" class="w-14 text-center border-t border-b py-1">
                <button type="button" class="inc px-2 py-1 border rounded-r" data-target="qty{{ $row->id }}">+</button>
              </div>
            </td>
            <td class="px-2">
              <select name="rows[{{ $i }}][type]" class="border rounded-md px-2 py-1">
                <option value="Addition" @selected($row->type==='Addition')>Addition</option>
                <option value="Subtraction" @selected($row->type==='Subtraction')>Subtraction</option>
              </select>
            </td>
            <td class="px-2">
              <input type="hidden" name="rows[{{ $i }}][id]" value="{{ $row->id }}">
              <input type="hidden" name="rows[{{ $i }}][product_id]" value="{{ $row->product_id }}">
              <input type="hidden" name="rows[{{ $i }}][_delete]" id="del_{{ $row->id }}" value="">
              <button type="button" class="px-2 py-1 text-red-600 hover:text-red-700" onclick="markDelete({{ $row->id }}, this)">×</button>
            </td>
          </tr>
        @endforeach
        {{-- rows added dynamically will be appended here by Alpine --}}
      </tbody>
    </table>
  </div>

  {{-- notes --}}
  <div class="mt-6">
    <label class="block text-sm text-slate-600 mb-1">Note</label>
    <textarea name="notes" rows="4" class="w-full border rounded-lg px-3 py-2" placeholder="A few words ...">{{ old('notes',$header->notes) }}</textarea>
  </div>

  <div class="mt-6">
    <button class="px-4 py-2 bg-violet-600 text-white rounded-md">Submit</button>
  </div>
</form>

{{-- qty +/- --}}
<script>
  document.querySelectorAll('.inc,.dec').forEach(btn=>{
    btn.addEventListener('click', e=>{
      const id = btn.dataset.target;
      const el = document.getElementById(id);
      let v = parseInt(el.value||0,10);
      if(btn.classList.contains('inc')) v++;
      else v = Math.max(0, v-1);
      el.value = v;
    });
  });

  function markDelete(id, btn){
    const hid = document.getElementById('del_'+id);
    if(hid){ hid.value = '1'; }
    // hide row visually
    const tr = btn.closest('tr');
    if(tr){ tr.style.opacity = '.5'; tr.style.textDecoration = 'line-through'; }
  }

  // update stock badge when warehouse changes on newly added rows
  document.addEventListener('change', async (e)=>{
    const sel = e.target.closest('select.whSel');
    if(!sel) return;
    const tr = sel.closest('tr');
    if(!tr) return;
    const prodIdInput = tr.querySelector('input[type="hidden"][name^="rows"][name$="[product_id]"]');
    if(!prodIdInput) return;
    const productId = prodIdInput.value;
    const warehouseId = sel.value || 0;
    try{
      const url = `{{ route('adjustments.productStock') }}?product_id=${encodeURIComponent(productId)}&warehouse_id=${encodeURIComponent(warehouseId)}`;
      const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
      const data = await res.json();
      const badge = tr.querySelector('td:nth-child(5) span');
      if(badge){ badge.textContent = ((data && typeof data.qty === 'number') ? data.qty : 0) + ' Pcs'; }
    }catch(_){ /* ignore */ }
  });

  function productSearch(){
    return {
      query: '',
      open: false,
      results: [],
      idx: {{ count($items) }},
      _timer: null,
      async search(){
        this.open = true;
        clearTimeout(this._timer);
        this._timer = setTimeout(async () => {
          try{
            const base = `{{ route('adjustments.productSearch') }}`;
            const url = (this.query && this.query.length >= 1) ? `${base}?q=${encodeURIComponent(this.query)}` : `${base}?limit=30`;
            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            if(!res.ok){ this.results = []; return; }
            const data = await res.json().catch(()=>[]);
            this.results = Array.isArray(data) ? data : [];
          }catch(e){ this.results = []; }
        }, 250);
      },
      async preload(){
        try{
          const res = await fetch(`{{ route('adjustments.productSearch') }}?limit=30`, { headers: { 'Accept': 'application/json' } });
          if(!res.ok){ this.results = []; return; }
          const data = await res.json().catch(()=>[]);
          this.results = Array.isArray(data) ? data : [];
        }catch(e){ this.results = []; }
      },
      add(item){
        this.open = false; this.query = '';
        const tbody = document.querySelector('table tbody');
        const i = this.idx++;
        const tr = document.createElement('tr');
        tr.className = 'border-b';
        tr.innerHTML = `
          <td class="py-2 px-2">+</td>
          <td class="px-2">${item.code||''}</td>
          <td class="px-2">${item.name}</td>
          <td class="px-2">${renderWarehouseSelect(i)} </td>
          <td class="px-2"><span class="inline-block text-xs px-2 py-1 rounded bg-violet-50 text-violet-600">0 Pcs</span></td>
          <td class="px-2">
            <div class="flex items-center">
              <button type="button" class="dec px-2 py-1 border rounded-l" data-target="qty_new_${i}">-</button>
              <input type="number" min="0" name="rows[${i}][qty]" id="qty_new_${i}" value="0" class="w-14 text-center border-t border-b py-1">
              <button type="button" class="inc px-2 py-1 border rounded-r" data-target="qty_new_${i}">+</button>
            </div>
          </td>
          <td class="px-2">
            <select name="rows[${i}][type]" class="border rounded-md px-2 py-1">
              <option value="Addition" selected>Addition</option>
              <option value="Subtraction">Subtraction</option>
            </select>
          </td>
          <td class="px-2">
            <input type="hidden" name="rows[${i}][product_id]" value="${item.id}">
            <button type="button" class="px-2 py-1 text-red-600 hover:text-red-700" onclick="this.closest('tr').remove()">×</button>
          </td>
        `;
        tbody.appendChild(tr);
        // re-bind inc/dec for new row
        tr.querySelectorAll('.inc,.dec').forEach(btn=>{
          btn.addEventListener('click', ()=>{
            const el = document.getElementById(btn.dataset.target);
            let v = parseInt(el.value||0,10);
            if(btn.classList.contains('inc')) v++; else v = Math.max(0, v-1);
            el.value = v;
          });
        });
      }
    }
  }

  function renderWarehouseSelect(i){
    const has = {{ !empty($hasWarehouseCol) ? 'true' : 'false' }};
    if(!has){
      return `<span class="text-slate-600">{{ $headerWarehousePath }}</span>`;
    }
    const options = `@foreach($warehouseOptions as $wid => $label)<option value="{{ $wid }}">{{ $label }}</option>@endforeach`;
    return `<select name="rows[${i}][warehouse_id]" class="border rounded-md px-2 py-1 whSel" data-row-index="${i}"><option value="">— Choose —</option>${options}</select>`;
  }
</script>
@endsection
