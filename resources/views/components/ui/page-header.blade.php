<div class="flex items-center justify-between mb-6">
    <div class="flex items-baseline gap-3">
        <h1 class="text-2xl font-semibold text-gray-900">{{ $title }}</h1>
        @if($breadcrumb)
            <div class="text-sm text-gray-500">{{ $breadcrumb }}</div>
        @endif
    </div>
    
    @if($actions)
        <div class="flex items-center space-x-3">
            {!! $actions !!}
        </div>
    @endif
</div>
