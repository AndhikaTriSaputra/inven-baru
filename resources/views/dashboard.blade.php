dashboard.blade.php

@extends('layouts.app')
@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-5">
  <x-ui.card class="p-6 flex items-center gap-4">
    <div class="w-16 h-16 rounded-2xl bg-violet-50 grid place-items-center">
      <svg class="w-9 h-9 text-violet-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
        <path d="M3 7h18M5 7v10a2 2 0 002 2h10a2 2 0 002-2V7"/>
      </svg>
    </div>
    <div>
      <div class="muted text-sm">Product</div>
      <div class="text-4xl font-semibold" style="color:var(--violet)">{{ number_format($stats['products']) }}</div>
    </div>
  </x-ui.card>

  <x-ui.card class="p-6 flex items-center gap-4">
    <div class="w-16 h-16 rounded-2xl bg-violet-50 grid place-items-center">
      <svg class="w-9 h-9 text-violet-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
        <path d="M3 5h2l1 12a2 2 0 002 2h8a2 2 0 002-2l1-9H6"/>
      </svg>
    </div>
    <div>
      <div class="muted text-sm">Purchases</div>
      <div class="text-4xl font-semibold" style="color:var(--violet)">{{ number_format($stats['purchases']) }}</div>
    </div>
  </x-ui.card>

  <x-ui.card class="p-6 flex items-center gap-4">
    <div class="w-16 h-16 rounded-2xl bg-violet-50 grid place-items-center">
      <svg class="w-9 h-9 text-violet-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
        <path d="M3 12l9-7 9 7-2 1v7H5v-7z"/>
      </svg>
    </div>
    <div>
      <div class="muted text-sm">Warehouse</div>
      <div class="text-4xl font-semibold" style="color:var(--violet)">{{ number_format($stats['warehouses']) }}</div>
    </div>
  </x-ui.card>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mt-5">
  <x-ui.card class="pt-6 pb-6 px-6 lg:col-span-2">
    <div class="mb-3 font-medium">This Week</div>
    <div class="chart-wrapper">
      <div class="chart-container">
        <canvas id="purchasesChart"></canvas>
      </div>
    </div>
  </x-ui.card>

  <x-ui.card class="p-6 overflow-auto">
    <div class="mb-3 font-medium">Recent Purchase</div>
    {{-- tabel recent purchases (punyamu) --}}
  </x-ui.card>
</div>

<x-ui.card class="p-6 mt-5">
  {{-- filter + tabel warehouse products (punyamu) --}}
</x-ui.card>

@push('styles')
<style>
  .chart-wrapper {
    height: 150px !important;
    width: 100% !important;
    overflow: hidden !important;
    position: relative !important;
  }
  .chart-container {
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    height: 150px !important;
    width: 100% !important;
  }
  #purchasesChart {
    width: 100% !important;
    height: 150px !important;
    max-width: 100% !important;
    max-height: 150px !important;
    display: block !important;
  }
</style>
@endpush

@push('scripts')
<script>
  const ctx = document.getElementById('purchasesChart');
if (ctx) {
  // Set canvas size explicitly
  ctx.width = ctx.offsetWidth;
  ctx.height = 150;
  
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
        pointRadius: 4,
        pointHoverRadius: 6,
        pointBackgroundColor: '#7c3aed',
        pointBorderColor: '#ffffff',
        pointBorderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      aspectRatio: 3,
      layout: {
        padding: {
          top: 0,
          bottom: 0,
          left: 0,
          right: 0
        }
      },
      devicePixelRatio: 1,
      plugins: {
        legend: {
          display: true,
          position: 'top',
          align: 'end',
          labels: { 
            color: '#475569',
            font: {
              size: 8
            },
            padding: 1,
            boxWidth: 8
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          suggestedMax: {{ $chart['max'] }},
          grid: { 
            color: '#eef2ff',
            drawBorder: false
          },
          ticks: { 
            color: '#64748b',
            font: {
              size: 7
            },
            padding: 1,
            maxTicksLimit: 3
          }
        },
        x: {
          grid: { display: false },
          ticks: {
            color: '#64748b',
            font: {
              size: 7
            },
            maxRotation: 0,
            padding: 1,
            maxTicksLimit: 7,
            callback: function(value, index, values) {
              const date = new Date(this.getLabelForValue(value));
              return date.toLocaleDateString('id-ID', { 
                day: '2-digit', 
                month: '2-digit' 
              });
            }
          }
        }
      },
      interaction: {
        intersect: false,
        mode: 'index'
      },
      elements: {
        point: {
          radius: 1,
          hoverRadius: 3
        }
      }
    }
  });
}
</script>
@endpush
@endsection