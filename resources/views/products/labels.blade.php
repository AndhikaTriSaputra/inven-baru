@extends('layouts.app')

@section('title', 'Print Labels')

@section('header')
<div class="flex items-center justify-between w-full">
    <div>
        <h2 class="text-xl font-semibold">Print Labels</h2>
        <p class="text-sm text-gray-500">Generate and print product labels by warehouse</p>
    </div>
    <div class="flex items-center space-x-2 text-sm text-gray-500">
        <a href="{{ route('products.index') }}" class="hover:text-violet-600">Products</a>
        <span>/</span>
        <span class="text-gray-700 font-medium">Print Labels</span>
    </div>
    </div>
@endsection

@section('content')
<form action="#" method="GET" class="space-y-6">
    <!-- Warehouse -->
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Warehouse <span class="text-red-500">*</span></label>
        <select class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 appearance-none text-gray-900 transition-all duration-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-100 focus:outline-none hover:border-gray-300">
            <option value="">Choose Warehouse</option>
            @foreach(($warehouses ?? []) as $w)
                <option value="{{ $w->id }}">{{ $w->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Product Search -->
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Product</label>
        <div class="relative">
            <input type="text" placeholder="Scan/Search Product by Code Or Name" class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 pl-12 text-gray-900 placeholder-gray-400 transition-all duration-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-100 focus:outline-none hover:border-gray-300" />
            <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z"/></svg>
            </div>
        </div>
    </div>

    <!-- Selected Products Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Product</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Code Product</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Quantity</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="3" class="py-8 text-center text-gray-500">No data Available</td>
                </tr>
            </tbody>
        </table>
        <div class="p-4 flex items-center space-x-3">
            <label class="block text-sm font-semibold text-gray-700">Paper size</label>
            <select class="rounded-xl border-2 border-gray-200 px-3 py-2 text-sm focus:border-violet-500 focus:ring-4 focus:ring-violet-100">
                <option>Paper size</option>
                <option>A4</option>
                <option>Label 50x30</option>
            </select>
        </div>
    </div>

    <div class="flex items-center space-x-3">
        <button type="button" class="px-4 py-2 rounded-lg bg-violet-600 text-white hover:bg-violet-700">Update</button>
        <button type="reset" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">Reset</button>
        <button type="button" class="px-4 py-2 rounded-lg bg-gray-800 text-white hover:bg-gray-900">Print</button>
    </div>
</form>
@endsection



