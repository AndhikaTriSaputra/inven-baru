@extends('layouts.app')

@section('content')
<div class="p-6 max-w-2xl">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Brand</h1>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        @php
            $routeParam = request()->route('brand');
            $resolvedId = is_object($routeParam) ? ($routeParam->id ?? null) : $routeParam;
            $brandId = $brand->id ?? ($brand['id'] ?? $resolvedId);
            $brandRow = $brand ?? null;
            if(!$brandRow && $brandId){
                try {
                    $brandRow = \App\Models\Brand::find($brandId);
                } catch (\Throwable $e) {
                    $brandRow = \DB::table('brands')->where('id', $brandId)->first();
                }
            }
            $brandName = old('name', $brandRow->name ?? ($brandRow['name'] ?? ''));
            $brandDesc = old('description', $brandRow->description ?? ($brandRow['description'] ?? ''));
            $brandImg = $brandRow->image ?? ($brandRow['image'] ?? null);
        @endphp
        <form method="POST" action="{{ route('brands.update', ['brand' => $brandId]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Brand Name</label>
                    <input name="name" type="text" value="{{ $brandName }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-100" required>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Brand Description</label>
                    <textarea name="description" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-100" rows="3">{{ $brandDesc }}</textarea>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Brand Image</label>
                    <input name="image" type="file" accept="image/*" class="w-full text-sm">
                    @if($brandImg)
                        <div class="mt-2">
                            <img src="{{ asset($brandImg) }}" alt="brand" class="w-20 h-20 rounded object-cover border">
                        </div>
                    @endif
                </div>
            </div>
            <div class="mt-6 flex items-center space-x-3">
                <button type="submit" class="px-4 py-2 rounded-full bg-violet-600 text-white hover:bg-violet-500">Update</button>
                <a href="{{ route('brands.index') }}" class="px-4 py-2 rounded-full border border-gray-300 text-gray-700 hover:bg-gray-50">Cancel</a>
            </div>
        </form>
    </div>
    <div class="text-sm text-gray-500 mt-6">Products / Brand / Edit</div>
  </div>
@endsection