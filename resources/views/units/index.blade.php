@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Units</h1>
        <a href="{{ route('units.create') }}" class="px-4 py-2 rounded-lg bg-violet-600 text-white">Create</a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100">
        <table class="w-full">
            <thead class="bg-gray-50 text-sm">
                <tr>
                    <th class="py-3 px-4 text-left">Name</th>
                    <th class="py-3 px-4 text-left">Short</th>
                    <th class="py-3 px-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($units as $u)
                <tr class="border-b border-gray-100">
                    <td class="py-3 px-4">{{ $u->name }}</td>
                    <td class="py-3 px-4">{{ $u->ShortName }}</td>
                    <td class="py-3 px-4 text-right">
                        <a href="{{ route('units.edit', $u->id) }}" class="text-emerald-600">Edit</a>
                    </td>
                </tr>
                @empty
                <tr><td class="py-8 px-4 text-center text-gray-500" colspan="3">No data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection


