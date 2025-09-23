@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'disabled' => false,
    'loading' => false,
    'icon' => null,
    'iconPosition' => 'left'
])

@php
$baseClasses = 'btn';
$variantClasses = [
    'primary' => 'btn-primary',
    'secondary' => 'btn-secondary',
    'success' => 'btn-success',
    'warning' => 'btn-warning',
    'error' => 'btn-error',
    'ghost' => 'btn-ghost'
];
$sizeClasses = [
    'sm' => 'btn-sm',
    'md' => '',
    'lg' => 'btn-lg',
    'xl' => 'btn-xl'
];

$classes = $baseClasses . ' ' . $variantClasses[$variant] . ' ' . $sizeClasses[$size];
if ($loading) $classes .= ' loading';
@endphp

<{{ $type === 'link' ? 'a' : 'button' }}
    {{ $attributes->merge(['class' => $classes]) }}
    @if($type !== 'link') type="{{ $type }}" @endif
    @if($disabled || $loading) disabled @endif
    @if($type === 'link' && isset($attributes['href'])) href="{{ $attributes['href'] }}" @endif
>
    @if($icon && $iconPosition === 'left')
        <x-icon :name="$icon" class="w-4 h-4" />
    @endif
    
    @if($loading)
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @endif
    
    {{ $slot }}
    
    @if($icon && $iconPosition === 'right')
        <x-icon :name="$icon" class="w-4 h-4" />
    @endif
</{{ $type === 'link' ? 'a' : 'button' }}>
