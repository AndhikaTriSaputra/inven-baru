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
            <a href="#" class="px-3 py-2 bg-violet-600 text-white rounded text-sm">Create</a>
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
                        <div class="text-gray-600">···</div>
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

