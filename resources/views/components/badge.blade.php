@props([
    'variant' => 'primary',
    'size' => 'md'
])

@php
$baseClasses = 'badge';
$variantClasses = [
    'primary' => 'badge-primary',
    'success' => 'badge-success',
    'warning' => 'badge-warning',
    'error' => 'badge-error',
    'gray' => 'badge-gray'
];
$sizeClasses = [
    'sm' => 'text-xs px-1.5 py-0.5',
    'md' => 'text-xs px-2 py-1',
    'lg' => 'text-sm px-2.5 py-1.5'
];

$classes = $baseClasses . ' ' . $variantClasses[$variant] . ' ' . $sizeClasses[$size];
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
