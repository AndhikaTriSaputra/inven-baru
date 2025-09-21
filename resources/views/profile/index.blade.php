@extends('layouts.app')

@section('header')
            <h1 class="text-2xl font-semibold text-gray-800">Profile</h1>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center space-x-6 mb-8">
                    <div class="h-24 w-24 rounded-full bg-violet-100 text-violet-600 flex items-center justify-center font-semibold text-2xl">
                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">{{ auth()->user()->name ?? 'User' }}</h2>
                        <p class="text-gray-600">{{ auth()->user()->email ?? 'user@example.com' }}</p>
                               <p class="text-sm text-gray-500">Member since {{ auth()->user()->created_at ? auth()->user()->created_at->format('F Y') : 'Unknown' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Personal Information -->
                <div>
                           <h3 class="text-lg font-semibold text-gray-800 mb-4">Personal Information</h3>
                    <div class="space-y-4">
                        <div>
                                   <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                            <input type="text" value="{{ auth()->user()->firstname ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600" readonly>
                        </div>
                        <div>
                                   <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                            <input type="text" value="{{ auth()->user()->lastname ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600" readonly>
                        </div>
                        <div>
                                   <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" value="{{ auth()->user()->email ?? 'user@example.com' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600" readonly>
                        </div>
                        <div>
                                   <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" value="{{ auth()->user()->phone ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600" readonly>
                        </div>
                        <div>
                                   <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                            <input type="text" value="{{ auth()->user()->username ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600" readonly>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div>
                           <h3 class="text-lg font-semibold text-gray-800 mb-4">Account Information</h3>
                    <div class="space-y-4">
                        <div>
                                   <label class="block text-sm font-medium text-gray-700 mb-1">User ID</label>
                            <div class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                                {{ auth()->user()->id }}
                            </div>
                        </div>
                        <div>
                                   <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                            <div class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                                @if(auth()->user()->role_id == 1)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                               Administrator
                                    </span>
                                @elseif(auth()->user()->role_id == 2)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                               Manager
                                    </span>
                                @elseif(auth()->user()->role_id == 3)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                               Cashier
                                    </span>
                                @elseif(auth()->user()->role_id == 4)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                               Staff
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Unknown
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div>
                                   <label class="block text-sm font-medium text-gray-700 mb-1">Account Status</label>
                            <div class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                                @if(auth()->user()->statut == 1)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                               Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                               Inactive
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div>
                                   <label class="block text-sm font-medium text-gray-700 mb-1">Warehouse Access</label>
                            <div class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                                @if(auth()->user()->is_all_warehouses == 1)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                               All Warehouses
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                               Limited Access
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div>
                                   <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
                            <div class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                                {{ auth()->user()->updated_at ? auth()->user()->updated_at->format('d M Y, H:i') : 'Never' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
    </div>

@endsection