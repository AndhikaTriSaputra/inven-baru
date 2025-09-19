@extends('layouts.app')

@section('header')
All Adjustments
@endsection

@section('content')
<div class="bg-white border border-gray-200 rounded-lg p-6">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-baseline gap-3">
            <div class="text-2xl font-semibold">All Adjustments</div>
            <div class="text-sm text-slate-500">Adjustment | All Adjustments</div>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="document.getElementById('filterPanel').classList.remove('hidden')" class="px-3 py-2 border border-gray-300 rounded text-sm">Filter</button>
            <a href="{{ request()->fullUrlWithQuery(['export'=>'pdf']) }}" class="px-3 py-2 border border-emerald-200 text-emerald-600 rounded text-sm">PDF</a>
            <a href="{{ request()->fullUrlWithQuery(['export'=>'csv']) }}" class="px-3 py-2 border border-rose-200 text-rose-600 rounded text-sm">EXCEL</a>
            <a href="{{ route('adjustments.create') }}" class="px-4 py-2 bg-violet-600 text-white rounded-lg text-sm flex items-center gap-2">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14"/></svg>
                Create
            </a>
        </div>
    </div>
    <div class="flex items-center justify-between mb-3">
        <div class="relative w-64">
            <input id="tableSearch" type="text" class="w-full border rounded pl-9 pr-3 py-2 text-sm" placeholder="Search this table" />
            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"/></svg>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm border-separate" style="border-spacing:0">
            <thead>
                <tr class="border-b border-gray-200 bg-slate-50 sticky top-0">
                    <th class="py-2"><input type="checkbox"/></th>
                    <th class="text-left py-2 px-2">Date</th>
                    <th class="text-left py-2 px-2">Reference</th>
                    <th class="text-left py-2 px-2">Warehouse</th>
                    <th class="text-left py-2 px-2">Total Products</th>
                    <th class="text-left py-2 px-2">Action</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($adjustments as $a)
                <tr class="border-b border-gray-100 hover:bg-slate-50">
                    <td class="py-2 px-2"><input type="checkbox"/></td>
                    <td class="py-2 px-2 whitespace-nowrap">{{ $a->date }}</td>
                    <td class="py-2 px-2">{{ $a->Ref }}</td>
                    <td class="py-2 px-2 truncate max-w-[340px]" title="{{ $a->warehouse }}">{{ $a->warehouse }}</td>
                    <td class="py-2 px-2"><span class="inline-block text-xs px-2 py-1 rounded bg-slate-100">{{ number_format((float)$a->items,2) }}</span></td>
                    <td class="py-2 px-2 text-gray-500">
                        <div class="flex items-center gap-3">
                            <a title="Show" href="{{ route('adjustments.show',$a->id) }}" class="text-sky-600 hover:text-sky-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12z"/><circle cx="12" cy="12" r="2.25"/></svg>
                            </a>
                            <a title="Edit" href="{{ route('adjustments.edit',$a->id) }}" class="text-emerald-600 hover:text-emerald-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.25 2.25 0 013.182 3.182L7.5 19.313 3 21l1.687-4.5L16.862 3.487z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('adjustments.destroy',$a->id) }}" onsubmit="return confirm('Delete this adjustment?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete" class="text-rose-600 hover:text-rose-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2m1 0v12a2 2 0 01-2 2H8a2 2 0 01-2-2V7h12z"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td class="py-3" colspan="6">No data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{!! $adjustments->links('pagination::simple-tailwind') !!}</div>

    <div id="filterPanel" class="fixed inset-y-0 right-0 z-40 w-full max-w-sm bg-white border-l border-gray-200 shadow-xl hidden">
        <div class="flex items-center justify-between p-4 border-b">
            <div class="font-semibold">Filter</div>
            <button type="button" onclick="document.getElementById('filterPanel').classList.add('hidden')" class="text-slate-500">✕</button>
        </div>
        <form method="GET" action="{{ route('adjustments.index') }}" class="p-4 space-y-4">
            <div>
                <label class="block text-sm text-slate-600 mb-1">Date</label>
                <input type="date" name="date" value="{{ request('date') }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">Reference</label>
                <input type="text" name="ref" value="{{ request('ref') }}" class="w-full border rounded px-3 py-2" placeholder="Reference">
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">Warehouse</label>
                <select name="warehouse_id" class="w-full border rounded px-3 py-2">
                    <option value="">Choose Warehouse</option>
                    @foreach($warehouseOptions as $wid => $label)
                    <option value="{{ $wid }}" @selected(request('warehouse_id')==$wid)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button class="px-3 py-2 bg-violet-600 text-white rounded">Filter</button>
                <a href="{{ route('adjustments.index') }}" class="px-3 py-2 border rounded">Reset</a>
            </div>
        </form>
    </div>
</div>
@if(!empty($detailHeader))
  <!-- Inline Detail Modal -->
  <div class="fixed inset-0 flex items-start md:items-center justify-center z-[70]">
      <div class="absolute inset-0 bg-black/40 backdrop-blur-[1px]"></div>
      <div class="relative mt-20 md:mt-0 w-[92%] md:w-[720px] bg-white rounded-xl shadow-xl border border-gray-200">
          <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
              <div class="font-semibold text-gray-800">Adjustment Detail</div>
              <a href="{{ route('adjustments.index') }}" class="text-slate-400 hover:text-slate-600">✕</a>
          </div>
          <div class="px-6 py-5">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
                  <div>
                      <div class="text-xs text-slate-500">Date</div>
                      <div class="mt-1 font-medium">{{ \Carbon\Carbon::parse($detailHeader->date)->format('Y-m-d') }}</div>
                  </div>
                  <div>
                      <div class="text-xs text-slate-500">Reference</div>
                      <div class="mt-1 font-medium">{{ $detailHeader->Ref }}</div>
                  </div>
                  <div>
                      <div class="text-xs text-slate-500">Warehouse</div>
                      <div class="mt-1 font-medium">{{ $detailWarehousePath ?? '—' }}</div>
                  </div>
              </div>
              <div class="overflow-x-auto border border-gray-200 rounded-lg">
                  <table class="w-full text-sm">
                      <thead class="bg-slate-50">
                          <tr class="text-left">
                              <th class="px-4 py-2">Product</th>
                              <th class="px-4 py-2">Code Product</th>
                              <th class="px-4 py-2">Quantity</th>
                              <th class="px-4 py-2">Type</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($detailItems as $row)
                          <tr class="border-t">
                              <td class="px-4 py-2">{{ $row->name }}</td>
                              <td class="px-4 py-2">{{ $row->code }}</td>
                              <td class="px-4 py-2">{{ (int)$row->qty }} Pcs</td>
                              <td class="px-4 py-2">{{ $row->type }}</td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
              @if(!empty($detailHeader->notes))
              <div class="mt-5">
                  <div class="text-xs text-slate-500 mb-1">Note</div>
                  <div class="p-3 bg-slate-50 rounded border border-slate-200">{{ $detailHeader->notes }}</div>
              </div>
              @endif
          </div>
          <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-3">
              <a href="{{ route('adjustments.index') }}" class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50">OK</a>
              <a href="{{ route('adjustments.edit',$detailHeader->id) }}" class="px-4 py-2 bg-violet-600 text-white rounded-md hover:bg-violet-700">Edit</a>
          </div>
      </div>
  </div>
@endif
@endsection

@push('scripts')
<script>
  (function(){
    const input = document.getElementById('tableSearch');
    const body = document.getElementById('tableBody');
    if(!input || !body) return;
    input.addEventListener('input', function(){
      const q = (this.value||'').toLowerCase();
      body.querySelectorAll('tr').forEach(tr =>{
        const text = tr.innerText.toLowerCase();
        tr.style.display = text.includes(q) ? '' : 'none';
      });
    });
  })();
</script>
@endpush


