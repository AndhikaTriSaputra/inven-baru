@extends('layouts.app')

@section('header')
Print Purchase
@endsection

@section('content')
<div class="bg-white border border-gray-200 rounded-xl p-6">
    <div class="flex items-center justify-between mb-6 print:hidden">
        <div class="flex items-center gap-2">
            <a href="{{ route('purchases.show',$purchase->id) }}" class="px-3 py-2 rounded border text-sm">Back</a>
            <button onclick="window.print()" class="px-3 py-2 rounded bg-indigo-500 text-white text-sm">Print</button>
        </div>
    </div>

    <h2 class="text-center text-xl font-semibold mb-6">Purchase Detail : {{ $purchase->Ref }}</h2>

    @include('purchases.export-pdf')
</div>
@endsection

@push('scripts')
<script>
    (function(){
        if (window.matchMedia && window.matchMedia('print').matches) return;
        setTimeout(function(){ window.print(); }, 200);
    })();
</script>
@endpush

@push('styles')
<style>
    @media print {
        header, nav, aside, #sidebar, #quickMenu, .print\:hidden { display: none !important; }
        main { margin: 0 !important; padding: 0 !important; width: 100% !important; }
        .p-6 { padding: 0 !important; }
        body { margin: 0; }
        @page { margin: 12mm; }
    }
    .bg-white.border.border-gray-200.rounded-xl.p-6 { padding: 0; border: 0; border-radius: 0; }
</style>
@endpush