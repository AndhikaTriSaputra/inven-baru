edit

@extends('layouts.app')

@section('header')
Edit Purchase
@endsection

@section('content')
<form action="{{ route('purchases.update',$purchase->id) }}" method="POST" enctype="multipart/form-data" class="bg-white border border-gray-200 rounded-xl p-6">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date <span class="text-red-500">*</span></label>
                    <input type="date" name="date" value="{{ old('date', \Illuminate\Support\Carbon::parse($purchase->date)->format('Y-m-d')) }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Supplier <span class="text-red-500">*</span></label>
                    <select name="provider_id" class="w-full border rounded-lg px-3 py-2">
                        <option value="">Choose Supplier</option>
                        @foreach($providers as $p)
                            <option value="{{ $p->id }}" @selected(old('provider_id',$purchase->provider_id)==$p->id)>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Warehouse <span class="text-red-500">*</span></label>
                    <select id="warehouse_id" name="warehouse_id" class="w-full border rounded-lg px-3 py-2">
                        <option value="">Choose Warehouse</option>
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}" @selected(old('warehouse_id',$purchase->warehouse_id)==$w->id)>{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
<select name="status" class="w-full border rounded-lg px-3 py-2" required>
    <option value="received" @selected(old('status', $purchase->statut) == 'received')>received</option>
    <option value="pending" @selected(old('status', $purchase->statut) == 'pending')>pending</option>
    <option value="ordered" @selected(old('status', $purchase->statut) == 'ordered')>ordered</option>
</select>



</div>


            <div>
  <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
  <select name="category_id" class="w-full border rounded-lg px-3 py-2" required>
      <option value="">Choose Category</option>
      @foreach($categories as $c)
        <option value="{{ $c->id }}" @selected(old('category_id',$purchase->category_id??null)==$c->id)>
          {{ $c->name }}
        </option>
      @endforeach
  </select>
</div>


            <div>
                <div class="text-sm font-medium text-gray-700 mb-2">Order items</div>
                <div class="overflow-x-auto border border-gray-200 rounded-lg">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr class="text-left">
                                <th class="px-3 py-2">#</th>
                                <th class="px-3 py-2">Product</th>
                                <th class="px-3 py-2">Current Stock</th>
                                <th class="px-3 py-2">Qty</th>
                                <th class="px-3 py-2">Unit</th>
                                <th class="px-3 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($details as $idx => $row)
                            <tr>
                                <td class="px-3 py-2">{{ $idx+1 }}</td>
                                <td class="px-3 py-2">
                                    <div class="font-medium">{{ $row->product_name ?? ('#'.$row->product_id) }}</div>
                                    <div class="text-xs text-gray-500">{{ $row->product_code ?? '' }}</div>
                                </td>
                                <td class="px-3 py-2">{{ (float)($stocks[$row->product_id] ?? 0) }} {{ $row->unit ?? 'Pcs' }}</td>
                                <td class="px-3 py-2">
                                    <div class="inline-flex items-center border rounded">
                                        <button type="button" class="px-2 py-1" onclick="this.nextElementSibling.stepDown()">-</button>
                                        <input type="number" step="0.0001" min="0" value="{{ (float)$row->quantity }}" class="w-20 px-2 py-1 border-l border-r">
                                        <button type="button" class="px-2 py-1" onclick="this.previousElementSibling.stepUp()">+</button>
                                    </div>
                                </td>
                                <td class="px-3 py-2">{{ $row->unit ?? 'Pcs' }}</td>
                                <td class="px-3 py-2">
                                    <button type="button" class="text-emerald-600" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-8.5 8.5A2 2 0 016.172 16H4a1 1 0 01-1-1v-2.172a2 2 0 01.586-1.414l8.5-8.5z"/><path d="M15 7l-2-2"/></svg></button>
                                    <button type="button" class="text-rose-600 ml-2" title="Remove"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 100 2h12a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0010 2H9zM5 8a1 1 0 011 1v6a1 1 0 102 0V9a1 1 0 112 0v6a1 1 0 102 0V9a1 1 0 112 0v6a3 3 0 01-3 3H8a3 3 0 01-3-3V9a1 1 0 010-1z" clip-rule="evenodd"/></svg></button>
                                </td>
                            </tr>
                            @empty
                            <tr><td class="px-3 py-4 text-center text-gray-500" colspan="6">No items</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Note</label>
                <textarea name="notes" rows="4" class="w-full border rounded-lg px-3 py-2" placeholder="A few words ...">{{ old('notes', $purchase->notes) }}</textarea>
            </div>

            <div>
                <button type="submit" class="px-5 py-2 rounded-lg bg-violet-600 text-white">Submit</button>
            </div>
        </div>

        <div>
            <div class="border border-gray-200 rounded-xl p-4">
                <div class="font-semibold mb-3">Upload Image</div>
                @php $currentImage = $purchase->image ?? null; @endphp
                @if(!empty($currentImage))
                    <div class="mb-3">
                        <img src="{{ asset('images/purchases/'.$currentImage) }}" alt="Purchase Image" class="max-w-full rounded border">
                    </div>
                @else
                    <div class="mb-3 text-sm text-gray-500">No image uploaded.</div>
                @endif
                <div class="border-2 border-dashed rounded-lg p-6 text-center text-sm text-gray-500">Drag & drop single image here or
                    <label class="inline-block ml-2 px-3 py-1 rounded bg-violet-600 text-white cursor-pointer">
                        Select Image
                        <input id="purchaseImageEdit" type="file" class="hidden" accept="image/*" name="image" />
                    </label>
                </div>
                <div id="purchaseImagePreviewEdit" class="mt-3 {{ empty($currentImage) ? 'hidden' : '' }}">
                    @if(!empty($currentImage))
                        <img src="{{ asset('images/purchases/'.$currentImage) }}" alt="Preview" class="max-w-full rounded border">
                    @else
                        <img src="#" alt="Preview" class="max-w-full rounded border">
                    @endif
                </div>
                @if(!empty($currentImage))
                    <div class="mt-3">
                        <label class="inline-flex items-center gap-2 text-sm text-rose-600">
                            <input type="checkbox" name="remove_image" value="1" class="rounded"> Remove current image
                        </label>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @error('image')
    <div class="mt-4 text-red-600 text-sm">{{ $message }}</div>
    @enderror
</form>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const input = document.getElementById('purchaseImageEdit');
    const wrap = document.getElementById('purchaseImagePreviewEdit');
    const img = wrap ? wrap.querySelector('img') : null;
    if (input && wrap && img){
        input.addEventListener('change', function(){
            const file = this.files && this.files[0];
            if (!file) { return; }
            const reader = new FileReader();
            reader.onload = function(e){
                img.src = e.target.result;
                wrap.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });
    }
});
</script>
@endpush
@endsection