@extends('layouts.app')

@section('header')
@include('components.header')
@endsection

@section('page-title')
Dashboard
@endsection

@section('content')
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Product</p>
                    <p class="text-3xl font-bold text-violet-600">{{ $stats['products'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-violet-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Purchases</p>
                    <p class="text-3xl font-bold text-violet-600">{{ $stats['purchases'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-violet-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                        <!-- receipt outline with zigzag bottom -->
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M7 3h10a2 2 0 0 1 2 2v14l-2-1.5-2 1.5-2-2-2 2-2-2-2 2V5a2 2 0 0 1 2-2z" />
                        <!-- lines inside receipt -->
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 8h6M9 12h6M9 16h3" />
                      </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-6 relative">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Warehouse</p>
                    <p class="text-3xl font-bold text-violet-600">{{ $stats['warehouses'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-violet-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>
            {{-- <button class="absolute top-4 right-4 p-1 text-violet-600 hover:text-violet-800">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </button> --}}
        </div>
    </div>

    <!-- Charts and Recent Activity -->
    <div class="grid gap-6 lg:grid-cols-2">
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">This Week</h3>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-violet-600 rounded"></div>
                    <span class="text-sm text-gray-600">Purchases</span>
                </div>
            </div>
            <div class="h-64"><canvas id="weeklyChart"></canvas></div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Purchase</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-2 text-gray-600">Date</th>
                            <th class="text-left py-2 text-gray-600">Reference</th>
                            <th class="text-left py-2 text-gray-600">Warehouse</th>
                            <th class="text-left py-2 text-gray-600">Supplier</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPurchases ?? [] as $purchase)
                        <tr class="border-b border-gray-100">
                            <td class="py-2">{{ $purchase->date }}</td>
                            <td class="py-2">{{ $purchase->reference }}</td>
                            <td class="py-2">{{ $purchase->warehouse }}</td>
                            <td class="py-2">{{ $purchase->supplier }}</td>
                        </tr>
                        @empty
                        <tr class="border-b border-gray-100"><td class="py-2">—</td><td class="py-2">—</td><td class="py-2">—</td><td class="py-2">—</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Warehouse Products</h3>
            <div class="flex items-center space-x-4">
                <label class="text-sm text-gray-600">Filter</label>
                <form method="GET">
                    <select name="warehouse_id" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-violet-500" onchange="this.form.submit()">
                        <option value="">Choose Warehouse</option>
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}" {{ ($selectedWarehouse ?? null)==$w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 text-gray-600">Product Name</th>
                        <th class="text-left py-3 text-gray-600">Type</th>
                        <th class="text-left py-3 text-gray-600">Code</th>
                        <th class="text-left py-3 text-gray-600">Warehouse</th>
                        <th class="text-left py-3 text-gray-600">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(($rows ?? []) as $index => $row)
                    <tr class="border-b border-gray-100 {{ $index==2 ? 'bg-gray-50' : '' }}">
                        <td class="py-3">{{ $row->product_name }}</td>
                        <td class="py-3">{{ $row->type }}</td>
                        <td class="py-3">{{ $row->code }}</td>
                        <td class="py-3">{{ $row->warehouse }}</td>
                        <td class="py-3">{{ $row->qty }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200">
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-600">Rows per page:</span>
                <select class="border border-gray-300 rounded px-2 py-1 text-sm"><option>10</option><option>25</option><option>50</option></select>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">{{ ($rows->currentPage() ?? 1) }} / {{ ($rows->lastPage() ?? 1) }}</span>
                <div class="flex space-x-2">
                    {!! ($rows->withQueryString()->onEachSide(0)->links('pagination::simple-tailwind')) !!}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('weeklyChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chart['labels'] ?? []),
            datasets: [{
                label: 'Purchases',
                data: @json($chart['series'] ?? []),
                borderColor: '#7c3aed',
                backgroundColor: 'rgba(124,58,237,0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true, max:1, ticks:{stepSize:0.2}}}}
    });

</script>
@endsection


