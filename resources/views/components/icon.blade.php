@props([
    'name' => 'default',
    'size' => 'md'
])

@php
$sizeClasses = [
    'xs' => 'w-3 h-3',
    'sm' => 'w-4 h-4',
    'md' => 'w-5 h-5',
    'lg' => 'w-6 h-6',
    'xl' => 'w-8 h-8'
];

$classes = $sizeClasses[$size];
@endphp

@switch($name)
    @case('plus')
        <svg {{ $attributes->merge(['class' => $classes]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        @break
    @case('edit')
        <svg {{ $attributes->merge(['class' => $classes]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
        @break
    @case('delete')
        <svg {{ $attributes->merge(['class' => $classes]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
        @break
    @case('view')
        <svg {{ $attributes->merge(['class' => $classes]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>
        @break
    @case('search')
        <svg {{ $attributes->merge(['class' => $classes]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        @break
    @case('filter')
        <svg {{ $attributes->merge(['class' => $classes]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
        </svg>
        @break
    @case('download')
        <svg {{ $attributes->merge(['class' => $classes]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        @break
    @case('upload')
        <svg {{ $attributes->merge(['class' => $classes]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
        </svg>
        @break
    @case('print')
        <svg {{ $attributes->merge(['class' => $classes]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
        </svg>
        @break
    @case('check')
        <svg {{ $attributes->merge(['class' => $classes]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        @break
    @case('close')
        <svg {{ $attributes->merge(['class' => $classes]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        @break
    @case('arrow-left')
        <svg {{ $attributes->merge(['class' => $classes]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        @break
    @case('arrow-right')
        <svg {{ $attributes->merge(['class' => $classes]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
        </svg>
        @break
    @case('menu')
        <svg {{ $attributes->merge(['class' => $classes]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        @break
    @case('dashboard')
        <svg {{ $attributes->merge(['class' => $classes]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M4.5 10.5V21h5.25v-6h4.5v6H19.5V10.5"/>
        </svg>
        @break
    @case('products')
        <svg {{ $attributes->merge(['class' => $classes]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 4.5h12v15L12 15l-6 4.5v-15z"/>
        </svg>
        @break
    @case('warehouse')
        <svg {{ $attributes->merge(['class' => $classes]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l1.5-4.5h15L21 9M4.5 9H21v10.5H3V9h1.5zm3 0v10.5m7.5-10.5v10.5"/>
        </svg>
        @break
	    @case('qr-code')
	        <svg {{ $attributes->merge(['class' => $classes]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor">
	            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h6v6H4V4zm0 10h6v6H4v-6zm10-10h6v6h-6V4zm3 10h3v3h-3v-3zm-3 3h2v3h-2v-3zm3-3h-3v-2h3v2z"/>
	        </svg>
	        @break
	    @case('barcode')
	        <svg {{ $attributes->merge(['class' => $classes]) }} viewBox="0 0 24 24" fill="currentColor">
	            <rect x="3" y="5" width="1" height="14"/>
	            <rect x="5" y="5" width="2" height="14"/>
	            <rect x="8" y="5" width="1" height="14"/>
	            <rect x="10" y="5" width="3" height="14"/>
	            <rect x="14" y="5" width="1" height="14"/>

	            <rect x="16" y="5" width="2" height="14"/>
	            <rect x="19" y="5" width="1" height="14"/>
	        </svg>
	        @break
    @default
        <svg {{ $attributes->merge(['class' => $classes]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
@endswitch

