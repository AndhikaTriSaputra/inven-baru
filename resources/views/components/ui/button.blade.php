@php
    $variants = [
        'primary' => 'bg-violet-600 text-white hover:bg-violet-700 focus:ring-violet-500',
        'secondary' => 'bg-gray-100 text-gray-700 hover:bg-gray-200 focus:ring-gray-500',
        'success' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
        'warning' => 'bg-yellow-600 text-white hover:bg-yellow-700 focus:ring-yellow-500',
        'info' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
        'outline' => 'border border-gray-300 text-gray-700 hover:bg-gray-50 focus:ring-gray-500',
        'ghost' => 'text-gray-700 hover:bg-gray-100 focus:ring-gray-500'
    ];
    
    $sizes = [
        'xs' => 'px-2 py-1 text-xs rounded',
        'sm' => 'px-3 py-1.5 text-sm rounded-md',
        'md' => 'px-4 py-2 text-sm rounded-lg',
        'lg' => 'px-6 py-3 text-base rounded-lg',
        'xl' => 'px-8 py-4 text-lg rounded-xl'
    ];
    
    $baseClasses = 'inline-flex items-center justify-center font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
    $classes = $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size];
@endphp

<button type="{{ $type }}" class="{{ $classes }} {{ $class }}">
    {{ $slot }}
</button>
