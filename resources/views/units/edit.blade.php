@extends('layouts.app')

@section('content')
<div class="p-6 max-w-xl">
    <h1 class="text-2xl font-semibold mb-4">Edit Unit</h1>
    <div class="bg-white rounded-2xl p-6 border border-gray-100">
        <form method="POST" action="{{ route('units.update', $unit['id']) }}">
            @csrf
            @method('PUT')
            <div class="grid gap-3">
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" value="{{ $unit['name'] ?? '' }}" class="w-full rounded-md border border-gray-300 px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Short Name</label>
                    <input type="text" name="ShortName" value="{{ $unit['ShortName'] ?? '' }}" class="w-full rounded-md border border-gray-300 px-3 py-2">
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2">
                <button class="px-4 py-2 rounded-lg bg-violet-600 text-white">Update</button>
                <a href="{{ route('units.index') }}" class="px-4 py-2 rounded-lg border">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection


