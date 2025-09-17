@props(['href'=>'#','active'=>false,'icon'=>null])

@php
$base = 'group flex items-center gap-4 px-6 py-5 border-b border-slate-100 transition hover:bg-violet-50/40';
@endphp

<a href="{{ $href }}" class="{{ $base }} {{ $active ? 'bg-violet-50/60' : 'bg-white' }}">
  <div class="w-12 h-12 grid place-items-center rounded-xl border border-slate-200">
    @switch($icon)
      @case('stats')   @php $p='M4 19h16M7 16V8M12 16V5M17 16v-6'; @endphp @break
      @case('tag')     @php $p='M3 12l7.5 7.5a2 2 0 002.8 0L21 12l-8.5-8.5H6a3 3 0 00-3 3v5z'; $extra='<circle cx="9" cy="9" r="1.5"/>'; @endphp @break
      @case('warehouse') @php $p='M3 10l9-5 9 5v9a2 2 0 01-2 2H5a2 2 0 01-2-2v-9z'; $extra='<path d="M7 21v-8h10v8"/>'; @endphp @break
      @case('adjust')  @php $p='M4 4h10v6h6v10a2 2 0 01-2 2H4z'; $extra='<path d="M14 4l6 6M9 15l8-8"/>'; @endphp @break
      @case('receipt') @php $p='M6 3h12v18l-3-2-3 2-3-2-3 2z'; $extra='<path d="M9 8h6M9 12h6M9 16h6"/>'; @endphp @break
      @case('swap')    @php $p='M7 7h11M7 7l3-3M7 7l3 3M17 17H6M17 17l-3-3M17 17l-3 3'; @endphp @break
      @default         @php $p='M12 3a9 9 0 100 18 9 9 0 000-18z'; @endphp
    @endswitch
    <svg viewBox="0 0 24 24" class="w-7 h-7 {{ $active ? 'text-violet-500' : 'text-slate-700' }}" fill="none" stroke="currentColor" stroke-width="1.6">
      <path d="{{ $p }}"/>{!! $extra ?? '' !!}
    </svg>
  </div>
  <span class="font-medium text-slate-800" x-show="$root.open">{{ $slot }}</span>
</a>
