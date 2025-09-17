@extends('layouts.app')

@section('header')
  Print Adjustments
@endsection

@section('content')
<div class="bg-white border border-gray-200 rounded-lg p-6">
  <div class="text-xl font-semibold mb-4">All Adjustments</div>
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b">
          <th class="text-left py-2">Date</th>
          <th class="text-left py-2">Reference</th>
          <th class="text-left py-2">Warehouse</th>
          <th class="text-left py-2">Total Products</th>
        </tr>
      </thead>
      <tbody>
        @foreach($rows as $r)
        <tr class="border-b">
          <td class="py-2">{{ $r->date }}</td>
          <td class="py-2">{{ $r->Ref }}</td>
          <td class="py-2">{{ $r->warehouse }}</td>
          <td class="py-2">{{ (int)($r->items ?? 0) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="mt-4 print:hidden">
    <button onclick="window.print()" class="px-4 py-2 bg-violet-600 text-white rounded">Print</button>
  </div>
</div>
@endsection





