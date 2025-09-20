print.blade.php

@extends('layouts.print')

@section('content')
    <h1>Purchase Invoice - {{ $purchase->Ref }}</h1>
    <p>Date: {{ $purchase->date }}</p>
    <p>Supplier: {{ $provider->name ?? '-' }}</p>
    <p>Warehouse: {{ $warehouse->name ?? '-' }}</p>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Cost</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($details as $row)
                <tr>
                    <td>{{ $row->product_name }}</td>
                    <td>{{ $row->quantity }}</td>
                    <td>{{ $row->unit ?? 'Pcs' }}</td>
                    <td>{{ number_format($row->cost, 2) }}</td>
                    <td>{{ number_format($row->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection