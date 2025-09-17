@extends('layouts.app')
@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-5">
  <div class="card p-6 flex items-center gap-4">
    <div class="w-16 h-16 rounded-2xl bg-violet-50 grid place-items-center">
      <svg class="w-9 h-9 text-violet-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
        <path d="M3 7h18M5 7v10a2 2 0 002 2h10a2 2 0 002-2V7"/>
      </svg>
    </div>
    <div>
      <div class="muted text-sm">Product</div>
      <div class="text-4xl font-semibold" style="color:var(--violet)">{{ number_format($stats['products']) }}</div>
    </div>
  </div>

  <div class="card p-6 flex items-center gap-4">
    <div class="w-16 h-16 rounded-2xl bg-violet-50 grid place-items-center">
      <svg class="w-9 h-9 text-violet-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
        <path d="M3 5h2l1 12a2 2 0 002 2h8a2 2 0 002-2l1-9H6"/>
      </svg>
    </div>
    <div>
      <div class="muted text-sm">Purchases</div>
      <div class="text-4xl font-semibold" style="color:var(--violet)">{{ number_format($stats['purchases']) }}</div>
    </div>
  </div>

  <div class="card p-6 flex items-center gap-4">
    <div class="w-16 h-16 rounded-2xl bg-violet-50 grid place-items-center">
      <svg class="w-9 h-9 text-violet-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
        <path d="M3 12l9-7 9 7-2 1v7H5v-7z"/>
      </svg>
    </div>
    <div>
      <div class="muted text-sm">Warehouse</div>
      <div class="text-4xl font-semibold" style="color:var(--violet)">{{ number_format($stats['warehouses']) }}</div>
    </div>
  </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mt-5">
  <div class="card p-6 lg:col-span-2">
    <div class="mb-3 font-medium">This Week</div>
    <canvas id="purchasesChart" height="120"></canvas>
  </div>

  <div class="card p-6 overflow-auto">
    <div class="mb-3 font-medium">Recent Purchase</div>
    {{-- tabel recent purchases (punyamu) --}}
  </div>
</div>

<div class="card p-6 mt-5">
  {{-- filter + tabel warehouse products (punyamu) --}}
</div>

@push('scripts')
<script>
  const ctx = document.getElementById('purchasesChart');
  if (ctx) {
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: @json($chart['labels']),
        datasets: [{
          label: 'Purchases',
          data: @json($chart['series']),
          borderColor: '#7c3aed',
          backgroundColor: 'rgba(124,58,237,.08)',
          fill: true,
          tension: .35,
          pointRadius: 0
        }]
      },
      options: {
        responsive: true,
        plugins:{ legend:{ display:true, labels:{ color:'#475569' }}},
        scales:{
          y:{ beginAtZero:true, grid:{ color:'#eef2ff' }, ticks:{ color:'#64748b' } },
          x:{ grid:{ display:false }, ticks:{ color:'#c7cce8', maxRotation:0 } }
        }
      }
    });
  }
</script>
@endpush
@endsection
