@extends('layouts.app')

@section('header')
Warehouses
@endsection

@section('content')
<div class="bg-white border border-gray-200 rounded-lg p-6">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-baseline gap-3">
            <h3 class="text-2xl font-semibold">Warehouse</h3>
            <div class="text-xs text-slate-500">Settings | Warehouse</div>
        </div>
        <button type="button" onclick="openCreateWarehouse()" class="px-4 py-2 bg-violet-600 text-white rounded-lg text-sm flex items-center gap-2">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14"/></svg>
            Create
        </button>
    </div>
    <div class="flex items-center justify-between mb-3">
        <div class="relative w-64">
            <input id="whSearch" type="text" class="w-full border rounded pl-9 pr-3 py-2 text-sm" placeholder="Search this table" />
            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"/></svg>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm border-separate" style="border-spacing:0">
            <thead>
                <tr class="border-b border-gray-200 bg-slate-50 sticky top-0">
                    <th class="py-2"><input type="checkbox"/></th>
                    <th class="text-left py-2 px-2">Name <svg class="inline w-3 h-3 -mt-1 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 10l5-5 5 5M7 14l5 5 5-5"/></svg></th>
                    <th class="text-left py-2 px-2">Phone <svg class="inline w-3 h-3 -mt-1 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 10l5-5 5 5M7 14l5 5 5-5"/></svg></th>
                    <th class="text-left py-2 px-2">Country <svg class="inline w-3 h-3 -mt-1 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 10l5-5 5 5M7 14l5 5 5-5"/></svg></th>
                    <th class="text-left py-2 px-2">City <svg class="inline w-3 h-3 -mt-1 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 10l5-5 5 5M7 14l5 5 5-5"/></svg></th>
                    <th class="text-left py-2 px-2">Email <svg class="inline w-3 h-3 -mt-1 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 10l5-5 5 5M7 14l5 5 5-5"/></svg></th>
                    <th class="text-left py-2 px-2">Zip Code <svg class="inline w-3 h-3 -mt-1 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 10l5-5 5 5M7 14l5 5 5-5"/></svg></th>
                    <th class="text-left py-2 px-2">Action</th>
                </tr>
            </thead>
            <tbody id="whBody">
                @forelse($warehouses as $w)
                <tr class="border-b border-gray-100 hover:bg-slate-50">
                    <td class="py-2 px-2"><input type="checkbox"/></td>
                    <td class="py-2 px-2 truncate max-w-[260px]" title="{{ $w->name }}">{{ $w->name }}</td>
                    <td class="py-2 px-2 whitespace-nowrap">{{ $w->phone }}</td>
                    <td class="py-2 px-2">{{ $w->country }}</td>
                    <td class="py-2 px-2">{{ $w->city }}</td>
                    <td class="py-2 px-2 truncate max-w-[260px]" title="{{ $w->email }}">{{ $w->email }}</td>
                    <td class="py-2 px-2">{{ $w->zip }}</td>
                    <td class="py-2 px-2">
                        <div class="flex items-center gap-2 text-gray-600">
                            <a href="{{ route('warehouses.edit', $w->id) }}" class="p-1 rounded border border-emerald-200 text-emerald-600 hover:bg-emerald-50" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.651 1.651m-1.651-1.651L7.5 13.5 6 18l4.5-1.5 9.362-9.362m-3-3L18 3a1.5 1.5 0 012.121 0l.879.879a1.5 1.5 0 010 2.121l-1.138 1.138"/></svg>
                            </a>
                            <form action="{{ route('warehouses.destroy', $w->id) }}" method="POST" onsubmit="return confirm('Delete this warehouse?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 rounded border border-rose-200 text-rose-600 hover:bg-rose-50" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 7h12M9 7V5a1 1 0 011-1h4a1 1 0 011 1v2m-1 0v12a2 2 0 01-2 2h-4a2 2 0 01-2-2V7"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td class="py-3" colspan="8">No data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{!! $warehouses->links('pagination::simple-tailwind') !!}</div>
</div>

<!-- Create Modal -->
<div id="whCreateBackdrop" class="fixed inset-0 bg-black/40 z-40 hidden"></div>
<div id="whCreateModal" class="fixed inset-0 z-50 flex items-start justify-center pt-16 hidden">
    <div class="bg-white w-full max-w-3xl rounded-lg shadow-xl border border-gray-200">
        <div class="flex items-center justify-between px-5 py-3 border-b">
            <div class="font-semibold">Create</div>
            <button type="button" onclick="closeCreateWarehouse()" class="text-slate-500 hover:text-slate-700">✕</button>
        </div>
        <form action="{{ route('warehouses.store') }}" method="POST" class="p-5">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Name *</label>
                    <input type="text" name="name" required class="w-full border rounded-lg px-3 py-2" placeholder="Enter Warehouse Name">
                </div>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Country</label>
                    <input type="text" name="country" class="w-full border rounded-lg px-3 py-2" placeholder="Enter Warehouse Country">
                </div>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Phone</label>
                    <input type="text" name="mobile" class="w-full border rounded-lg px-3 py-2" placeholder="Enter Warehouse Phone">
                </div>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Email</label>
                    <input type="email" name="email" class="w-full border rounded-lg px-3 py-2" placeholder="Enter Warehouse Email">
                </div>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">City</label>
                    <input type="text" name="city" class="w-full border rounded-lg px-3 py-2" placeholder="Enter Warehouse City">
                </div>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Zip Code</label>
                    <input type="text" name="zip" class="w-full border rounded-lg px-3 py-2" placeholder="Enter Warehouse Zip Code">
                </div>
            </div>
            <div class="mt-5">
                <button class="px-4 py-2 bg-violet-600 text-white rounded">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
    // search filter
    (function(){
        const input = document.getElementById('whSearch');
        const body = document.getElementById('whBody');
        if(!input || !body) return;
        input.addEventListener('input', function(){
            const q = (this.value||'').toLowerCase();
            body.querySelectorAll('tr').forEach(tr =>{
                const text = tr.innerText.toLowerCase();
                tr.style.display = text.includes(q) ? '' : 'none';
            });
        });
    })();

    function openCreateWarehouse(){
        document.getElementById('whCreateModal').classList.remove('hidden');
        document.getElementById('whCreateBackdrop').classList.remove('hidden');
    }
    function closeCreateWarehouse(){
        document.getElementById('whCreateModal').classList.add('hidden');
        document.getElementById('whCreateBackdrop').classList.add('hidden');
    }
</script>
@endsection


