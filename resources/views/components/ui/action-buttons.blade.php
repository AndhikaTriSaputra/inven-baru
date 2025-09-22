<div class="flex items-center gap-2 justify-end {{ $class }}">
    @if($view)
        <a href="{{ $view }}" class="w-8 h-8 rounded-full border border-blue-300 text-blue-600 hover:bg-blue-50 grid place-items-center transition-colors duration-200" title="View">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7Z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
        </a>
    @endif
    
    @if($edit)
        <a href="{{ $edit }}" class="w-8 h-8 rounded-full border border-emerald-300 text-emerald-600 hover:bg-emerald-50 grid place-items-center transition-colors duration-200" title="Edit">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M12 20h9"/>
                <path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5Z"/>
            </svg>
        </a>
    @endif
    
    @if($delete)
        <button onclick="{{ $delete }}" class="w-8 h-8 rounded-full border border-rose-300 text-rose-600 hover:bg-rose-50 grid place-items-center transition-colors duration-200" title="Delete">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M3 6h18"/>
                <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                <path d="M10 11v6"/>
                <path d="M14 11v6"/>
                <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
            </svg>
        </button>
    @endif
</div>
