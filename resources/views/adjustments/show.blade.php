@extends('layouts.app')

@section('header')
  <div class="flex items-center gap-2">
    <a href="{{ route('adjustments.index') }}" class="text-slate-500 hover:text-slate-700">All Adjustments</a>
    <span class="text-slate-400">/</span>
    <span class="font-semibold">Detail</span>
  </div>
@endsection

@section('content')
<div class="bg-white border border-gray-200 rounded-xl p-6">
  <div class="grid md:grid-cols-3 gap-4 mb-6">
    <div>
      <div class="text-xs text-slate-500">Date</div>
      <div class="mt-1 font-medium">{{ \Carbon\Carbon::parse($header->date)->format('d/m/Y') }}</div>
    </div>
    <div>
      <div class="text-xs text-slate-500">Reference</div>
      <div class="mt-1 font-medium">{{ $header->Ref }}</div>
    </div>
    <div>
      <div class="text-xs text-slate-500">Total Products</div>
      <div class="mt-1 font-medium">{{ (int)($header->items ?? 0) }}</div>
    </div>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b">
          <th class="text-left py-2">#</th>
          <th class="text-left">Code Product</th>
          <th class="text-left">Product</th>
          <th class="text-left">Warehouse</th>
          <th class="text-left">Qty</th>
          <th class="text-left">Type</th>
        </tr>
      </thead>
      <tbody>
        @foreach($items as $i => $row)
          <tr class="border-b">
            <td class="py-2">{{ $i+1 }}</td>
            <td>{{ $row->code }}</td>
            <td>{{ $row->name }}</td>
            <td>{{ $row->warehouse_path }}</td>
            <td>{{ (int)$row->qty }}</td>
            <td>{{ $row->type }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  @if($header->notes)
    <div class="mt-6">
      <div class="text-xs text-slate-500 mb-1">Note</div>
      <div class="p-4 bg-slate-50 rounded-lg">{{ $header->notes }}</div>
    </div>
  @endif

  <div class="mt-6">
    <a href="{{ route('adjustments.edit',$header->id) }}" class="px-4 py-2 bg-violet-600 text-white rounded-md">Edit</a>
  </div>
</div>
@endsection
