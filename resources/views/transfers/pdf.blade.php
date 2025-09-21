@extends('layouts.print')

@section('content')
<h2>Transfer Report</h2>
<p><strong>Generated:</strong> {{ date('Y-m-d H:i:s') }}</p>
<p><strong>Total Records:</strong> {{ count($data) }}</p>
<hr>
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Reference</th>
            <th>From Warehouse</th>
            <th>To Warehouse</th>
            <th>Items</th>
            <th>Status</th>
            <th>Category</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $transfer)
        <tr>
            <td>{{ $transfer->date }}</td>
            <td>{{ $transfer->reference }}</td>
            <td>{{ $transfer->from_wh }}</td>
            <td>{{ $transfer->to_wh }}</td>
            <td>{{ number_format($transfer->items, 2) }}</td>
            <td>{{ ucfirst($transfer->statut) }}</td>
            <td>{{ $transfer->category }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection