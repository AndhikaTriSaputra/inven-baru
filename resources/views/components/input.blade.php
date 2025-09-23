@props([
    'type' => 'text',
    'label' => null,
    'required' => false,
    'error' => null,
    'help' => null,
    'placeholder' => null,
    'disabled' => false,
    'readonly' => false
])

<div class="form-group">
    @if($label)
        <label class="form-label {{ $required ? 'required' : '' }}">
            {{ $label }}
        </label>
    @endif
    
    @if($type === 'textarea')
        <textarea
            {{ $attributes->merge(['class' => 'form-textarea' . ($error ? ' error' : '')]) }}
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
        >{{ $attributes->get('value') }}</textarea>
    @elseif($type === 'select')
        <select
            {{ $attributes->merge(['class' => 'form-select' . ($error ? ' error' : '')]) }}
            @if($disabled) disabled @endif
        >
            {{ $slot }}
        </select>
    @else
        <input
            type="{{ $type }}"
            {{ $attributes->merge(['class' => 'form-input' . ($error ? ' error' : '')]) }}
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
        />
    @endif
    
    @if($error)
        <div class="form-error">{{ $error }}</div>
    @endif
    
    @if($help)
        <div class="form-help">{{ $help }}</div>
    @endif
</div>
