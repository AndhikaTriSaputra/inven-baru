@props([
    'title' => null,
    'subtitle' => null,
    'header' => null,
    'footer' => null,
    'hover' => true
])

<div {{ $attributes->merge(['class' => 'card' . ($hover ? '' : ' hover:shadow-sm')]) }}>
    @if($header || $title || $subtitle)
        <div class="card-header">
            @if($header)
                {{ $header }}
            @else
                @if($title)
                    <h3 class="card-title">{{ $title }}</h3>
                @endif
                @if($subtitle)
                    <p class="card-subtitle">{{ $subtitle }}</p>
                @endif
            @endif
        </div>
    @endif
    
    <div class="card-body">
        {{ $slot }}
    </div>
    
    @if($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>
