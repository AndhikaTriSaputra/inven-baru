

@extends('layouts.print')

@section('content')
<h2>Transfer Invoice</h2>
<p><strong>Date:</strong> {{ $transfer->date }}</p>
<p><strong>Ref:</strong> {{ $transfer->Ref }}</p>
<p><strong>From Warehouse:</strong> {{ $fromWarehouse }}</p>
<p><strong>To Warehouse:</strong> {{ $toWarehouse }}</p>
<p><strong>Status:</strong> {{ ucfirst($transfer->status) }}</p>
<hr>
<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Code</th>
            <th>Qty</th>
            <th>Unit</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($details as $item)
        <tr>
            <td>{{ $item->product_name }}</td>
            <td>{{ $item->product_code }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->unit ?? 'Pcs' }}</td>
            <td>$ {{ number_format($item->total, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<p><strong>Total Items:</strong> {{ $details->sum('quantity') }}</p>
<p><strong>Total Value:</strong> $ {{ number_format($details->sum('total'), 2) }}</p>
@if(!empty($transfer->notes))
<p><strong>Notes:</strong> {{ $transfer->notes }}</p>
@endif
@endsection