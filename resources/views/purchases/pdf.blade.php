pdf.blade.php

@extends('layouts.print')

@section('content')
<h2>Purchase Report</h2>
<p><strong>Generated:</strong> {{ date('Y-m-d H:i:s') }}</p>
<p><strong>Total Records:</strong> {{ count($data) }}</p>
<hr>
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Item</th>
            <th>Quantity</th>
            <th>Category</th>
            <th>Supplier</th>
            <th>Warehouse</th>
            <th>Note</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $purchase)
        <tr>
            <td>{{ $purchase->date }}</td>
            <td>{{ $purchase->item }}</td>
            <td>{{ (int)$purchase->qty }}</td>
            <td>{{ $purchase->category }}</td>
            <td>{{ $purchase->supplier }}</td>
            <td>{{ $purchase->warehouse }}</td>
            <td>{{ $purchase->note }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection