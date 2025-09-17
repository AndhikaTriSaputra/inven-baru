<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>POS Inventory</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gray-50 text-gray-800">
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <aside class="w-24 bg-white border-r border-gray-200 relative">
                <div class="h-16 flex items-center justify-center">
                    <div class="h-10 w-10 rounded-full bg-violet-100 text-violet-600 flex items-center justify-center font-semibold">S</div>
                </div>
                <nav class="pb-6">
                    @php
                        $items = [
                            ['label' => 'Dashboard', 'href' => url('/app/dashboard'), 'active' => request()->is('app/dashboard'), 'icon' => 'dashboard'],
                            [
                                'label' => 'Products', 
                                'href' => url('/app/products/create'), 
                                'active' => request()->is('app/products*'), 
                                'icon' => 'bookmark',
                                'submenu' => [
                                    ['label' => 'Create Product', 'href' => url('/app/products/create'), 'active' => request()->is('app/products/create'), 'icon' => 'create'],
                                    ['label' => 'All Products', 'href' => url('/app/products'), 'active' => request()->is('app/products') && !request()->is('app/products/create'), 'icon' => 'all'],
                                    ['label' => 'Print Labels', 'href' => url('/app/products/labels'), 'active' => request()->is('app/products/labels*'), 'icon' => 'print'],
                                    ['label' => 'Count Stock', 'href' => url('/app/products/stock-count'), 'active' => request()->is('app/products/stock-count*'), 'icon' => 'count'],
                                    ['label' => 'Category', 'href' => url('/app/categories'), 'active' => request()->is('app/categories*'), 'icon' => 'category'],
                                    ['label' => 'Brand', 'href' => url('/app/brands'), 'active' => request()->is('app/brands*'), 'icon' => 'brand'],
                                    ['label' => 'Unit', 'href' => url('/app/units'), 'active' => request()->is('app/units*'), 'icon' => 'unit'],
                                ]
                            ],
                            ['label' => 'Warehouse', 'href' => url('/app/warehouses'), 'active' => request()->is('app/warehouses*'), 'icon' => 'store'],
                            ['label' => 'Adjustment', 'href' => url('/app/adjustments'), 'active' => request()->is('app/adjustments*'), 'icon' => 'wrench'],
                            ['label' => 'Purchases', 'href' => url('/app/purchases'), 'active' => request()->is('app/purchases*'), 'icon' => 'receipt'],
                            ['label' => 'Transfer', 'href' => url('/app/transfers'), 'active' => request()->is('app/transfers*'), 'icon' => 'transfer'],
                        ];
                    @endphp
                    <ul class="flex flex-col gap-6 mt-2">
                        @foreach($items as $item)
                            <li>
                                @if(isset($item['submenu']))
                                    <!-- Main item with submenu -->
                                    <div class="relative">
                                        <button onclick="toggleSubmenu()" class="relative flex flex-col items-center text-[11px] text-gray-600 hover:text-violet-600 w-full">
                                            @if($item['active'])
                                                <span class="absolute left-0 top-1/2 -translate-y-1/2 h-10 w-1 rounded-r bg-violet-500"></span>
                                            @endif
                                            <span class="mb-2 rounded-lg h-12 w-12 flex items-center justify-center border {{ $item['active'] ? 'border-violet-300 text-violet-600 bg-violet-50' : 'border-gray-200 bg-white' }}">
                                                @switch($item['icon'])
                                                    @case('dashboard')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l9-9 9 9M4.5 10.5V21h5.25v-6h4.5v6H19.5V10.5"/></svg>
                                                        @break
                                                    @case('bookmark')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 4.5h12v15L12 15l-6 4.5v-15z"/></svg>
                                                        @break
                                                    @case('store')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9l1.5-4.5h15L21 9M4.5 9H21v10.5H3V9h1.5zm3 0v10.5m7.5-10.5v10.5"/></svg>
                                                        @break
                                                    @case('wrench')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.25 6.75a3.75 3.75 0 11-4.5 4.5L3 18.75 5.25 21l6.75-6.75a3.75 3.75 0 004.5-4.5l-2.25-3z"/></svg>
                                                        @break
                                                    @case('receipt')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 3.75h12v16.5l-3-1.5-3 1.5-3-1.5-3 1.5V3.75zM8.25 7.5h7.5M8.25 10.5h7.5M8.25 13.5h4.5"/></svg>
                                                        @break
                                                    @case('transfer')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.5 12h9m0 0l-3-3m3 3l-3 3M6 6h3M6 18h3"/></svg>
                                                        @break
                                                @endswitch
                                            </span>
                                            <span class="block text-center leading-tight {{ $item['active'] ? 'text-violet-600' : '' }}">{{ $item['label'] }}</span>
                                        </button>
                                    </div>
                                @else
                                    <!-- Regular item without submenu -->
                                    <a href="{{ $item['href'] }}" class="relative flex flex-col items-center text-[11px] text-gray-600 hover:text-violet-600">
                                        @if($item['active'])
                                            <span class="absolute left-0 top-1/2 -translate-y-1/2 h-10 w-1 rounded-r bg-violet-500"></span>
                                        @endif
                                        <span class="mb-2 rounded-lg h-12 w-12 flex items-center justify-center border {{ $item['active'] ? 'border-violet-300 text-violet-600 bg-violet-50' : 'border-gray-200 bg-white' }}">
                                            @switch($item['icon'])
                                                @case('dashboard')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l9-9 9 9M4.5 10.5V21h5.25v-6h4.5v6H19.5V10.5"/></svg>
                                                    @break
                                                @case('bookmark')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 4.5h12v15L12 15l-6 4.5v-15z"/></svg>
                                                    @break
                                                @case('store')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9l1.5-4.5h15L21 9M4.5 9H21v10.5H3V9h1.5zm3 0v10.5m7.5-10.5v10.5"/></svg>
                                                    @break
                                                @case('wrench')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.25 6.75a3.75 3.75 0 11-4.5 4.5L3 18.75 5.25 21l6.75-6.75a3.75 3.75 0 004.5-4.5l-2.25-3z"/></svg>
                                                    @break
                                                @case('receipt')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 3.75h12v16.5l-3-1.5-3 1.5-3-1.5-3 1.5V3.75zM8.25 7.5h7.5M8.25 10.5h7.5M8.25 13.5h4.5"/></svg>
                                                    @break
                                                @case('transfer')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.5 12h9m0 0l-3-3m3 3l-3 3M6 6h3M6 18h3"/></svg>
                                                    @break
                                            @endswitch
                                        </span>
                                        <span class="block text-center leading-tight {{ $item['active'] ? 'text-violet-600' : '' }}">{{ $item['label'] }}</span>
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </nav>
                
                <!-- Submenu Popup -->
                <div id="submenu" class="absolute left-full w-64 bg-white border border-gray-200 rounded-lg shadow-lg transform -translate-x-2 opacity-0 invisible transition-all duration-300 ease-in-out z-50" style="top: 120px;">
                    <!-- Arrow pointing to Products button -->
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-2">
                        <div class="w-0 h-0 border-t-8 border-b-8 border-r-8 border-transparent border-r-violet-500"></div>
                    </div>
                    
                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-gray-800 mb-3">Products</h3>
                        <ul class="space-y-2">
                            @foreach($items[1]['submenu'] as $subItem)
                                <li>
                                    <a href="{{ $subItem['href'] }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-violet-50 transition-colors duration-200 {{ $subItem['active'] ? 'bg-violet-50 text-violet-600' : 'text-gray-600' }}">
                                        <span class="w-8 h-8 flex items-center justify-center">
                                            @switch($subItem['icon'])
                                                @case('create')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                    @break
                                                @case('all')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                    @break
                                                @case('print')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                                    @break
                                                @case('count')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    @break
                                                @case('category')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                                    @break
                                                @case('brand')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                                    @break
                                                @case('unit')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                                    @break
                                            @endswitch
                                        </span>
                                        <span class="text-sm font-medium">{{ $subItem['label'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </aside>

            <!-- Content -->
            <main class="flex-1">
                <header class="h-16 bg-white border-b border-gray-200 flex items-center px-6">@yield('header')</header>
                <div class="p-6">@yield('content')</div>
            </main>
        </div>
    </body>
    
    <script>
        function toggleSubmenu() {
            const submenu = document.getElementById('submenu');
            const isVisible = !submenu.classList.contains('opacity-0');
            
            if (isVisible) {
                // Hide submenu
                submenu.classList.add('opacity-0', 'invisible', '-translate-x-2');
                submenu.classList.remove('opacity-100', 'visible', 'translate-x-0');
            } else {
                // Show submenu
                submenu.classList.remove('opacity-0', 'invisible', '-translate-x-2');
                submenu.classList.add('opacity-100', 'visible', 'translate-x-0');
            }
        }
        
        // Close submenu when clicking outside
        document.addEventListener('click', function(event) {
            const submenu = document.getElementById('submenu');
            const productsButton = event.target.closest('button[onclick="toggleSubmenu()"]');
            
            if (!submenu.contains(event.target) && !productsButton) {
                submenu.classList.add('opacity-0', 'invisible', '-translate-x-2');
                submenu.classList.remove('opacity-100', 'visible', 'translate-x-0');
            }
        });
    </script>
    <!-- Use Iconify or Unocss icons if present; fallback to text if not -->
</html>
