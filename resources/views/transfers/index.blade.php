@extends('layouts.app')

@section('header')
All Transfers
@endsection

@section('content')
<div class="bg-white border border-gray-200 rounded-lg p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold">All Transfers</h3>
        <div class="flex items-center gap-2">
            <button class="px-3 py-2 border border-gray-300 rounded text-sm">Filter</button>
            <button class="px-3 py-2 border border-gray-300 rounded text-sm">PDF</button>
            <button class="px-3 py-2 border border-gray-300 rounded text-sm">EXCEL</button>
            <a href="#" class="px-3 py-2 bg-violet-600 text-white rounded text-sm">Create</a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="text-left py-2">Date</th>
                    <th class="text-left py-2">Reference</th>
                    <th class="text-left py-2">From Warehouse</th>
                    <th class="text-left py-2">To Warehouse</th>
                    <th class="text-left py-2">Items</th>
                    <th class="text-left py-2">Status</th>
                    <th class="text-left py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transfers as $t)
                <tr class="border-b border-gray-100">
                    <td class="py-2">{{ $t->date }}</td>
                    <td class="py-2">{{ $t->reference }}</td>
                    <td class="py-2">{{ $t->from_wh }}</td>
                    <td class="py-2">{{ $t->to_wh }}</td>
                    <td class="py-2">{{ $t->items }}</td>
                    <td class="py-2">
                        <span class="px-2 py-1 rounded text-xs {{ strtolower($t->statut)==='completed' ? 'bg-green-100 text-green-700' : (strtolower($t->statut)==='pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') }}">{{ ucfirst($t->statut) }}</span>
                    </td>
                    <td class="py-2">
                        <div class="flex items-center gap-2 text-gray-600">
                            <a href="{{ route('transfers.show', $t->id) }}" class="p-1 hover:text-violet-700" title="View">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 12s3.75-6.75 9.75-6.75 9.75 6.75 9.75 6.75-3.75 6.75-9.75 6.75S2.25 12 2.25 12z"/><circle cx="12" cy="12" r="3" stroke-width="1.5" stroke="currentColor" fill="none"/></svg>
                            </a>
                            <a href="{{ route('transfers.edit', $t->id) }}" class="p-1 hover:text-emerald-700" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.651 1.651m-1.651-1.651L7.5 13.5 6 18l4.5-1.5 9.362-9.362m-3-3L18 3a1.5 1.5 0 012.121 0l.879.879a1.5 1.5 0 010 2.121l-1.138 1.138"/></svg>
                            </a>
                            <form action="{{ route('transfers.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Delete this transfer?')">
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
                <tr><td class="py-3" colspan="7">No data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{!! $transfers->links('pagination::simple-tailwind') !!}</div>
</div>
@endsection





