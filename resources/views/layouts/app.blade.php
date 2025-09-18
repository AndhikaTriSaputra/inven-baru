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
            <aside id="sidebar" class="w-24 bg-white border-r border-gray-200 relative transition-all duration-300">
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
                            ['label' => 'Adjustment', 'href' => url('/app/adjustments'), 'active' => request()->is('app/adjustments*'), 'icon' => 'wrench', 'drawer' => 'adjustments'],
                            ['label' => 'Purchases', 'href' => url('/app/purchases'), 'active' => request()->is('app/purchases*'), 'icon' => 'receipt', 'drawer' => 'purchases'],
                            ['label' => 'Transfer', 'href' => url('/app/transfers'), 'active' => request()->is('app/transfers*'), 'icon' => 'transfer', 'drawer' => 'transfers'],
                        ];
                    @endphp
                    <ul class="flex flex-col gap-6 mt-2">
                        @foreach($items as $item)
                            <li>
                                @if(isset($item['submenu']))
                                    <!-- Main item with submenu -->
                                    <div class="relative">
                                        <button onclick="openQuickMenu('products')" data-sidebar-item="products" data-active="{{ $item['active'] ? 1 : 0 }}" class="relative flex flex-col items-center text-[11px] text-gray-600 hover:text-violet-600 w-full sidebar-item">
                                            <span class="absolute left-0 top-1/2 -translate-y-1/2 h-10 w-1 rounded-r bg-violet-500 sidebar-active-indicator @if(!$item['active']) hidden @endif"></span>
                                            <span class="mb-2 rounded-lg h-12 w-12 flex items-center justify-center border sidebar-icon {{ $item['active'] ? 'border-violet-300 text-violet-600 bg-violet-50' : 'border-gray-200 bg-white' }}">
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
                                            <span class="block text-center leading-tight sidebar-text {{ $item['active'] ? 'text-violet-600' : '' }}">{{ $item['label'] }}</span>
                                        </button>
                                    </div>
                                @elseif(isset($item['drawer']))
                                    <!-- Item that opens right drawer instead of direct navigate -->
                                    <div class="relative">
                                        <button onclick="openQuickMenu('{{ $item['drawer'] }}')" data-sidebar-item="{{ $item['drawer'] }}" data-active="{{ $item['active'] ? 1 : 0 }}" class="relative flex flex-col items-center text-[11px] text-gray-600 hover:text-violet-600 w-full sidebar-item">
                                            <span class="absolute left-0 top-1/2 -translate-y-1/2 h-10 w-1 rounded-r bg-violet-500 sidebar-active-indicator @if(!$item['active']) hidden @endif"></span>
                                            <span class="mb-2 rounded-lg h-12 w-12 flex items-center justify-center border sidebar-icon {{ $item['active'] ? 'border-violet-300 text-violet-600 bg-violet-50' : 'border-gray-200 bg-white' }}">
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
                                            <span class="block text-center leading-tight sidebar-text {{ $item['active'] ? 'text-violet-600' : '' }}">{{ $item['label'] }}</span>
                                        </button>
                                    </div>
                                @else
                                    <!-- Regular item without submenu -->
                                    <a href="{{ $item['href'] }}" data-active="{{ $item['active'] ? 1 : 0 }}" class="relative flex flex-col items-center text-[11px] text-gray-600 hover:text-violet-600 sidebar-item">
                                        @if($item['active'])
                                            <span class="absolute left-0 top-1/2 -translate-y-1/2 h-10 w-1 rounded-r bg-violet-500 sidebar-active-indicator"></span>
                                        @endif
                                        <span class="mb-2 rounded-lg h-12 w-12 flex items-center justify-center border sidebar-icon {{ $item['active'] ? 'border-violet-300 text-violet-600 bg-violet-50' : 'border-gray-200 bg-white' }}">
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
                                        <span class="block text-center leading-tight sidebar-text {{ $item['active'] ? 'text-violet-600' : '' }}">{{ $item['label'] }}</span>
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </nav>
                
                <!-- Right Drawer Submenu (populated via templates) -->
                <div id="quickMenu" class="fixed top-16 left-24 bottom-0 w-80 bg-white border-l border-gray-200 shadow-2xl transform opacity-0 invisible transition-all duration-300 ease-in-out z-50">
                    <div id="quickMenuBody" class="p-6 space-y-6"></div>
                </div>
            </aside>

            <!-- Content -->
            <main class="flex-1">
                <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6">
                    <!-- Left side - Page title -->
                    <div class="flex items-center">
                        <button type="button" onclick="toggleSidebar()" class="mr-3 p-2 rounded hover:bg-gray-100" aria-label="Toggle sidebar">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                    @yield('header')
                    </div>
                    
                    <!-- Right side - Header Menu -->
                    <div class="flex items-center space-x-4">
                        <!-- POS Menu -->
                        <div class="relative">
                            <a href="{{ url('/app/pos') }}" class="flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-700 hover:text-violet-600 hover:bg-violet-50 rounded-lg transition-colors duration-200 {{ request()->is('app/pos*') ? 'text-violet-600 bg-violet-50' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"/>
                                </svg>
                                <span>POS</span>
                            </a>
                        </div>

                        <!-- Fullscreen/Zoom Toggle -->
                        <button onclick="toggleFullscreen()" class="flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-700 hover:text-violet-600 hover:bg-violet-50 rounded-lg transition-colors duration-200" title="Toggle Fullscreen">
                            <svg id="fullscreen-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                            </svg>
                            <span id="fullscreen-text">Fullscreen</span>
                        </button>

                        <!-- Language Switcher -->
                        <div class="relative">
                            <button onclick="toggleLanguageMenu()" class="flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-700 hover:text-violet-600 hover:bg-violet-50 rounded-lg transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                </svg>
                                <span>{{ session('app_locale', 'en') == 'en' ? 'English' : 'Bahasa Indonesia' }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            
                            <!-- Language Dropdown -->
                            <div id="language-menu" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg transform opacity-0 invisible transition-all duration-200 ease-in-out z-50">
                                <div class="py-1">
                                    <a href="{{ route('lang.switch', 'en') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-violet-50 hover:text-violet-600 transition-colors duration-200 {{ session('app_locale', 'en') == 'en' ? 'bg-violet-50 text-violet-600' : '' }}">
                                        <span class="mr-3">🇺🇸</span>
                                        English
                                        @if(session('app_locale', 'en') == 'en')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        @endif
                                    </a>
                                    <a href="{{ route('lang.switch', 'id') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-violet-50 hover:text-violet-600 transition-colors duration-200 {{ session('app_locale', 'en') == 'id' ? 'bg-violet-50 text-violet-600' : '' }}">
                                        <span class="mr-3">🇮🇩</span>
                                        Bahasa Indonesia
                                        @if(session('app_locale', 'en') == 'id')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Menu -->
                        <div class="relative">
                            <button onclick="toggleProfileMenu()" class="flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-700 hover:text-violet-600 hover:bg-violet-50 rounded-lg transition-colors duration-200">
                                <div class="h-8 w-8 rounded-full bg-violet-100 text-violet-600 flex items-center justify-center font-semibold text-sm">
                                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                                </div>
                                <span>{{ auth()->user()->name ?? 'User' }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            
                            <!-- Profile Dropdown -->
                            <div id="profile-menu" class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-lg transform opacity-0 invisible transition-all duration-200 ease-in-out z-50">
                                <div class="py-1">
                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name ?? 'User' }}</p>
                                        <p class="text-sm text-gray-500">{{ auth()->user()->email ?? 'user@example.com' }}</p>
                                    </div>
                                    <a href="{{ url('/app/profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-violet-50 hover:text-violet-600 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Profile
                                    </a>
                                    <a href="{{ url('/app/settings') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-violet-50 hover:text-violet-600 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Settings
                                    </a>
                                    <div class="border-t border-gray-100"></div>
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="p-6">@yield('content')</div>
                @stack('scripts')
            </main>
        </div>
        
    </body>
    
    <script>
        // Sidebar toggle with persistence
        (function(){
            try{
                const hidden = localStorage.getItem('sidebarHidden') === '1';
                const sb = document.getElementById('sidebar');
                if (hidden && sb) sb.classList.add('hidden');
            }catch(e){}
        })();

        function toggleSidebar(){
            const sb = document.getElementById('sidebar');
            if(!sb) return;
            sb.classList.toggle('hidden');
            try{
                localStorage.setItem('sidebarHidden', sb.classList.contains('hidden') ? '1' : '0');
            }catch(e){}
        }

        function toggleQuickMenu(){
            const qm = document.getElementById('quickMenu');
            if(!qm) return;
            const isHidden = qm.classList.contains('invisible');
            if (isHidden){
                qm.classList.remove('opacity-0','invisible');
            } else {
                qm.classList.add('opacity-0','invisible');
            }
        }
        // Quick Menu templates (rendered server-side for convenience)
        const QUICK_MENU_TEMPLATES = {
            products: `
                <a href="{{ url('/app/products/create') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12M6 12h12"/></svg>
                    <span class="text-base">Create Product</span>
                </a>
                <a href="{{ url('/app/products') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 16h6M6 5h7l5 5v9H6z"/></svg>
                    <span class="text-base">All Products</span>
                </a>
                <a href="{{ url('/app/categories') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h10M4 18h8"/></svg><span class="text-base">Category</span></a>
                <a href="{{ url('/app/brands') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6l7 6-7 6-7-6z"/></svg><span class="text-base">Brand</span></a>
                <a href="{{ url('/app/units') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4v10l8 4 8-4z"/></svg><span class="text-base">Unit</span></a>
            `,
            adjustments: `
                <a href="{{ route('adjustments.create') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12M6 12h12"/></svg>
                    <span class="text-base">Create Adjustment</span>
                </a>
                <a href="{{ route('adjustments.index') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 16h6M6 5h7l5 5v9H6z"/></svg>
                    <span class="text-base">All Adjustments</span>
                </a>
            `,
            purchases: `
                <a href="{{ route('purchases.create') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12M6 12h12"/></svg>
                    <span class="text-base">Create Purchase</span>
                </a>
                <a href="{{ route('purchases.index') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 16h6M6 5h7l5 5v9H6z"/></svg>
                    <span class="text-base">All Purchases</span>
                </a>
            `,
            transfers: `
                <a href="{{ route('transfers.create') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12M6 12h12"/></svg>
                    <span class="text-base">Create Transfer</span>
                </a>
                <a href="{{ route('transfers.index') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 16h6M6 5h7l5 5v9H6z"/></svg>
                    <span class="text-base">All Transfers</span>
                </a>
            `
        };

        function openQuickMenu(kind){
            const qm = document.getElementById('quickMenu');
            const body = document.getElementById('quickMenuBody');
            if(!qm || !body) return;
            body.innerHTML = QUICK_MENU_TEMPLATES[kind] || '';
            qm.classList.remove('opacity-0','invisible');

            // highlight drawer owner item when its drawer is open
            if (['products','adjustments','purchases','transfers'].includes(kind)){
                // clear highlight from all items while drawer open
                document.querySelectorAll('aside .sidebar-item').forEach(item => {
                    const indicator = item.querySelector('.sidebar-active-indicator');
                    const icon = item.querySelector('.sidebar-icon');
                    const text = item.querySelector('.sidebar-text');
                    if (indicator) indicator.classList.add('hidden');
                    if (icon){
                        icon.classList.remove('border-violet-300','text-violet-600','bg-violet-50');
                        icon.classList.add('border-gray-200','bg-white');
                    }
                    if (text) text.classList.remove('text-violet-600');
                });

                // force highlight on owner temporarily
                const btn = document.querySelector(`button[data-sidebar-item="${kind}"]`);
                if (btn){
                    const ind = btn.querySelector('.sidebar-active-indicator');
                    const icon = btn.querySelector('.sidebar-icon');
                    const text = btn.querySelector('.sidebar-text');
                    if (ind) ind.classList.remove('hidden');
                    if (icon){
                        icon.classList.remove('border-gray-200','bg-white');
                        icon.classList.add('border-violet-300','text-violet-600','bg-violet-50');
                    }
                    if (text){ text.classList.add('text-violet-600'); }
                }
            }
        }

        function closeQuickMenu(){
            const qm = document.getElementById('quickMenu');
            if(qm){ 
                qm.classList.add('opacity-0','invisible'); 
                // restore original route-active highlights
                document.querySelectorAll('aside .sidebar-item').forEach(item => {
                    const isRouteActive = item.getAttribute('data-active') === '1';
                    const indicator = item.querySelector('.sidebar-active-indicator');
                    const icon = item.querySelector('.sidebar-icon');
                    const text = item.querySelector('.sidebar-text');
                    if (indicator) indicator.classList.toggle('hidden', !isRouteActive);
                    if (icon){
                        icon.classList.toggle('border-violet-300', isRouteActive);
                        icon.classList.toggle('text-violet-600', isRouteActive);
                        icon.classList.toggle('bg-violet-50', isRouteActive);
                        icon.classList.toggle('border-gray-200', !isRouteActive);
                        icon.classList.toggle('bg-white', !isRouteActive);
                    }
                    if (text) text.classList.toggle('text-violet-600', isRouteActive);
                });
            }
        }

        // Close quick menu when clicking outside
        document.addEventListener('click', function(event){
            const qm = document.getElementById('quickMenu');
            const trigger = event.target.closest('button[onclick^="openQuickMenu("]');
            if(qm && !trigger && !qm.contains(event.target)){
                closeQuickMenu();
            }
        });

        // Fullscreen toggle functionality
        function toggleFullscreen() {
            const fullscreenIcon = document.getElementById('fullscreen-icon');
            const fullscreenText = document.getElementById('fullscreen-text');
            
            if (!document.fullscreenElement) {
                // Enter fullscreen
                document.documentElement.requestFullscreen().then(() => {
                    fullscreenIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9V4.5M9 9H4.5M9 9l-5-5M15 9v4.5M15 9h4.5M15 9l5-5M9 15v4.5M9 15H4.5M9 15l-5 5M15 15v-4.5M15 15h4.5M15 15l5 5"/>';
                    fullscreenText.textContent = 'Exit Fullscreen';
                }).catch(err => {
                    console.log('Error attempting to enable fullscreen:', err);
                });
            } else {
                // Exit fullscreen
                document.exitFullscreen().then(() => {
                    fullscreenIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>';
                    fullscreenText.textContent = 'Fullscreen';
                }).catch(err => {
                    console.log('Error attempting to exit fullscreen:', err);
                });
            }
        }

        // Language menu toggle
        function toggleLanguageMenu() {
            const languageMenu = document.getElementById('language-menu');
            const isVisible = !languageMenu.classList.contains('opacity-0');
            
            if (isVisible) {
                languageMenu.classList.add('opacity-0', 'invisible');
                languageMenu.classList.remove('opacity-100', 'visible');
            } else {
                // Close other menus first
                closeAllMenus();
                languageMenu.classList.remove('opacity-0', 'invisible');
                languageMenu.classList.add('opacity-100', 'visible');
            }
        }

        // Profile menu toggle
        function toggleProfileMenu() {
            const profileMenu = document.getElementById('profile-menu');
            const isVisible = !profileMenu.classList.contains('opacity-0');
            
            if (isVisible) {
                profileMenu.classList.add('opacity-0', 'invisible');
                profileMenu.classList.remove('opacity-100', 'visible');
            } else {
                // Close other menus first
                closeAllMenus();
                profileMenu.classList.remove('opacity-0', 'invisible');
                profileMenu.classList.add('opacity-100', 'visible');
            }
        }

        // Close all dropdown menus
        function closeAllMenus() {
            const languageMenu = document.getElementById('language-menu');
            const profileMenu = document.getElementById('profile-menu');
            
            languageMenu.classList.add('opacity-0', 'invisible');
            languageMenu.classList.remove('opacity-100', 'visible');
            
            profileMenu.classList.add('opacity-0', 'invisible');
            profileMenu.classList.remove('opacity-100', 'visible');
        }
        
        // Close menus when clicking outside
        document.addEventListener('click', function(event) {
            const languageMenu = document.getElementById('language-menu');
            const profileMenu = document.getElementById('profile-menu');
            const languageButton = event.target.closest('button[onclick="toggleLanguageMenu()"]');
            const profileButton = event.target.closest('button[onclick="toggleProfileMenu()"]');
            
            if (!languageMenu.contains(event.target) && !languageButton) {
                languageMenu.classList.add('opacity-0', 'invisible');
                languageMenu.classList.remove('opacity-100', 'visible');
            }
            
            if (!profileMenu.contains(event.target) && !profileButton) {
                profileMenu.classList.add('opacity-0', 'invisible');
                profileMenu.classList.remove('opacity-100', 'visible');
            }

            const qm = document.getElementById('quickMenu');
            const qmTrigger = event.target.closest('button[onclick^="openQuickMenu("]');
            if (qm && !qmTrigger && !qm.contains(event.target)) {
                qm.classList.add('opacity-0','invisible');
            }
        });

        // Listen for fullscreen changes
        document.addEventListener('fullscreenchange', function() {
            const fullscreenIcon = document.getElementById('fullscreen-icon');
            const fullscreenText = document.getElementById('fullscreen-text');
            
            if (document.fullscreenElement) {
                fullscreenIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9V4.5M9 9H4.5M9 9l-5-5M15 9v4.5M15 9h4.5M15 9l5-5M9 15v4.5M9 15H4.5M9 15l-5 5M15 15v-4.5M15 15h4.5M15 15l5 5"/>';
                fullscreenText.textContent = 'Exit Fullscreen';
            } else {
                fullscreenIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>';
                fullscreenText.textContent = 'Fullscreen';
            }
        });
    </script>
    <!-- Use Iconify or Unocss icons if present; fallback to text if not -->
</html>

