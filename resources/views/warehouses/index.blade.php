@extends('layouts.app')

@section('header')
Warehouse
@endsection

@section('content')
<div class="bg-white border border-gray-200 rounded-lg p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold">Warehouse</h3>
        <button type="button" onclick="openCreateWarehouse()" class="px-3 py-2 bg-violet-600 text-white rounded text-sm">Create</button>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="py-2"><input type="checkbox"/></th>
                    <th class="text-left py-2">Name</th>
                    <th class="text-left py-2">Phone</th>
                    <th class="text-left py-2">Country</th>
                    <th class="text-left py-2">City</th>
                    <th class="text-left py-2">Email</th>
                    <th class="text-left py-2">Zip Code</th>
                    <th class="text-left py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($warehouses as $w)
                <tr class="border-b border-gray-100">
                    <td class="py-2"><input type="checkbox"/></td>
                    <td class="py-2">{{ $w->name }}</td>
                    <td class="py-2">{{ $w->phone }}</td>
                    <td class="py-2">{{ $w->country }}</td>
                    <td class="py-2">{{ $w->city }}</td>
                    <td class="py-2">{{ $w->email }}</td>
                    <td class="py-2">{{ $w->zip }}</td>
                    <td class="py-2">
                        <div class="flex items-center gap-2 text-gray-600">
                            <a href="{{ route('warehouses.edit', $w->id) }}" class="p-1 hover:text-emerald-700" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.651 1.651m-1.651-1.651L7.5 13.5 6 18l4.5-1.5 9.362-9.362m-3-3L18 3a1.5 1.5 0 012.121 0l.879.879a1.5 1.5 0 010 2.121l-1.138 1.138"/></svg>
                            </a>
                            <form action="{{ route('warehouses.destroy', $w->id) }}" method="POST" onsubmit="return confirm('Delete this warehouse?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 hover:text-rose-700" title="Delete">
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


