

@extends('layouts.app')

@section('header')
Purchase Detail
@endsection

@section('content')
<div class="bg-white border border-gray-200 rounded-xl p-6">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-2">
            <a href="{{ route('purchases.edit',$purchase->id) }}" class="px-3 py-2 rounded bg-emerald-500 text-white text-sm">Edit Purchase</a>
            <a href="{{ route('purchases.print',$purchase->id ?? 0) }}" class="px-3 py-2 rounded border text-sm">Print</a>
            <a href="{{ route('purchases.invoice',$purchase->id ?? 0) }}" class="px-3 py-2 rounded border text-sm">PDF</a>
        </div>
        <form method="POST" action="{{ route('purchases.destroy',$purchase->id) }}" onsubmit="return confirm('Delete this purchase?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-3 py-2 rounded bg-rose-500 text-white text-sm">Delete</button>
        </form>
    </div>

    <h2 class="text-center text-xl font-semibold mb-6">Purchase Detail : {{ $purchase->Ref }}</h2>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 mb-8">
        <div class="space-y-2 min-w-0">
            <div class="text-base font-semibold text-gray-900">Supplier Info</div>
            @php $supplier = DB::table('providers')->where('id',$purchase->provider_id)->first(); @endphp
            <div class="text-sm text-gray-700 flex flex-col gap-1">
                <div class="flex items-baseline gap-2"><span class="text-gray-500 w-28 md:w-32 shrink-0">Name :</span><span class="text-gray-800 font-medium">{{ $supplier->name ?? '-' }}</span></div>
                <div class="flex items-baseline gap-2"><span class="text-gray-500 w-28 md:w-32 shrink-0">Email :</span><span class="text-gray-800">{{ $supplier->email ?? '-' }}</span></div>
                <div class="flex items-baseline gap-2"><span class="text-gray-500 w-28 md:w-32 shrink-0">Phone :</span><span class="text-gray-800">{{ $supplier->phone ?? '-' }}</span></div>
            </div>
        </div>
        <div class="space-y-2 min-w-0">
            <div class="text-base font-semibold text-gray-900">Company Info</div>
            <div class="text-sm text-gray-700 flex flex-col gap-1">
                <div class="flex items-baseline gap-2"><span class="text-gray-500 w-28 md:w-32 shrink-0">Name :</span><span class="text-gray-800 font-medium">Stocky</span></div>
                <div class="flex items-baseline gap-2"><span class="text-gray-500 w-28 md:w-32 shrink-0">Email :</span><span class="text-gray-800">admin@example.com</span></div>
                <div class="flex items-baseline gap-2"><span class="text-gray-500 w-28 md:w-32 shrink-0">Phone :</span><span class="text-gray-800">6315996770</span></div>
                <div class="flex items-baseline gap-2"><span class="text-gray-500 w-28 md:w-32 shrink-0">Address :</span><span class="text-gray-800">3618 Abia Martin Drive</span></div>
            </div>
        </div>
        <div class="space-y-2 min-w-0">
            <div class="text-base font-semibold text-gray-900">Purchase Info</div>
            <div class="text-sm text-gray-700 flex flex-col gap-1">
                <div class="flex items-baseline gap-2"><span class="text-gray-500 w-28 md:w-32 shrink-0">Reference :</span><span class="text-gray-700 font-medium">{{ $purchase->Ref }}</span></div>
                <div class="flex items-baseline gap-2"><span class="text-gray-500 w-28 md:w-32 shrink-0">Status :</span><span class="inline-flex items-center px-2 py-0.5 rounded bg-emerald-100 text-emerald-700">{{ ucfirst($purchase->statut ?? 'received') }}</span></div>
                @php $warehouse = DB::table('warehouses')->where('id',$purchase->warehouse_id)->first(); @endphp
                <div class="flex items-baseline gap-2"><span class="text-gray-500 w-28 md:w-32 shrink-0">Warehouse :</span><span class="text-gray-700 font-medium">{{ $warehouse->name ?? '-' }}</span></div>
                <div class="flex items-baseline gap-2"><span class="text-gray-500 w-28 md:w-32 shrink-0">Payment Status :</span><span class="inline-flex items-center px-2 py-0.5 rounded bg-yellow-100 text-yellow-700">{{ ucfirst($purchase->payment_statut ?? 'unpaid') }}</span></div>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr class="text-left">
                    <th class="px-4 py-2">Product</th>
                    <th class="px-4 py-2">Net Unit Cost</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">Unit cost</th>
                    <th class="px-4 py-2">Discount</th>
                    <th class="px-4 py-2">Tax</th>
                    <th class="px-4 py-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $paid = (float)($purchase->paid_amount ?? 0); $total = 0; @endphp
                @foreach($details as $row)
                @php $subtotal = (float)$row->total; $total += $subtotal; @endphp
                <tr class="border-t">
                    <td class="px-4 py-2"><div class="font-medium">{{ $row->product_name }}</div><div class="text-xs text-gray-500">{{ $row->product_code }}</div></td>
                    <td class="px-4 py-2">$ {{ number_format((float)$row->cost,3) }}</td>
                    <td class="px-4 py-2">{{ (float)$row->quantity }} {{ $row->unit ?? 'Pcs' }}</td>
                    <td class="px-4 py-2">$ {{ number_format((float)$row->cost,2) }}</td>
                    <td class="px-4 py-2">$ 0.00</td>
                    <td class="px-4 py-2">$ 0.00</td>
                    <td class="px-4 py-2">$ {{ number_format($subtotal,2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <div class="md:col-start-3">
            <table class="w-full text-sm">
                <tr>
                    <td class="px-4 py-2 text-gray-700">Paid</td>
                    <td class="px-4 py-2 text-right">$ {{ number_format($paid,2) }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 text-gray-700">Due</td>
                    <td class="px-4 py-2 text-right">$ {{ number_format(max($total-$paid,0),2) }}</td>
                </tr>
            </table>
        </div>
    </div>
    @if(!empty($purchase->notes))
    <div class="mt-6 text-sm text-gray-700">{{ $purchase->notes }}</div>
    @endif
</div>
@endsection