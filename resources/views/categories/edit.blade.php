@extends('layouts.app')

@section('content')
<div class="p-6 max-w-2xl">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Category</h1>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('categories.update', $category['id']) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Category Code</label>
                    <input type="text" name="code" value="{{ $category['code'] ?? '' }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-100">
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Category Name</label>
                    <input type="text" name="name" value="{{ $category['name'] ?? '' }}" required class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-100">
                </div>
            </div>
            <div class="mt-6 flex items-center space-x-3">
                <button type="submit" class="px-4 py-2 rounded-full bg-violet-600 text-white hover:bg-violet-500">Update</button>
                <a href="{{ route('categories.index') }}" class="px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-gray-50">Cancel</a>
            </div>
        </form>
    </div>
    <div class="text-sm text-gray-500 mt-6">Products / Category / Edit</div>
  </div>
@endsection


