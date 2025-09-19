@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-semibold text-gray-800">Point of Sale (POS)</h1>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Products Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-800">Products</h2>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" placeholder="Search products..." class="w-64 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <button class="px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Add Product
                        </button>
                    </div>
                </div>
                
                <!-- Product Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <!-- Sample Product Cards -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:border-violet-300 cursor-pointer transition-colors duration-200">
                        <div class="aspect-square bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <h3 class="font-medium text-gray-800 text-sm">Product Name</h3>
                        <p class="text-violet-600 font-semibold text-sm">$19.99</p>
                        <p class="text-gray-500 text-xs">Stock: 50</p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:border-violet-300 cursor-pointer transition-colors duration-200">
                        <div class="aspect-square bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <h3 class="font-medium text-gray-800 text-sm">Product Name</h3>
                        <p class="text-violet-600 font-semibold text-sm">$29.99</p>
                        <p class="text-gray-500 text-xs">Stock: 25</p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:border-violet-300 cursor-pointer transition-colors duration-200">
                        <div class="aspect-square bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <h3 class="font-medium text-gray-800 text-sm">Product Name</h3>
                        <p class="text-violet-600 font-semibold text-sm">$39.99</p>
                        <p class="text-gray-500 text-xs">Stock: 10</p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:border-violet-300 cursor-pointer transition-colors duration-200">
                        <div class="aspect-square bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <h3 class="font-medium text-gray-800 text-sm">Product Name</h3>
                        <p class="text-violet-600 font-semibold text-sm">$49.99</p>
                        <p class="text-gray-500 text-xs">Stock: 5</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cart Section -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-800">Cart</h2>
                    <button class="text-sm text-red-600 hover:text-red-700">Clear All</button>
                </div>
                
                <!-- Cart Items -->
                <div class="space-y-3 mb-6">
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-800">Sample Product</h4>
                            <p class="text-xs text-gray-500">$19.99 × 2</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                            </button>
                            <span class="text-sm font-medium">2</span>
                            <button class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </button>
                        </div>
                        <span class="text-sm font-semibold text-violet-600 ml-2">$39.98</span>
                    </div>
                </div>
                
                <!-- Cart Summary -->
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-medium">$39.98</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Tax (10%):</span>
                        <span class="font-medium">$3.99</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Discount:</span>
                        <span class="font-medium text-green-600">-$0.00</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex justify-between text-lg font-semibold">
                            <span>Total:</span>
                            <span class="text-violet-600">$43.97</span>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Buttons -->
                <div class="space-y-3">
                    <button class="w-full bg-violet-600 text-white py-3 rounded-lg font-semibold hover:bg-violet-700 transition-colors duration-200">
                        Process Payment
                    </button>
                    <div class="grid grid-cols-2 gap-3">
                        <button class="bg-gray-100 text-gray-700 py-2 rounded-lg font-medium hover:bg-gray-200 transition-colors duration-200">
                            Cash
                        </button>
                        <button class="bg-gray-100 text-gray-700 py-2 rounded-lg font-medium hover:bg-gray-200 transition-colors duration-200">
                            Card
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection






