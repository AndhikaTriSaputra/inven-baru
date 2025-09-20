export-pdf.blade.php

@php
    $supplier = DB::table('providers')->where('id',$purchase->provider_id)->first();
    $warehouse = DB::table('warehouses')->where('id',$purchase->warehouse_id)->first();
    $paid = (float)($purchase->paid_amount ?? 0);
    $total = 0;
    foreach ($details as $row) { $total += (float)$row->total; }
@endphp

<style>
    @media print {
        .print-hidden { display: none !important; }
    }
    .doc-container { max-width: 800px; margin: 0 auto; }
    .doc-title { font-size: 16px; font-weight: 600; margin-bottom: 16px; }
    .section-title { font-size: 12px; font-weight: 600; margin-bottom: 6px; }
    .muted { color: #6b7280; }
    .badge { display:inline-block; padding: 2px 6px; border-radius: 4px; font-size: 10px; }
    .badge-green { background: #d1fae5; color:#065f46; }
    .badge-yellow { background: #fef3c7; color:#92400e; }
    .table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .table th, .table td { padding: 6px 8px; text-align: left; border-top: 1px solid #e5e7eb; }
    .table thead th { background: #f9fafb; border-top: none; }
    .grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
    .mt-6 { margin-top: 24px; }
    .mb-6 { margin-bottom: 24px; }
    .text-right { text-align: right; }
    .note { font-size: 12px; color: #374151; margin-top: 16px; }
    .divider { height: 1px; background: #e5e7eb; margin: 16px 0; }
    .card { padding: 0; }
    .small { font-size: 11px; }
    .font-medium { font-weight: 600; }
    .w-full { width: 100%; }
    .text-xs { font-size: 11px; }
    .text-sm { font-size: 12px; }
    .text-gray-700 { color: #374151; }
    .text-gray-500 { color: #6b7280; }
    .text-center { text-align: center; }
    .mb-2 { margin-bottom: 8px; }
    .px-4 { padding-left: 16px; padding-right: 16px; }
    .py-2 { padding-top: 8px; padding-bottom: 8px; }
    .bordered { border: 1px solid #e5e7eb; border-radius: 8px; }
    .summary td { border-top: 1px solid #e5e7eb; }
    .summary td:first-child { color: #374151; }
    .page-footer { font-size: 10px; color:#6b7280; text-align:right; margin-top: 12px; }
    /* Remove app layout paddings when embedded */
    body { margin: 0; }
    .container, .bg-white, .border, .rounded-xl, .p-6 { padding: 0; border: 0; border-radius: 0; }
    @page { margin: 16mm 12mm; }
</style>

<div class="doc-container">
    <div class="doc-title">Purchase Detail : {{ $purchase->Ref }}</div>

    <div class="grid mb-6">
        <div>
            <div class="section-title">Supplier Info</div>
            <div class="text-sm text-gray-700">{{ $supplier->name ?? '-' }}</div>
            <div class="text-xs text-gray-500">{{ $supplier->email ?? '' }}</div>
            <div class="text-xs text-gray-500">{{ $supplier->phone ?? '' }}</div>
        </div>
        <div>
            <div class="section-title">Company Info</div>
            <div class="text-sm text-gray-700">Stocky</div>
            <div class="text-xs text-gray-500">admin@example.com</div>
            <div class="text-xs text-gray-500">6315996770</div>
            <div class="text-xs text-gray-500">3618 Abia Martin Drive</div>
        </div>
        <div>
            <div class="section-title">Purchase Info</div>
            <div class="text-xs text-gray-600">Reference : <span class="font-medium">{{ $purchase->Ref }}</span></div>
            <div class="text-xs text-gray-600">Status : <span class="badge badge-green">{{ ucfirst($purchase->statut ?? 'received') }}</span></div>
            <div class="text-xs text-gray-600">Warehouse : <span class="font-medium">{{ $warehouse->name ?? '-' }}</span></div>
            <div class="text-xs text-gray-600">Payment Status : <span class="badge badge-yellow">{{ ucfirst($purchase->payment_statut ?? 'unpaid') }}</span></div>
        </div>
    </div>

    <div class="section-title">Order Summary</div>
    <div class="bordered">
        <table class="table">
            <thead>
                <tr>
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
                @foreach($details as $row)
                @php $subtotal = (float)$row->total; @endphp
                <tr>
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

    <div class="grid mt-6">
        <div></div>
        <div></div>
        <div>
            <table class="w-full table summary">
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
    <div class="note">{{ $purchase->notes }}</div>
    @endif

    <div class="page-footer">1/1</div>
</div>