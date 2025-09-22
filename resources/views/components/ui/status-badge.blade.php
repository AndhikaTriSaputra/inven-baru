@php
    $colors = [
        'green' => 'bg-green-100 text-green-800 border-green-200',
        'red' => 'bg-red-100 text-red-800 border-red-200',
        'yellow' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'blue' => 'bg-blue-100 text-blue-800 border-blue-200',
        'gray' => 'bg-gray-100 text-gray-800 border-gray-200',
        'violet' => 'bg-violet-100 text-violet-800 border-violet-200',
        'orange' => 'bg-orange-100 text-orange-800 border-orange-200'
    ];
    
    $classes = 'inline-flex items-center rounded-full border font-medium px-2.5 py-1 text-xs ' . $colors[$color];
@endphp

<span class="{{ $classes }} {{ $class }}">
    {{ $slot }}
</span>
