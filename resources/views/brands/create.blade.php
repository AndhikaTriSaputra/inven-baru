@extends('layouts.app')

@section('content')
<div class="p-6 max-w-2xl">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Create Brand</h1>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="#">
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Brand Name</label>
                    <input type="text" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-100">
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Brand Description</label>
                    <textarea class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-100" rows="3"></textarea>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Brand Image</label>
                    <input type="file" class="w-full text-sm">
                </div>
            </div>
            <div class="mt-6 flex items-center space-x-3">
                <button type="submit" class="px-4 py-2 rounded-full bg-violet-600 text-white hover:bg-violet-500">Save</button>
                <a href="{{ route('products.brands.index') }}" class="px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-gray-50">Cancel</a>
            </div>
        </form>
    </div>
    <div class="text-sm text-gray-500 mt-6">Products / Brand / Create</div>
  </div>
@endsection

