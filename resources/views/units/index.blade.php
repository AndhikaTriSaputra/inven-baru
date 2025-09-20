@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Units</h1>
            <div class="text-sm text-gray-500">Products / Units</div>
        </div>
        <button id="openCreateModal" class="px-4 py-2 rounded-full bg-violet-600 text-white hover:bg-violet-500">Create</button>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="px-4 py-4 border-b border-gray-100 flex items-center space-x-3">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-gray-400"><path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 015.364 10.845l3.77 3.77a.75.75 0 11-1.06 1.06l-3.77-3.77A6.75 6.75 0 1110.5 3.75zm0 1.5a5.25 5.25 0 100 10.5 5.25 5.25 0 000-10.5z" clip-rule="evenodd"/></svg>
            <input id="searchInput" type="text" placeholder="Search this table" class="w-80 rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-100">
        </div>

        <table id="unitTable" class="w-full">
            <thead class="bg-gray-50 text-sm">
                <tr>
                    <th class="w-12 py-3 px-4"></th>
                    <th data-key="name" class="py-3 px-4 text-left font-semibold text-gray-700 cursor-pointer select-none">Unit Name</th>
                    <th data-key="short_name" class="py-3 px-4 text-left font-semibold text-gray-700 cursor-pointer select-none">Short Name</th>
                    <th class="py-3 px-4 text-left font-semibold text-gray-700">Action</th>
                </tr>
            </thead>
            <tbody id="unitTableBody" class="text-sm">
                <tr><td colspan="4" class="py-8 text-center text-gray-500">No data Available</td></tr>
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

    <!-- Create Modal -->
    <div id="createModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-semibold">Create Unit</h3>
                    <button id="closeCreateModal" class="text-gray-500 hover:text-gray-700">✕</button>
                </div>
                <form id="createUnitForm" method="POST" action="{{ route('units.store') }}" class="p-6">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Unit Name *</label>
                            <input type="text" name="name" required class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-100">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Short Name *</label>
                            <input type="text" name="short_name" required class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-100">
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <button type="button" id="cancelCreateModal" class="px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-gray-50">Cancel</button>
                        <button type="submit" class="px-4 py-2 rounded-full bg-violet-600 text-white hover:bg-violet-500">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-semibold">Edit</h3>
                    <button id="closeEditModal" class="text-gray-500 hover:text-gray-700">✕</button>
                </div>
                <form id="editUnitForm" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Unit Name *</label>
                            <input type="text" id="editUnitName" name="name" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-100" required>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Short Name *</label>
                            <input type="text" id="editUnitShortName" name="short_name" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-100" required>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <button type="button" id="cancelEditModal" class="px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-gray-50">Cancel</button>
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
</div>
@endsection

@push('scripts')
<script>
    (function(){
        const raw = @json(($units ?? []));
        const data = (raw || []).map(r => ({ 
            id: r.id, 
            name: r.name || '', 
            short_name: r.short_name || r.ShortName || '' 
        }));

        let sortKey = 'name';
        let sortAsc = true;
        let page = 1;
        let pageSize = 10;
        let term = '';

        const tbody = document.getElementById('unitTableBody');
        const rowsPerPage = document.getElementById('rowsPerPage');
        const pageText = document.getElementById('pageText');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const searchInput = document.getElementById('searchInput');

        function getFiltered(){
            if (!term) return [...data];
            const t = term.toLowerCase();
            return data.filter(d => (d.name + ' ' + d.short_name).toLowerCase().includes(t));
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
                tbody.innerHTML = '<tr><td colspan="4" class="py-8 text-center text-gray-500">No data Available</td></tr>';
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
                    <td class="py-3 px-4 text-gray-700">${r.name}</td>
                    <td class="py-3 px-4 text-gray-700">${r.short_name}</td>
                    <td class="py-3 px-4">
                        <button data-action="edit" data-id="${r.id}" data-name="${r.name}" data-short-name="${r.short_name}" class="text-emerald-600 hover:text-emerald-500 mr-3">
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

        document.querySelectorAll('#unitTable thead th[data-key]').forEach(th=>{
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
        const createModal = document.getElementById('createModal');
        const editModal = document.getElementById('editModal');
        const openBtn = document.getElementById('openCreateModal');
        const closeBtn = document.getElementById('closeCreateModal');
        const cancelBtn = document.getElementById('cancelCreateModal');
        const form = document.getElementById('createUnitForm');

        function openCreateModal(){ createModal.classList.remove('hidden'); }
        function closeCreateModal(){ createModal.classList.add('hidden'); }
        function openEdit(id, name, shortName){
            document.getElementById('editUnitName').value = name;
            document.getElementById('editUnitShortName').value = shortName;
            document.getElementById('editUnitForm').action = `/app/units/${id}`;
            editModal.classList.remove('hidden');
        }
        function closeEdit(){ editModal.classList.add('hidden'); }
        
        openBtn.addEventListener('click', openCreateModal);
        closeBtn.addEventListener('click', closeCreateModal);
        cancelBtn.addEventListener('click', closeCreateModal);
        document.getElementById('closeEditModal').addEventListener('click', closeEdit);
        document.getElementById('cancelEditModal').addEventListener('click', closeEdit);

        // AJAX submit create form
        if (form) {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(form);
                const csrf = form.querySelector('input[name="_token"]').value;
                try {
                    const res = await fetch(form.action, {
                        method: 'POST',
                        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
                        credentials: 'same-origin',
                        body: formData
                    });
                    if (!res.ok) throw new Error('Request failed');
                    const json = await res.json();
                    const created = json.unit || {};
                    data.push({ id: created.id, name: created.name || '', short_name: created.short_name || '' });
                    page = 1; term = ''; sortKey = 'name'; sortAsc = true; render();
                    form.reset(); closeCreateModal();
                } catch (err) {
                    console.error(err);
                    alert('Failed to create unit');
                }
            });
        }

        // AJAX submit edit form
        const editForm = document.getElementById('editUnitForm');
        if (editForm) {
            editForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(editForm);
                const csrf = editForm.querySelector('input[name="_token"]').value;
                try {
                    const res = await fetch(editForm.action, {
                        method: 'POST',
                        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
                        credentials: 'same-origin',
                        body: formData
                    });
                    if (!res.ok) throw new Error('Request failed');
                    const json = await res.json();
                    const updated = json.unit || {};
                    const index = data.findIndex(d => d.id == updated.id);
                    if (index !== -1) {
                        data[index] = { id: updated.id, name: updated.name || '', short_name: updated.short_name || '' };
                    }
                    render();
                    closeEdit();
                } catch (err) {
                    console.error(err);
                    alert('Failed to update unit');
                }
            });
        }

        // Delete function
        function deleteUnit(id) {
            if (!confirm('Are you sure you want to delete this unit?')) return;
            fetch(`/app/units/${id}`, {
                method: 'DELETE',
                headers: { 
                    'Accept': 'application/json', 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            })
            .then(res => {
                if (!res.ok) throw new Error('Request failed');
                const index = data.findIndex(d => d.id == id);
                if (index !== -1) {
                    data.splice(index, 1);
                }
                render();
            })
            .catch(err => {
                console.error(err);
                alert('Failed to delete unit');
            });
        }
        
        // Make functions globally accessible
        window.openEdit = openEdit;
        window.closeEdit = closeEdit;
        window.deleteUnit = deleteUnit;
        
        // Event delegation for action buttons
        tbody.addEventListener('click', function(e) {
            const button = e.target.closest('button[data-action]');
            if (!button) return;
            
            const action = button.getAttribute('data-action');
            const id = button.getAttribute('data-id');
            
            if (action === 'edit') {
                const name = button.getAttribute('data-name');
                const shortName = button.getAttribute('data-short-name');
                openEdit(id, name, shortName);
            } else if (action === 'delete') {
                deleteUnit(id);
            }
        });
    })();
</script>
@endpush


