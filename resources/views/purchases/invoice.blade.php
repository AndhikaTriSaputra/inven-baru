invoice.blade.php

@extends('layouts.print')

@section('content')
<h2>Purchase Invoice</h2>
<p><strong>Date:</strong> {{ $purchase->date }}</p>
<p><strong>Ref:</strong> {{ $purchase->Ref }}</p>
<hr>
<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Cost</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($details as $item)
        <tr>
            <td>{{ $item->product_name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>Rp {{ number_format($item->cost, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<p><strong>Grand Total:</strong> Rp {{ number_format($purchase->GrandTotal, 0, ',', '.') }}</p>
@endsection