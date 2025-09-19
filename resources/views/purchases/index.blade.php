@extends('layouts.app')

@section('header')
All Purchases
@endsection

@section('content')
<div class="bg-white border border-gray-200 rounded-lg p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold">All Purchases</h3>
        <div class="flex items-center gap-2">
            <button class="px-3 py-2 border border-gray-300 rounded text-sm">Get Suppliers</button>
            <button class="px-3 py-2 border border-gray-300 rounded text-sm">Filter</button>
            <button class="px-3 py-2 border border-gray-300 rounded text-sm">PDF</button>
            <button class="px-3 py-2 border border-gray-300 rounded text-sm">EXCEL</button>
            <a href="{{ route('purchases.create') }}" class="px-3 py-2 bg-violet-600 text-white rounded text-sm">Create</a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="py-2"><input type="checkbox"/></th>
                    <th class="text-left py-2">Image</th>
                    <th class="text-left py-2">Item</th>
                    <th class="text-left py-2">Qty</th>
                    <th class="text-left py-2">Category</th>
                    <th class="text-left py-2">Date</th>
                    <th class="text-left py-2">Supplier</th>
                    <th class="text-left py-2">Warehouse</th>
                    <th class="text-left py-2">Note</th>
                    <th class="text-left py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchases as $p)
                <tr class="border-b border-gray-100">
                    <td class="py-2"><input type="checkbox"/></td>
                    <td class="py-2">
                        @php $img = 'no-image.png'; if (!empty($p->image)) { $parts = explode(',', $p->image); $img = trim($parts[0]); } @endphp
                        <img src="{{ asset($img) }}" class="h-10 w-14 object-cover rounded"/>
                    </td>
                    <td class="py-2">{{ $p->item }}</td>
                    <td class="py-2">{{ (int)$p->qty }}</td>
                    <td class="py-2">{{ $p->category }}</td>
                    <td class="py-2">{{ $p->date }}</td>
                    <td class="py-2">{{ $p->supplier }}</td>
                    <td class="py-2">{{ $p->warehouse }}</td>
                    <td class="py-2">{{ $p->note }}</td>
                    <td class="py-2">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('purchases.show',$p->purchase_id) }}" title="Show" class="text-sky-600 hover:text-sky-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12z"/><circle cx="12" cy="12" r="2.25"/></svg>
                            </a>
                            <a href="{{ route('purchases.edit',$p->purchase_id) }}" title="Edit" class="text-emerald-600 hover:text-emerald-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 3.487a2.25 2.25 0 013.182 3.182L7.5 19.313 3 21l1.687-4.5L16.862 3.487z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('purchases.destroy',$p->purchase_id) }}" onsubmit="return confirm('Delete this purchase?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete" class="text-rose-600 hover:text-rose-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 7h12M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2m1 0v12a2 2 0 01-2 2H8a2 2 0 01-2-2V7h12z"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td class="py-3" colspan="10">No data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{!! $purchases->links('pagination::simple-tailwind') !!}</div>
</div>
@endsection