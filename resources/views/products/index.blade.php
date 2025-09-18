@extends('layouts.app')

@section('header')
@include('components.header')
@endsection

@section('page-title')
All Products
@endsection

@section('content')
<div class="bg-white border border-gray-200 rounded-lg p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold">All Products</h3>
        <div class="flex items-center gap-2">
            <button class="px-3 py-2 bg-emerald-600 text-white rounded text-sm">Approval</button>
            <button class="px-3 py-2 border border-gray-300 rounded text-sm">Filter</button>
            <button class="px-3 py-2 border border-gray-300 rounded text-sm">PDF</button>
            <button class="px-3 py-2 border border-gray-300 rounded text-sm">EXCEL</button>
            <button class="px-3 py-2 border border-gray-300 rounded text-sm">Import products</button>
            <a href="{{ route('products.create') }}" class="px-3 py-2 bg-violet-600 text-white rounded text-sm">Create</a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="py-2"><input type="checkbox" /></th>
                    <th class="text-left py-2">Image</th>
                    <th class="text-left py-2">Type</th>
                    <th class="text-left py-2">Name</th>
                    <th class="text-left py-2">Tag</th>
                    <th class="text-left py-2">Project</th>
                    <th class="text-left py-2">Code</th>
                    <th class="text-left py-2">Brand</th>
                    <th class="text-left py-2">Unit</th>
                    <th class="text-left py-2">Quantity</th>
                    <th class="text-left py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                <tr class="border-b border-gray-100">
                    <td class="py-2"><input type="checkbox" /></td>
                    <td class="py-2">
                        @php $img = 'no-image.png'; if (!empty($p->image)) { $parts = explode(',', $p->image); $img = trim($parts[0]); } @endphp
                        <img src="{{ asset($img) }}" class="h-10 w-14 object-cover rounded"/>
                    </td>
                    <td class="py-2">{{ $p->type === 'is_service' ? 'Service' : 'Non Product' }}</td>
                    <td class="py-2">{{ $p->name }}</td>
                    <td class="py-2">N/D</td>
                    <td class="py-2">N/D</td>
                    <td class="py-2">{{ $p->code }}</td>
                    <td class="py-2">{{ $p->brand }}</td>
                    <td class="py-2">{{ $p->unit }}</td>
                    <td class="py-2">{{ (int)$p->qty }} {{ $p->unit }}</td>
                    <td class="py-2 text-gray-500">...
                    </td>
                </tr>
                @empty
                <tr><td class="py-3" colspan="11">No data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{!! $products->links('pagination::simple-tailwind') !!}</div>
</div>
@endsection


