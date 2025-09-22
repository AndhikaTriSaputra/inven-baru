<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>POS Inventory</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                                    ['label' => 'All Products', 'href' => url('/app/products'), 'active' => request()->is('app/products') && !request()->is('app/products/create') && !request()->is('app/products/pending'), 'icon' => 'all'],
                                    ['label' => 'Pending Approval', 'href' => url('/app/products/pending'), 'active' => request()->is('app/products/pending*'), 'icon' => 'approval', 'admin_only' => true],
                                    ['label' => 'Print Labels', 'href' => url('/app/products/labels'), 'active' => request()->is('app/products/labels*'), 'icon' => 'print'],
                                    ['label' => 'Count Stock', 'href' => url('/app/products/stock-count'), 'active' => request()->is('app/products/stock-count*'), 'icon' => 'count'],
                                    ['label' => 'Category', 'href' => url('/app/categories'), 'active' => request()->is('app/categories*'), 'icon' => 'category'],
                                    ['label' => 'Brand', 'href' => url('/app/brands'), 'active' => request()->is('app/brands*'), 'icon' => 'brand'],
                                    ['label' => 'Unit', 'href' => url('/app/units'), 'active' => request()->is('app/units*'), 'icon' => 'unit'],
                                ]
                            ],
                            ['label' => 'Warehouse', 'href' => url('/app/warehouses'), 'active' => request()->is('app/warehouses*'), 'icon' => 'store'],
                            [
                                'label' => 'Adjustment', 
                                'href' => url('/app/adjustments'), 
                                'active' => request()->is('app/adjustments*'), 
                                'icon' => 'wrench',
                                'submenu' => [
                                    ['label' => 'Create Adjustment', 'href' => url('/app/adjustments/create'), 'active' => request()->is('app/adjustments/create'), 'icon' => 'create'],
                                    ['label' => 'All Adjustments', 'href' => url('/app/adjustments'), 'active' => request()->is('app/adjustments') && !request()->is('app/adjustments/create'), 'icon' => 'all'],
                                ]
                            ],
                            [
                                'label' => 'Purchases', 
                                'href' => url('/app/purchases'), 
                                'active' => request()->is('app/purchases*'), 
                                'icon' => 'receipt',
                                'submenu' => [
                                    ['label' => 'Create Purchase', 'href' => url('/app/purchases/create'), 'active' => request()->is('app/purchases/create'), 'icon' => 'create'],
                                    ['label' => 'All Purchases', 'href' => url('/app/purchases'), 'active' => request()->is('app/purchases') && !request()->is('app/purchases/create'), 'icon' => 'all'],
                                ]
                            ],
                            [
                                'label' => 'Transfer', 
                                'href' => url('/app/transfers'), 
                                'active' => request()->is('app/transfers*'), 
                                'icon' => 'transfer',
                                'submenu' => [
                                    ['label' => 'Create Transfer', 'href' => url('/app/transfers/create'), 'active' => request()->is('app/transfers/create'), 'icon' => 'create'],
                                    ['label' => 'All Transfers', 'href' => url('/app/transfers'), 'active' => request()->is('app/transfers') && !request()->is('app/transfers/create'), 'icon' => 'all'],
                                ]
                            ],
                        ];
                    @endphp
                    <ul class="flex flex-col gap-6 mt-2">
                        @foreach($items as $item)
                            <li>
                                @if(isset($item['submenu']))
                                    <!-- Main item with submenu -->
                                    <div class="relative">
                                        <button onclick="openQuickMenu('{{ $item['label'] }}')" data-sidebar-item="{{ strtolower($item['label']) }}" data-active="{{ $item['active'] ? 1 : 0 }}" class="relative flex flex-col items-center text-[11px] text-gray-600 hover:text-violet-600 w-full sidebar-item cursor-pointer">
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
                <div id="quickMenu" class="fixed top-16 left-24 bottom-0 w-80 bg-white border-l border-gray-200 shadow-2xl transform opacity-0 invisible transition-all duration-300 ease-in-out z-[9999]">
                    <div class="flex items-center justify-between p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Quick Menu</h2>
                        <button onclick="closeQuickMenu()" class="p-1 rounded-lg hover:bg-gray-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
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

                        <!-- Language Switcher (Disabled) -->
                        <div class="relative">
                            <button disabled class="flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed opacity-50" title="Language switching temporarily disabled">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                </svg>
                                <span>Bahasa Indonesia</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Approval Notification -->
                        @php
                            // Count pending products from cache for all users
                            $needApproval = 0;
                            $pendingProducts = [];
                            if (auth()->user()->role_id == 1) {
                                $users = \App\Models\User::where('role_id', '!=', 1)->get();
                                foreach ($users as $user) {
                                    $userPendingProducts = \Cache::get("user_pending_products_{$user->id}", []);
                                    $needApproval += count($userPendingProducts);
                                    
                                    // Enrich with category, brand, unit info
                                    foreach ($userPendingProducts as $product) {
                                        $category = \DB::table('categories')->where('id', $product['category_id'])->first();
                                        $brand = \DB::table('brands')->where('id', $product['brand_id'])->first();
                                        $unit = \DB::table('units')->where('id', $product['unit_id'])->first();
                                        
                                        $product['category'] = $category ? $category->name : 'N/A';
                                        $product['brand'] = $brand ? $brand->name : 'N/A';
                                        $product['unit'] = $unit ? $unit->ShortName : 'N/A';
                                        $product['user_name'] = $user->firstname . ' ' . $user->lastname;
                                        $product['user_id'] = $user->id;
                                        
                                        $pendingProducts[] = $product;
                                    }
                                }
                                
                                // Sort by created_at
                                usort($pendingProducts, function($a, $b) {
                                    return strtotime($b['created_at']) - strtotime($a['created_at']);
                                });
                            }
                        @endphp
                        @if(auth()->user()->role_id == 1)
                            <div class="relative">
                                <button onclick="toggleApprovalModal()" class="flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-700 hover:text-violet-600 hover:bg-violet-50 rounded-lg transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5v-5a7.5 7.5 0 00-15 0v5h5l-5 5-5-5h5v-5a7.5 7.5 0 0115 0v5z"/>
                                    </svg>
                                    <span>Need Approval</span>
                                    @if($needApproval > 0)
                                        <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full">{{ $needApproval }}</span>
                                    @endif
                                </button>
                            </div>
                        @endif

                        <!-- Profile Menu -->
                        <div class="relative">
                            <button onclick="toggleProfileMenu()" class="flex items-center space-x-2 px-4 py-2 text-sm font-medium text-gray-700 hover:text-violet-600 hover:bg-violet-50 rounded-lg transition-colors duration-200 cursor-pointer">
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

        <!-- Approval Modal -->
        @if(auth()->user()->role_id == 1)
            <div id="approvalModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
                <div class="relative top-20 mx-auto p-5 border w-4/5 max-w-6xl shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Product Approval</h3>
                            <button onclick="toggleApprovalModal()" class="text-gray-400 hover:text-gray-600">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 mb-4">
                                Pending approval: {{ $needApproval }}
                            </p>
                            @if($needApproval > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white border border-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($pendingProducts as $product)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-4 py-4 whitespace-nowrap">
                                                        @if($product['image'] ?? false)
                                                            <img src="{{ asset('images/products/' . explode(',', $product['image'])[0]) }}" alt="{{ $product['name'] ?? 'Product' }}" class="h-10 w-10 object-cover rounded">
                                                        @else
                                                            <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                                                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">{{ $product['name'] ?? 'N/A' }}</div>
                                                        <div class="text-sm text-red-600">Pending Approval</div>
                                                    </td>
                                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($product['type'] ?? 'N/A') }}</td>
                                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product['code'] ?? 'N/A' }}</td>
                                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product['brand'] ?? 'N/A' }}</td>
                                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product['stock_alert'] ?? 0 }}</td>
                                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                                        <div class="flex space-x-2">
                                                            <button onclick="approveProduct('{{ $product['id'] ?? $product['temp_id'] ?? '' }}')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium shadow-md border border-green-700">
                                                                ✓ Approve
                                                            </button>
                                                            <button onclick="rejectProduct('{{ $product['id'] ?? $product['temp_id'] ?? '' }}')" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium shadow-md border border-red-700">
                                                                ✗ Reject
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-sm text-gray-500 text-center py-4">No products pending approval.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
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

        function openQuickMenu(kind){
            console.log('Opening quick menu for:', kind);
            const qm = document.getElementById('quickMenu');
            const body = document.getElementById('quickMenuBody');
            if(!qm || !body) {
                console.error('Quick menu elements not found');
                return;
            }
            
            // Create submenu HTML based on the kind (convert to lowercase for comparison)
            let submenuHTML = '';
            const menuType = kind.toLowerCase();
            
            if (menuType === 'products') {
                submenuHTML = `
                    <div class="space-y-2">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Products Menu</h3>
                        <a href="{{ url('/app/products/create') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600 p-3 rounded-lg hover:bg-violet-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12M6 12h12"/></svg>
                    <span class="text-base">Create Product</span>
                </a>
                        <a href="{{ url('/app/products') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600 p-3 rounded-lg hover:bg-violet-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 16h6M6 5h7l5 5v9H6z"/></svg>
                    <span class="text-base">All Products</span>
                </a>
                        <a href="{{ url('/app/products/labels') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600 p-3 rounded-lg hover:bg-violet-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2M7 4h10M7 4l-2 16h14l-2-16M9 8h6M9 12h6M9 16h6"/></svg>
                            <span class="text-base">Print Labels</span>
                        </a>
                        <a href="{{ url('/app/products/stock-count') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600 p-3 rounded-lg hover:bg-violet-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                            <span class="text-base">Count Stock</span>
                        </a>
                        <a href="{{ url('/app/categories') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600 p-3 rounded-lg hover:bg-violet-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h10M4 18h8"/></svg>
                            <span class="text-base">Category</span>
                        </a>
                        <a href="{{ url('/app/brands') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600 p-3 rounded-lg hover:bg-violet-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6l7 6-7 6-7-6z"/></svg>
                            <span class="text-base">Brand</span>
                        </a>
                        <a href="{{ url('/app/units') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600 p-3 rounded-lg hover:bg-violet-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4v10l8 4 8-4z"/></svg>
                            <span class="text-base">Unit</span>
                        </a>
                    </div>
                `;
            } else if (menuType === 'adjustment') {
                submenuHTML = `
                    <div class="space-y-2">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Adjustments Menu</h3>
                        <a href="{{ route('adjustments.create') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600 p-3 rounded-lg hover:bg-violet-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12M6 12h12"/></svg>
                    <span class="text-base">Create Adjustment</span>
                </a>
                        <a href="{{ route('adjustments.index') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600 p-3 rounded-lg hover:bg-violet-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 16h6M6 5h7l5 5v9H6z"/></svg>
                    <span class="text-base">All Adjustments</span>
                </a>
                    </div>
                `;
            } else if (menuType === 'purchases') {
                submenuHTML = `
                    <div class="space-y-2">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Purchases Menu</h3>
                        <a href="{{ route('purchases.create') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600 p-3 rounded-lg hover:bg-violet-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12M6 12h12"/></svg>
                    <span class="text-base">Create Purchase</span>
                </a>
                        <a href="{{ route('purchases.index') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600 p-3 rounded-lg hover:bg-violet-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 16h6M6 5h7l5 5v9H6z"/></svg>
                    <span class="text-base">All Purchases</span>
                </a>
                    </div>
                `;
            } else if (menuType === 'transfer') {
                submenuHTML = `
                    <div class="space-y-2">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Transfers Menu</h3>
                        <a href="{{ route('transfers.create') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600 p-3 rounded-lg hover:bg-violet-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12M6 12h12"/></svg>
                    <span class="text-base">Create Transfer</span>
                </a>
                        <a href="{{ route('transfers.index') }}" class="flex items-center gap-3 text-gray-700 hover:text-violet-600 p-3 rounded-lg hover:bg-violet-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 16h6M6 5h7l5 5v9H6z"/></svg>
                    <span class="text-base">All Transfers</span>
                </a>
                    </div>
                `;
            }
            
            body.innerHTML = submenuHTML;
            qm.classList.remove('opacity-0','invisible');

            // highlight drawer owner item when its drawer is open
            if (['products','adjustment','purchases','transfer'].includes(menuType)){
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
                const btn = document.querySelector(`button[data-sidebar-item="${kind.toLowerCase()}"]`);
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

        // Language menu toggle (disabled)
        // function toggleLanguageMenu() {
        //     // Language switching temporarily disabled
        // }

        // Profile menu toggle
        function toggleProfileMenu() {
            const profileMenu = document.getElementById('profile-menu');
            
            if (!profileMenu) {
                console.error('Profile menu element not found');
                return;
            }
            
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
            
            if (languageMenu) {
            languageMenu.classList.add('opacity-0', 'invisible');
            languageMenu.classList.remove('opacity-100', 'visible');
            }
            
            if (profileMenu) {
            profileMenu.classList.add('opacity-0', 'invisible');
            profileMenu.classList.remove('opacity-100', 'visible');
            }
        }

        // Approval modal toggle
        function toggleApprovalModal() {
            const modal = document.getElementById('approvalModal');
            if (modal) {
                modal.classList.toggle('hidden');
            }
        }

        // Approve product function
        function approveProduct(productId) {
            console.log('Approving product:', productId);
            if (confirm('Are you sure you want to approve this product?')) {
                // Create a form to submit POST request
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/app/products/${productId}/approve`;
                
                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(csrfToken);
                
                // Submit form
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Reject product function
        function rejectProduct(productId) {
            console.log('Rejecting product:', productId);
            if (confirm('Are you sure you want to reject this product?')) {
                // Create a form to submit POST request
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/app/products/${productId}/reject`;
                
                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(csrfToken);
                
                // Submit form
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        // Close menus when clicking outside
        document.addEventListener('click', function(event) {
            const languageMenu = document.getElementById('language-menu');
            const profileMenu = document.getElementById('profile-menu');
            const approvalModal = document.getElementById('approvalModal');
            const languageButton = event.target.closest('button[onclick="toggleLanguageMenu()"]');
            const profileButton = event.target.closest('button[onclick="toggleProfileMenu()"]');
            const approvalButton = event.target.closest('button[onclick="toggleApprovalModal()"]');
            
            if (languageMenu && !languageMenu.contains(event.target) && !languageButton) {
                languageMenu.classList.add('opacity-0', 'invisible');
                languageMenu.classList.remove('opacity-100', 'visible');
            }
            
            if (profileMenu && !profileMenu.contains(event.target) && !profileButton) {
                profileMenu.classList.add('opacity-0', 'invisible');
                profileMenu.classList.remove('opacity-100', 'visible');
            }

            if (approvalModal && !approvalModal.contains(event.target) && !approvalButton) {
                approvalModal.classList.add('hidden');
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