@php
    $sizes = [
        'sm' => 'max-w-md',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        '2xl' => 'max-w-6xl'
    ];
@endphp

<div class="fixed inset-0 z-50 hidden {{ $class }}" id="{{ $id }}">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="w-full {{ $sizes[$size] }} bg-white rounded-xl shadow-xl border border-gray-200">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">{{ $title ?? 'Modal' }}</h3>
                <button type="button" onclick="this.closest('[id]').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
