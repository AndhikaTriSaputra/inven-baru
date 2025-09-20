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
            <form id="brandCreateForm" method="POST" action="{{ route('brands.store') }}" enctype="multipart/form-data">
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

<!-- Edit Modal -->
<div id="editBrandModal" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold">Edit</h3>
                <button id="closeEditBrandModal" class="text-gray-500 hover:text-gray-700">✕</button>
            </div>
            <form id="editBrandForm" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Brand Name *</label>
                        <input type="text" id="editBrandName" name="name" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-100" required>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Brand Description</label>
                        <textarea id="editBrandDescription" name="description" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-100"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Brand Image</label>
                        <input id="editBrandImage" name="image" type="file" accept="image/*" class="w-full text-sm">
                        <div class="mt-2">
                            <img id="editBrandImagePreview" src="" alt="preview" class="hidden w-20 h-20 rounded object-cover border">
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-end space-x-3">
                    <button type="button" id="cancelEditBrandModal" class="px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-full bg-violet-600 text-white hover:bg-violet-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Submit
                    </button>
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
                    <td class="py-3 px-4">
                        <button data-action="edit" data-id="${r.id}" data-name="${r.name}" data-description="${r.description}" data-image="${r.image || ''}" class="text-emerald-600 hover:text-emerald-500 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <button data-action="delete" data-id="${r.id}" class="text-red-600 hover:text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </td>
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
        const editModal = document.getElementById('editBrandModal');
        const openBtn = document.getElementById('openBrandModal');
        const closeBtn = document.getElementById('closeBrandModal');
        const cancelBtn = document.getElementById('cancelBrandModal');
        
        // Edit modal elements
        const closeEditBtn = document.getElementById('closeEditBrandModal');
        const cancelEditBtn = document.getElementById('cancelEditBrandModal');
        const form = document.getElementById('brandCreateForm');

        function open(){ modal.classList.remove('hidden'); }
        function close(){ modal.classList.add('hidden'); form.reset(); preview.classList.add('hidden'); preview.src=''; }
        function openEdit(id, name, description, image){
            document.getElementById('editBrandName').value = name;
            document.getElementById('editBrandDescription').value = description || '';
            document.getElementById('editBrandForm').action = `/app/brands/${id}`;
            if(image) {
                document.getElementById('editBrandImagePreview').src = image;
                document.getElementById('editBrandImagePreview').classList.remove('hidden');
            } else {
                document.getElementById('editBrandImagePreview').classList.add('hidden');
            }
            editModal.classList.remove('hidden');
        }
        function closeEdit(){ editModal.classList.add('hidden'); }
        
        openBtn.addEventListener('click', open);
        closeBtn.addEventListener('click', close);
        cancelBtn.addEventListener('click', close);
        closeEditBtn.addEventListener('click', closeEdit);
        cancelEditBtn.addEventListener('click', closeEdit);
        modal.addEventListener('click', (e)=>{ if(e.target===modal){ close(); }});
        editModal.addEventListener('click', (e)=>{ if(e.target===editModal){ closeEdit(); }});
        document.addEventListener('keydown', (e)=>{ 
            if(!modal.classList.contains('hidden') && e.key==='Escape'){ close(); }
            if(!editModal.classList.contains('hidden') && e.key==='Escape'){ closeEdit(); }
        });

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
        
        // Edit image preview
        const editInputImage = document.getElementById('editBrandImage');
        const editPreview = document.getElementById('editBrandImagePreview');
        editInputImage.addEventListener('change', ()=>{
            const file = editInputImage.files && editInputImage.files[0];
            if(!file){ return; }
            const reader = new FileReader();
            reader.onload = ()=>{ editPreview.src = reader.result; editPreview.classList.remove('hidden'); };
            reader.readAsDataURL(file);
        });
        
        // Delete function
        function deleteBrand(id) {
            if (!confirm('Are you sure you want to delete this brand?')) return;
            fetch(`/app/brands/${id}`, {
                method: 'DELETE',
                headers: { 
                    'Accept': 'application/json', 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            })
            .then(res => {
                if (!res.ok) throw new Error('Request failed');
                // remove from local table data and re-render
                const index = data.findIndex(d => d.id == id);
                if (index !== -1) {
                    data.splice(index, 1);
                }
                render();
            })
            .catch(err => {
                console.error(err);
                alert('Failed to delete brand');
            });
        }
        
        // Make functions globally accessible
        window.openEdit = openEdit;
        window.closeEdit = closeEdit;
        window.deleteBrand = deleteBrand;
        
        // Event delegation for action buttons
        tbody.addEventListener('click', function(e) {
            const button = e.target.closest('button[data-action]');
            if (!button) return;
            
            const action = button.getAttribute('data-action');
            const id = button.getAttribute('data-id');
            
            if (action === 'edit') {
                const name = button.getAttribute('data-name');
                const description = button.getAttribute('data-description');
                const image = button.getAttribute('data-image');
                openEdit(id, name, description, image);
            } else if (action === 'delete') {
                deleteBrand(id);
            }
        });
        
        // Edit form submission
        const editForm = document.getElementById('editBrandForm');
        if (editForm) {
            editForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(editForm);
                try {
                    const res = await fetch(editForm.action, {
                        method: 'POST',
                        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': editForm.querySelector('input[name="_token"]').value },
                        credentials: 'same-origin',
                        body: formData
                    });
                    if (!res.ok) throw new Error('Request failed');
                    const json = await res.json();
                    const updated = json.brand || {};
                    // update local table data and re-render
                    const index = data.findIndex(d => d.id == updated.id);
                    if (index !== -1) {
                        data[index] = { id: updated.id, name: updated.name || '', description: updated.description || '', image: updated.image || null };
                    }
                    render();
                    closeEdit();
                } catch (err) {
                    console.error(err);
                    alert('Failed to update brand');
                }
            });
        }
    })();
</script>
@endpush

