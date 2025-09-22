@php
    $baseClasses = 'w-full border border-gray-300 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-violet-100 focus:border-violet-500 disabled:opacity-50 disabled:cursor-not-allowed';
    $classes = $baseClasses . ' px-3 py-2 text-sm';
@endphp

<input 
    type="{{ $type }}" 
    name="{{ $name }}" 
    placeholder="{{ $placeholder }}" 
    value="{{ $value }}" 
    {{ $required ? 'required' : '' }}
    class="{{ $classes }} {{ $class }}"
>
