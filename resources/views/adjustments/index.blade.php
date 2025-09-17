@extends('layouts.app')

@section('header')
All Adjustments
@endsection

@section('content')
<div class="bg-white border border-gray-200 rounded-lg p-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <div class="text-2xl font-semibold">All Adjustments</div>
            <div class="text-sm text-slate-500">Adjustment | All Adjustments</div>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="document.getElementById('filterPanel').classList.remove('hidden')" class="px-3 py-2 border border-gray-300 rounded text-sm">Filter</button>
            <a href="{{ request()->fullUrlWithQuery(['export'=>'pdf']) }}" class="px-3 py-2 border border-gray-300 rounded text-sm">PDF</a>
            <a href="{{ request()->fullUrlWithQuery(['export'=>'csv']) }}" class="px-3 py-2 border border-gray-300 rounded text-sm">EXCEL</a>
            <a href="{{ route('adjustments.create') }}" class="px-3 py-2 bg-violet-600 text-white rounded text-sm">Create</a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="py-2"><input type="checkbox"/></th>
                    <th class="text-left py-2">Date</th>
                    <th class="text-left py-2">Reference</th>
                    <th class="text-left py-2">Warehouse</th>
                    <th class="text-left py-2">Total Products</th>
                    <th class="text-left py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($adjustments as $a)
                <tr class="border-b border-gray-100">
                    <td class="py-2"><input type="checkbox"/></td>
                    <td class="py-2">{{ $a->date }}</td>
                    <td class="py-2">{{ $a->Ref }}</td>
                    <td class="py-2">{{ $a->warehouse }}</td>
                    <td class="py-2">{{ $a->items }}</td>
                    <td class="py-2 text-gray-500">
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
@endsection


