@extends('layouts.app')

@section('header')
Create Adjustment
@endsection

@section('content')
<div class="bg-white border border-gray-200 rounded-lg p-6">
    <form method="POST" action="{{ route('adjustments.store') }}" class="space-y-4" x-data="createAdj()">
        @csrf
        <div>
            <label class="block text-sm text-gray-600 mb-1">Reference</label>
            <input type="text" name="Ref" value="{{ old('Ref',$nextRef ?? '') }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Date</label>
            <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Warehouse</label>
            <select name="warehouse_id" class="w-full border rounded px-3 py-2" required>
                <option value="">Choose Warehouse</option>
                @foreach($warehouseOptions as $id => $label)
                <option value="{{ $id }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Product</label>
            <div class="relative">
              <input x-model="query" @focus="open=true; if(results.length===0) preload();" @input="search" type="text" placeholder="Scan/Search Product by Code Or Name" class="w-full border rounded px-3 py-2 pl-10">
              <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"/></svg>
              <div x-show="open" @click.outside="open=false" class="absolute z-50 left-0 right-0 bg-white border rounded-lg mt-1 shadow-lg max-h-64 overflow-y-auto overflow-x-hidden whitespace-nowrap">
                <template x-for="item in results" :key="item.id">
                  <button type="button" class="w-full flex items-center gap-3 px-3 py-2 hover:bg-slate-50 text-left">
                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"/></svg>
                    <span class="truncate" x-text="item.label"></span>
                  </button>
                </template>
                <div x-show="results.length===0" class="px-3 py-2 text-sm text-slate-500">No results</div>
              </div>
            </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-sm">
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
            <tbody id="rowsTbody">
              <tr><td colspan="8" class="py-3 text-slate-400 text-center" x-show="rows.length===0">No data Available</td></tr>
              <template x-for="(row, i) in rows" :key="row.key">
                <tr class="border-b">
                  <td class="py-2 px-2" x-text="i+1"></td>
                  <td class="px-2" x-text="row.code||''"></td>
                  <td class="px-2" x-text="row.name"></td>
                  <td class="px-2">
                    <template x-if="hasWarehouseCol">
                      <select class="border rounded-md px-2 py-1" :name="`rows[${i}][warehouse_id]`" x-model="row.warehouse_id">
                        <option value="">— Choose —</option>
                        @foreach($warehouseOptions as $wid => $label)
                          <option value="{{ $wid }}">{{ $label }}</option>
                        @endforeach
                      </select>
                    </template>
                    <template x-if="!hasWarehouseCol">
                      <span class="text-slate-600">Header Warehouse</span>
                    </template>
                  </td>
                  <td class="px-2"><span class="inline-block text-xs px-2 py-1 rounded bg-violet-50 text-violet-600">0 Pcs</span></td>
                  <td class="px-2">
                    <div class="flex items-center">
                      <button type="button" class="px-2 py-1 border rounded-l" @click="dec(i)">-</button>
                      <input type="number" min="0" class="w-14 text-center border-t border-b py-1" :name="`rows[${i}][qty]`" x-model.number="row.qty">
                      <button type="button" class="px-2 py-1 border rounded-r" @click="inc(i)">+</button>
                    </div>
                  </td>
                  <td class="px-2">
                    <select class="border rounded-md px-2 py-1" :name="`rows[${i}][type]`" x-model="row.type">
                      <option value="Addition">Addition</option>
                      <option value="Subtraction">Subtraction</option>
                    </select>
                  </td>
                  <td class="px-2">
                    <input type="hidden" :name="`rows[${i}][product_id]`" x-model="row.product_id">
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Notes</label>
            <textarea name="notes" class="w-full border rounded px-3 py-2" rows="3">{{ old('notes') }}</textarea>
        </div>
        <div class="flex justify-end gap-2">
            <a href="{{ route('adjustments.index') }}" class="px-3 py-2 border rounded">Cancel</a>
            <button type="submit" class="px-3 py-2 bg-violet-600 text-white rounded">Save</button>
        </div>
    </form>
</div>
@endsection

<script>
  function createAdj(){
    return {
      query:'', open:false, results:[], rows:[], hasWarehouseCol: {{ !empty($hasWarehouseCol) ? 'true' : 'false' }},
      _timer:null,
      async search(){
        this.open = true;
        clearTimeout(this._timer);
        this._timer = setTimeout(async ()=>{
          try{
            const base = `{{ route('adjustments.productSearch') }}`;
            const url = (this.query && this.query.length>=1) ? `${base}?q=${encodeURIComponent(this.query)}` : `${base}?limit=30`;
            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            if(!res.ok){ this.results = []; return; }
            const data = await res.json().catch(()=>[]);
            this.results = Array.isArray(data) ? data : [];
          }catch(e){ this.results = []; }
        },250);
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
        this.open=false; this.query='';
        this.rows.push({ key: Date.now()+Math.random(), product_id:item.id, code:item.code, name:item.name, warehouse_id:'', qty:0, type:'Addition' });
      },
      inc(i){ this.rows[i].qty = (this.rows[i].qty||0)+1; },
      dec(i){ this.rows[i].qty = Math.max(0,(this.rows[i].qty||0)-1); }
    }
  }
</script>




