@props([
    'headers' => [],
    'data' => [],
    'striped' => true,
    'hover' => true,
    'responsive' => true
])

<div class="{{ $responsive ? 'table-container' : '' }}">
    <table class="table {{ $striped ? 'table-striped' : '' }} {{ $hover ? 'table-hover' : '' }}">
        @if(!empty($headers))
            <thead>
                <tr>
                    @foreach($headers as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif
        
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
