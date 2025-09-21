<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Count Report #{{ $stockCount->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: white;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }
        .info-item {
            text-align: center;
        }
        .info-item h3 {
            margin: 0 0 5px 0;
            color: #333;
            font-size: 14px;
            font-weight: bold;
        }
        .info-item p {
            margin: 0;
            color: #666;
            font-size: 16px;
        }
        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status.pending {
            background: #fef3cd;
            color: #856404;
        }
        .status.in_progress {
            background: #d1ecf1;
            color: #0c5460;
        }
        .status.completed {
            background: #d4edda;
            color: #155724;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .difference {
            font-weight: bold;
        }
        .difference.positive {
            color: #28a745;
        }
        .difference.negative {
            color: #dc3545;
        }
        .difference.zero {
            color: #6c757d;
        }
        .summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
        }
        .summary h3 {
            margin: 0 0 20px 0;
            color: #333;
        }
        .summary-grid {
            display: flex;
            justify-content: space-around;
            text-align: center;
        }
        .summary-item h4 {
            margin: 0 0 5px 0;
            color: #333;
            font-size: 18px;
        }
        .summary-item p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Stock Count Report</h1>
        <p>Report #{{ $stockCount->id }}</p>
        <p>Generated on {{ date('M d, Y H:i') }}</p>
    </div>

    <div class="info-section">
        <div class="info-item">
            <h3>Date</h3>
            <p>{{ \Carbon\Carbon::parse($stockCount->date)->format('M d, Y') }}</p>
        </div>
        <div class="info-item">
            <h3>Warehouse</h3>
            <p>{{ $stockCount->warehouse_name ?? 'Unknown Warehouse' }}</p>
        </div>
        <div class="info-item">
            <h3>Status</h3>
            <span class="status {{ $stockCount->status }}">{{ ucfirst($stockCount->status) }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Brand</th>
                <th>Unit</th>
                <th>Expected Qty</th>
                <th>Counted Qty</th>
                <th>Difference</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>{{ $product->product_code ?? '-' }}</td>
                <td>{{ $product->product_name ?? '-' }}</td>
                <td>{{ $product->brand ?? '-' }}</td>
                <td>{{ $product->unit ?? '-' }}</td>
                <td>{{ $product->expected_quantity ?? 0 }}</td>
                <td>{{ $product->counted_quantity ?? 0 }}</td>
                <td>
                    @php
                        $expected = $product->expected_quantity ?? 0;
                        $counted = $product->counted_quantity ?? 0;
                        $difference = $counted - $expected;
                    @endphp
                    <span class="difference 
                        @if($difference > 0) positive
                        @elseif($difference < 0) negative
                        @else zero
                        @endif">
                        @if($difference > 0)+@endif{{ $difference }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; color: #666;">No products found for this stock count.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($products->count() > 0)
    <div class="summary">
        <h3>Summary</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <h4>{{ $products->count() }}</h4>
                <p>Total Products</p>
            </div>
            <div class="summary-item">
                <h4 style="color: #28a745;">{{ $products->where('counted_quantity', '>', 'expected_quantity')->count() }}</h4>
                <p>Over Count</p>
            </div>
            <div class="summary-item">
                <h4 style="color: #dc3545;">{{ $products->where('counted_quantity', '<', 'expected_quantity')->count() }}</h4>
                <p>Under Count</p>
            </div>
        </div>
    </div>
    @endif

    <div class="footer">
        <p>This report was generated automatically by the Inventory Management System</p>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
