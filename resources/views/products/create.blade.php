@extends('layouts.app')

@section('header')
Create product
@endsection

@section('content')
<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if (session('status'))
    <div class="mb-6 rounded-lg border border-green-200 bg-green-50 text-green-800 px-4 py-3">
        {{ session('status') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3">
        <div class="font-medium mb-1">Please fix the following:</div>
        <ul class="list-disc ml-5 text-sm space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-base font-semibold mb-4">Basic Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border-gray-300 px-3 py-2.5 focus:border-violet-500 focus:ring-2 focus:ring-violet-200 placeholder-gray-400" placeholder="e.g. Apple iPhone 15" required />
                    @error('name')
                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Barcode Symbology <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="barcode_symbology" class="w-full rounded-lg border-gray-300 px-3 py-2.5 pr-10 appearance-none focus:border-violet-500 focus:ring-2 focus:ring-violet-200" required>
                            <option value="">Choose Symbology…</option>
                            <option value="code128" {{ old('barcode_symbology')=='code128' ? 'selected' : '' }}>Code 128</option>
                            <option value="ean13" {{ old('barcode_symbology')=='ean13' ? 'selected' : '' }}>EAN-13</option>
                            <option value="upca" {{ old('barcode_symbology')=='upca' ? 'selected' : '' }}>UPC-A</option>
                        </select>
                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.186l3.71-3.955a.75.75 0 111.08 1.04l-4.24 4.52a.75.75 0 01-1.08 0L5.25 8.27a.75.75 0 01-.02-1.06z" clip-rule="evenodd"/></svg>
                        </span>
                    </div>
                    @error('barcode_symbology')
                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Product Code <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="text" name="code" value="{{ old('code') }}" class="w-full rounded-lg border-gray-300 px-3 py-2.5 pr-10 focus:border-violet-500 focus:ring-2 focus:ring-violet-200" placeholder="Scan or type code" required />
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M3 6h18v2H3V6zm0 5h18v2H3v-2zm0 5h18v2H3v-2z"/></svg>
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Scan your barcode and ensure the symbology matches.</p>
                    @error('code')
                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Category <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="category_id" class="w-full rounded-lg border-gray-300 px-3 py-2.5 pr-10 appearance-none focus:border-violet-500 focus:ring-2 focus:ring-violet-200" required>
                            <option value="">Choose Category…</option>
                            @isset($categories)
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.186l3.71-3.955a.75.75 0 111.08 1.04l-4.24 4.52a.75.75 0 01-1.08 0L5.25 8.27a.75.75 0 01-.02-1.06z" clip-rule="evenodd"/></svg>
                        </span>
                    </div>
                    @error('category_id')
                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Brand</label>
                    <div class="relative">
                        <select name="brand_id" class="w-full rounded-lg border-gray-300 px-3 py-2.5 pr-10 appearance-none focus:border-violet-500 focus:ring-2 focus:ring-violet-200">
                            <option value="">Choose Brand…</option>
                            @isset($brands)
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id')==$brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.186l3.71-3.955a.75.75 0 111.08 1.04l-4.24 4.52a.75.75 0 01-1.08 0L5.25 8.27a.75.75 0 01-.02-1.06z" clip-rule="evenodd"/></svg>
                        </span>
                    </div>
                    @error('brand_id')
                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Project</label>
                    <div class="relative">
                        <select name="project_id" class="w-full rounded-lg border-gray-300 px-3 py-2.5 pr-10 appearance-none focus:border-violet-500 focus:ring-2 focus:ring-violet-200">
                            <option value="">Choose Project…</option>
                            @isset($projects)
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id')==$project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.186l3.71-3.955a.75.75 0 111.08 1.04l-4.24 4.52a.75.75 0 01-1.08 0L5.25 8.27a.75.75 0 01-.02-1.06z" clip-rule="evenodd"/></svg>
                        </span>
                    </div>
                    @error('project_id')
                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Tags</label>
                    <div class="relative">
                        <div id="tagsChips" class="min-h-[44px] w-full rounded-lg border border-gray-300 px-2 py-1.5 flex flex-wrap gap-1 focus-within:ring-2 focus-within:ring-violet-200 focus-within:border-violet-500">
                            <input id="tagsSearch" type="text" class="flex-1 min-w-[8rem] border-0 focus:ring-0 px-2 py-1 text-sm placeholder-gray-400" placeholder="Type to search..." />
                        </div>
                        <div id="tagsMenu" class="absolute left-0 right-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg p-2 z-10 hidden">
                            <ul id="tagsList" class="max-h-48 overflow-auto text-sm divide-y divide-gray-100"></ul>
                            <div class="px-2 pt-2 text-xs text-gray-400">Press Enter to add highlighted</div>
                        </div>
                        <select id="tagsSelect" name="tags[]" multiple class="hidden">
                            @isset($tags)
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" @if(collect(old('tags'))->contains($tag->id)) selected @endif>{{ $tag->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                        @error('tags')
                        <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-base font-semibold mb-4">Inventory & Type</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Type <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="type" class="w-full rounded-lg border-gray-300 px-3 py-2.5 pr-10 appearance-none focus:border-violet-500 focus:ring-2 focus:ring-violet-200" required>
                            <option value="standard" {{ old('type','standard')=='standard' ? 'selected' : '' }}>Standard Product</option>
                            <option value="service" {{ old('type')=='service' ? 'selected' : '' }}>Service</option>
                        </select>
                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.186l3.71-3.955a.75.75 0 111.08 1.04l-4.24 4.52a.75.75 0 01-1.08 0L5.25 8.27a.75.75 0 01-.02-1.06z" clip-rule="evenodd"/></svg>
                        </span>
                    </div>
                    @error('type')
                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Product Unit <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="product_unit_id" class="w-full rounded-lg border-gray-300 px-3 py-2.5 pr-10 appearance-none focus:border-violet-500 focus:ring-2 focus:ring-violet-200" required>
                            <option value="">Choose Product Unit…</option>
                            @isset($units)
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}" {{ old('product_unit_id')==$unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.186l3.71-3.955a.75.75 0 111.08 1.04l-4.24 4.52a.75.75 0 01-1.08 0L5.25 8.27a.75.75 0 01-.02-1.06z" clip-rule="evenodd"/></svg>
                        </span>
                    </div>
                    @error('product_unit_id')
                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Stock Alert</label>
                    <input type="number" name="stock_alert" class="w-full rounded-lg border-gray-300 px-3 py-2.5 focus:border-violet-500 focus:ring-2 focus:ring-violet-200" value="{{ old('stock_alert', 0) }}" min="0" />
                    <p class="text-xs text-gray-500 mt-2">We’ll notify when stock reaches this threshold.</p>
                    @error('stock_alert')
                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-violet-600 text-white shadow-sm hover:bg-violet-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5v14m-7-7h14"/></svg>
                    Submit
                </button>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="font-medium mb-4">Multiple Image</h3>
            <div id="dropzone" class="border-2 border-dashed border-gray-300 rounded-xl h-64 flex items-center justify-center text-center p-6 transition-colors">
                <div>
                    <div class="mx-auto mb-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5v14m-7-7h14"/></svg>
                    </div>
                    <p class="text-sm text-gray-600">Drag & Drop images here</p>
                    <p class="text-xs text-gray-400 mt-1">or</p>
                    <label for="images" class="inline-block mt-2 px-4 py-2 rounded-lg bg-violet-600 text-white cursor-pointer hover:bg-violet-700">Select files</label>
                    <input id="images" name="images[]" type="file" accept="image/*" multiple class="sr-only" />
                    @error('images')
                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div id="preview" class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3"></div>
        </div>
    </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('images');
    const dropzone = document.getElementById('dropzone');
    const preview = document.getElementById('preview');
    // Tags chips/select
    const tagsSelect = document.getElementById('tagsSelect');
    const tagsChips = document.getElementById('tagsChips');
    const tagsSearch = document.getElementById('tagsSearch');
    const tagsMenu = document.getElementById('tagsMenu');
    const tagsList = document.getElementById('tagsList');

    function renderPreviews(files) {
        preview.innerHTML = '';
        Array.from(files).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = file.name;
                img.className = 'w-full h-28 object-cover rounded-lg border';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }

    input.addEventListener('change', (e) => {
        renderPreviews(e.target.files);
    });

    ['dragenter','dragover'].forEach(evt => dropzone.addEventListener(evt, (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropzone.classList.add('border-violet-400','bg-violet-50');
    }));
    ['dragleave','drop'].forEach(evt => dropzone.addEventListener(evt, (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropzone.classList.remove('border-violet-400','bg-violet-50');
    }));
    dropzone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        if (!dt) return;
        const files = dt.files;
        input.files = files;
        renderPreviews(files);
    });

    // Helpers for tags UI
    function getAllOptions() {
        return Array.from(tagsSelect.options).map(o => ({ id: o.value, name: o.text, selected: o.selected }));
    }
    function renderChips() {
        // remove existing chips except the input
        Array.from(tagsChips.querySelectorAll('[data-chip]')).forEach(el => el.remove());
        getAllOptions().filter(o => o.selected).forEach(opt => {
            const chip = document.createElement('span');
            chip.dataset.chip = '1';
            chip.className = 'inline-flex items-center gap-1 bg-violet-50 text-violet-700 border border-violet-200 px-2 py-0.5 rounded-full text-xs';
            chip.innerHTML = `<span>${opt.name}</span>`;
            const closeBtn = document.createElement('button');
            closeBtn.type = 'button';
            closeBtn.className = 'text-violet-600 hover:text-violet-800';
            closeBtn.innerHTML = '&times;';
            closeBtn.addEventListener('click', () => {
                const option = Array.from(tagsSelect.options).find(o => o.value === opt.id);
                if (option) option.selected = false;
                renderChips();
                renderMenu(tagsSearch.value);
            });
            chip.appendChild(closeBtn);
            tagsChips.insertBefore(chip, tagsSearch);
        });
    }
    function renderMenu(query='') {
        const q = query.toLowerCase().trim();
        const options = getAllOptions().filter(o => !o.selected && (!q || o.name.toLowerCase().includes(q)));
        tagsList.innerHTML = '';
        if (options.length === 0) {
            const li = document.createElement('li');
            li.className = 'px-2 py-2 text-gray-400';
            li.textContent = 'No matches';
            tagsList.appendChild(li);
            return;
        }
        options.forEach((opt, idx) => {
            const li = document.createElement('li');
            li.tabIndex = 0;
            li.dataset.id = opt.id;
            li.className = 'px-2 py-2 hover:bg-violet-50 cursor-pointer';
            li.textContent = opt.name;
            li.addEventListener('click', () => selectTag(opt.id));
            if (idx === 0) li.classList.add('bg-violet-50');
            tagsList.appendChild(li);
        });
    }
    function selectTag(id) {
        const option = Array.from(tagsSelect.options).find(o => o.value === id);
        if (option) option.selected = true;
        tagsSearch.value = '';
        renderChips();
        renderMenu('');
        hideMenu();
        tagsSearch.focus();
    }
    function showMenu() { tagsMenu.classList.remove('hidden'); }
    function hideMenu() { tagsMenu.classList.add('hidden'); }

    tagsSearch.addEventListener('focus', () => { renderMenu(tagsSearch.value); showMenu(); });
    tagsSearch.addEventListener('input', () => { renderMenu(tagsSearch.value); showMenu(); });
    tagsSearch.addEventListener('keydown', (e) => {
        const items = Array.from(tagsList.querySelectorAll('li'));
        const current = items.findIndex(li => li.classList.contains('bg-violet-50'));
        if (e.key === 'ArrowDown') { e.preventDefault(); if (items.length) { if (current>=0) items[current].classList.remove('bg-violet-50'); const next = items[Math.min(current+1, items.length-1)]; next.classList.add('bg-violet-50'); next.scrollIntoView({block:'nearest'}); } }
        if (e.key === 'ArrowUp') { e.preventDefault(); if (items.length) { if (current>=0) items[current].classList.remove('bg-violet-50'); const prev = items[Math.max(current-1, 0)]; prev.classList.add('bg-violet-50'); prev.scrollIntoView({block:'nearest'}); } }
        if (e.key === 'Enter') { e.preventDefault(); const focused = items.find(li => li.classList.contains('bg-violet-50')); if (focused) selectTag(focused.dataset.id); }
        if (e.key === 'Escape') { hideMenu(); }
    });
    document.addEventListener('click', (e) => {
        if (!tagsChips.contains(e.target) && !tagsMenu.contains(e.target)) hideMenu();
    });
    // initial render for old values
    renderChips();
});
</script>
@endpush



