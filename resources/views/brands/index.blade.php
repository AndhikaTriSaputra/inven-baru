@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Brand</h1>
            <div class="text-sm text-gray-500">Products / Brand</div>
        </div>
        <button id="openBrandModal" type="button" class="px-4 py-2 rounded-full bg-violet-600 text-white hover:bg-violet-500">Create</button>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="px-4 py-4 border-b border-gray-100 flex items-center space-x-3">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-gray-400"><path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 015.364 10.845l3.77 3.77a.75.75 0 11-1.06 1.06l-3.77-3.77A6.75 6.75 0 1110.5 3.75zm0 1.5a5.25 5.25 0 100 10.5 5.25 5.25 0 000-10.5z" clip-rule="evenodd"/></svg>
            <input id="searchInput" type="text" placeholder="Search this table" class="w-80 rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-100">
        </div>

        <table id="brandTable" class="w-full">
            <thead class="bg-gray-50 text-sm">
                <tr>
                    <th class="w-12 py-3 px-4"></th>
                    <th class="py-3 px-4 text-left font-semibold text-gray-700">Brand Image</th>
                    <th data-key="name" class="py-3 px-4 text-left font-semibold text-gray-700 cursor-pointer select-none">Brand Name</th>
                    <th data-key="description" class="py-3 px-4 text-left font-semibold text-gray-700 cursor-pointer select-none">Brand Description</th>
                    <th class="py-3 px-4 text-left font-semibold text-gray-700">Action</th>
                </tr>
            </thead>
            <tbody id="brandTableBody" class="text-sm">
                <tr><td colspan="5" class="py-8 text-center text-gray-500">No data Available</td></tr>
            </tbody>
        </table>

        <div class="px-4 py-3 border-t border-gray-100 flex items-center justify-between text-sm text-gray-600">
            <div class="flex items-center space-x-2">
                <span>Rows per page:</span>
                <select id="rowsPerPage" class="rounded-md border border-gray-300 px-2 py-1 focus:border-violet-500 focus:ring-1 focus:ring-violet-100">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
            <div class="flex items-center space-x-4">
                <span id="pageText">0 - 0 of 0</span>
                <button id="prevBtn" class="text-gray-500 hover:text-gray-700" aria-label="prev">prev</button>
                <button id="nextBtn" class="text-gray-700 font-medium hover:text-gray-900" aria-label="next">next</button>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Modal -->
<div id="brandModal" class="hidden fixed inset-0 z-40">
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="relative z-50 max-w-md w-full mx-auto mt-24">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Create Brand</h3>
                <button id="closeBrandModal" class="text-gray-500 hover:text-gray-700">✕</button>
            </div>
            <form id="brandCreateForm" method="POST" action="{{ route('products.brands.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Brand Name <span class="text-red-500">*</span></label>
                        <input name="name" type="text" placeholder="Enter Name Brand" class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-100" required>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Brand Description</label>
                        <textarea name="description" rows="3" placeholder="Enter Description Brand" class="w-full rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-100"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Brand Image</label>
                        <input id="brandImage" name="image" type="file" accept="image/*" class="w-full text-sm">
                        <div class="mt-2">
                            <img id="brandImagePreview" src="" alt="preview" class="hidden w-20 h-20 rounded object-cover border">
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center space-x-3">
                    <button type="submit" class="px-4 py-2 rounded-full bg-violet-600 text-white hover:bg-violet-500">Save</button>
                    <button type="button" id="cancelBrandModal" class="px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-gray-50">Cancel</button>
                </div>
            </form>
        </div>
    </div>
  </div>

@push('scripts')
<script>
    (function(){
        const raw = @json(($brands ?? []));
        const data = (raw || []).map(r => ({
            id: r.id,
            image: r.image || null,
            name: r.name || '',
            description: r.description || ''
        }));

        let sortKey = 'name';
        let sortAsc = true;
        let page = 1;
        let pageSize = 10;
        let term = '';

        const tbody = document.getElementById('brandTableBody');
        const rowsPerPage = document.getElementById('rowsPerPage');
        const pageText = document.getElementById('pageText');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const searchInput = document.getElementById('searchInput');

        function getFiltered(){
            if (!term) return [...data];
            const t = term.toLowerCase();
            return data.filter(d => (d.name + ' ' + d.description).toLowerCase().includes(t));
        }
        function sortData(arr){
            return arr.sort((a,b)=>{
                const va = a[sortKey] ?? '';
                const vb = b[sortKey] ?? '';
                if (va < vb) return sortAsc ? -1 : 1;
                if (va > vb) return sortAsc ? 1 : -1;
                return 0;
            });
        }
        function render(){
            const filtered = sortData(getFiltered());
            tbody.innerHTML = '';
            if (!filtered.length){
                tbody.innerHTML = '<tr><td colspan="5" class="py-8 text-center text-gray-500">No data Available</td></tr>';
                pageText.textContent = '0 - 0 of 0';
                return;
            }
            const start = (page-1)*pageSize;
            const end = Math.min(start + pageSize, filtered.length);
            for(let i=start;i<end;i++){
                const r = filtered[i];
                const tr = document.createElement('tr');
                tr.className = 'border-b border-gray-100';
                tr.innerHTML = `
                    <td class="py-3 px-4"><input type="checkbox" class="rounded"></td>
                    <td class="py-3 px-4">${r.image ? `<img src="${r.image}" alt="brand" class="w-10 h-10 rounded object-cover">` : `<div class=\"w-10 h-10 rounded bg-gray-100 border border-dashed flex items-center justify-center text-gray-400\">\uD83D\uDDBC\uFE0F</div>`}</td>
                    <td class="py-3 px-4 text-gray-700">${r.name}</td>
                    <td class="py-3 px-4 text-gray-700">${r.description}</td>
                    <td class="py-3 px-4"><a href="/products/brands/${r.id}/edit" class="text-emerald-600 hover:text-emerald-500">Edit</a></td>
                `;
                tbody.appendChild(tr);
            }
            pageText.textContent = `${start+1} - ${end} of ${filtered.length}`;
            prevBtn.disabled = page===1;
            nextBtn.disabled = end >= filtered.length;
        }

        document.querySelectorAll('#brandTable thead th[data-key]').forEach(th=>{
            th.addEventListener('click', ()=>{
                const key = th.getAttribute('data-key');
                if (sortKey === key){ sortAsc = !sortAsc; } else { sortKey = key; sortAsc = true; }
                page = 1;
                render();
            });
        });
        rowsPerPage.addEventListener('change', ()=>{ pageSize = parseInt(rowsPerPage.value,10)||10; page=1; render(); });
        prevBtn.addEventListener('click', ()=>{ if(page>1){ page--; render(); }});
        nextBtn.addEventListener('click', ()=>{ page++; render(); });
        searchInput.addEventListener('input', ()=>{ term = searchInput.value || ''; page=1; render(); });

        render();

        // Modal logic
        const modal = document.getElementById('brandModal');
        const openBtn = document.getElementById('openBrandModal');
        const closeBtn = document.getElementById('closeBrandModal');
        const cancelBtn = document.getElementById('cancelBrandModal');
        const form = document.getElementById('brandCreateForm');

        function open(){ modal.classList.remove('hidden'); }
        function close(){ modal.classList.add('hidden'); form.reset(); preview.classList.add('hidden'); preview.src=''; }
        openBtn.addEventListener('click', open);
        closeBtn.addEventListener('click', close);
        cancelBtn.addEventListener('click', close);
        modal.addEventListener('click', (e)=>{ if(e.target===modal){ close(); }});
        document.addEventListener('keydown', (e)=>{ if(!modal.classList.contains('hidden') && e.key==='Escape'){ close(); }});

        form.addEventListener('submit', async (e)=>{
            e.preventDefault();
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value, 'Accept':'application/json' },
                body: formData
            });
            if(!response.ok){
                // naive error show
                alert('Failed to create brand');
                return;
            }
            const json = await response.json();
            if(json && json.brand){
                data.push(json.brand);
                // reset to first page to see new item at end only if sorting places it
                page = 1;
                render();
                close();
            }
        });

        // Image preview
        const inputImage = document.getElementById('brandImage');
        const preview = document.getElementById('brandImagePreview');
        inputImage.addEventListener('change', ()=>{
            const file = inputImage.files && inputImage.files[0];
            if(!file){ preview.classList.add('hidden'); preview.src=''; return; }
            const reader = new FileReader();
            reader.onload = ()=>{ preview.src = reader.result; preview.classList.remove('hidden'); };
            reader.readAsDataURL(file);
        });
    })();
</script>
@endpush

