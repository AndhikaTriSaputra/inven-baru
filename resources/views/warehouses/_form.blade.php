@php
  $isEdit = isset($warehouse);
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
  <div>
    <label class="block text-sm text-slate-600 mb-1">Name *</label>
    <input type="text" name="name" required class="w-full border rounded-lg px-3 py-2"
           value="{{ old('name', $warehouse->name ?? '') }}">
    @error('name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm text-slate-600 mb-1">Parent</label>
    <select name="parent_id" class="w-full border rounded-lg px-3 py-2">
      <option value="">— None —</option>
      @foreach($parents as $p)
        <option value="{{ $p->id }}"
          @selected(old('parent_id', $warehouse->parent_id ?? null) == $p->id)>
          {{ $p->name }}
        </option>
      @endforeach
    </select>
    @error('parent_id') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm text-slate-600 mb-1">Phone</label>
    <input type="text" name="mobile" class="w-full border rounded-lg px-3 py-2"
           value="{{ old('mobile', $warehouse->mobile ?? '') }}">
    @error('mobile') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm text-slate-600 mb-1">Email</label>
    <input type="email" name="email" class="w-full border rounded-lg px-3 py-2"
           value="{{ old('email', $warehouse->email ?? '') }}">
    @error('email') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="block text-sm text-slate-600 mb-1">Country</label>
    <input type="text" name="country" class="w-full border rounded-lg px-3 py-2"
           value="{{ old('country', $warehouse->country ?? '') }}">
  </div>

  <div>
    <label class="block text-sm text-slate-600 mb-1">City</label>
    <input type="text" name="city" class="w-full border rounded-lg px-3 py-2"
           value="{{ old('city', $warehouse->city ?? '') }}">
  </div>

  <div class="md:col-span-2">
    <label class="block text-sm text-slate-600 mb-1">Zip Code</label>
    <input type="text" name="zip" class="w-full border rounded-lg px-3 py-2"
           value="{{ old('zip', $warehouse->zip ?? '') }}">
  </div>
</div>

<div class="mt-6 flex items-center gap-2">
  <a href="{{ route('warehouses.index') }}" class="px-4 py-2 border rounded-lg">Cancel</a>
  <button class="px-4 py-2 bg-violet-600 text-white rounded-lg">
    {{ $isEdit ? 'Update' : 'Create' }}
  </button>
</div>
