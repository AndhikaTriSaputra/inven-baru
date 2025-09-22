@php
    $types = [
        'success' => 'bg-green-50 border-green-200 text-green-800',
        'error' => 'bg-red-50 border-red-200 text-red-800',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
        'info' => 'bg-blue-50 border-blue-200 text-blue-800'
    ];
    
    $icons = [
        'success' => 'M5 13l4 4L19 7',
        'error' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'warning' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z',
        'info' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
    ];
    
    $classes = 'rounded-lg border px-6 py-4 shadow-sm ' . $types[$type];
@endphp

<div class="{{ $classes }} {{ $class }}">
    <div class="flex items-center space-x-3">
        <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icons[$type] }}"/>
            </svg>
        </div>
        <div class="flex-1">
            <p class="font-semibold">{{ ucfirst($type) }}!</p>
            <p class="text-sm">{{ $slot }}</p>
        </div>
    </div>
</div>
