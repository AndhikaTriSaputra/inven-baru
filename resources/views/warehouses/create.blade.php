@extends('layouts.app')

@section('header-left')
<div class="flex items-center space-x-3">
    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
    </div>
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Create Warehouse</h1>
        <div class="text-sm text-gray-500 flex items-center gap-3">
            <a class="font-medium text-violet-600" href="{{ route('warehouses.index') }}">Warehouses</a>
            <span class="text-gray-300">/</span>
            <span>Create Warehouse</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container">
    <!-- Success Message -->
    @if (session('status'))
        <x-alert type="success" dismissible class="mb-6">
            {{ session('status') }}
        </x-alert>
    @endif

    <!-- Error Messages -->
    @if ($errors->any())
        <x-alert type="error" dismissible class="mb-6">
            <div class="font-semibold mb-2">Please fix the following errors:</div>
            <ul class="space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li class="flex items-center space-x-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                        <span>{{ $error }}</span>
                    </li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    <form action="{{ route('warehouses.store') }}" method="POST" class="space-y-8" autocomplete="off">
  @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Form Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Basic Information Card -->
                <x-card>
                    <x-slot name="header">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center">
                                <x-icon name="info" size="lg" class="text-white" />
                            </div>
                            <div>
                                <h3 class="text-heading-4">Basic Information</h3>
                                <p class="text-body-sm text-gray-500">Essential warehouse details</p>
                            </div>
                        </div>
                    </x-slot>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input 
                                name="name" 
                                label="Warehouse Name" 
                                placeholder="Enter warehouse name" 
                                required 
                                value="{{ old('name') }}"
                                error="{{ $errors->first('name') }}"
                            />
                        </div>
                        
                        <div>
                            <label class="form-label">Parent Warehouse</label>
                            <select name="parent_id" class="form-select">
                                <option value="">— None —</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div>
                            <x-input 
                                name="mobile" 
                                label="Phone" 
                                placeholder="Enter phone number" 
                                value="{{ old('mobile') }}"
                                error="{{ $errors->first('mobile') }}"
                            />
                        </div>
                        
                        <div>
                            <x-input 
                                name="email" 
                                type="email"
                                label="Email" 
                                placeholder="Enter email address" 
                                value="{{ old('email') }}"
                                error="{{ $errors->first('email') }}"
                            />
                        </div>
                    </div>
                </x-card>

                <!-- Location Information Card -->
                <x-card>
                    <x-slot name="header">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center">
                                <x-icon name="location" size="lg" class="text-white" />
                            </div>
                            <div>
                                <h3 class="text-heading-4">Location Information</h3>
                                <p class="text-body-sm text-gray-500">Warehouse address and location details</p>
                            </div>
                        </div>
                    </x-slot>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input 
                                name="country" 
                                label="Country" 
                                placeholder="Enter country" 
                                value="{{ old('country') }}"
                                error="{{ $errors->first('country') }}"
                            />
                        </div>
                        
                        <div>
                            <x-input 
                                name="city" 
                                label="City" 
                                placeholder="Enter city" 
                                value="{{ old('city') }}"
                                error="{{ $errors->first('city') }}"
                            />
                        </div>
                        
                        <div class="md:col-span-2">
                            <x-input 
                                name="zip" 
                                label="Zip Code" 
                                placeholder="Enter zip code" 
                                value="{{ old('zip') }}"
                                error="{{ $errors->first('zip') }}"
                            />
                        </div>
                    </div>
                </x-card>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Action Buttons -->
                <x-card>
                    <div class="space-y-4">
                        <div class="text-body-sm text-gray-500">
                            <span class="font-medium">Required fields</span> are marked with <span class="text-red-500 font-bold">*</span>
                        </div>
                        <div class="flex flex-col space-y-3">
                            <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <x-icon name="check" size="sm" />
                                Create Warehouse
                            </button>
                        </div>
                    </div>
                </x-card>

                <!-- Information Card -->
                <x-card>
                    <x-slot name="header">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center">
                                <x-icon name="info" size="lg" class="text-white" />
                            </div>
                            <div>
                                <h3 class="text-heading-4">Information</h3>
                                <p class="text-body-sm text-gray-500">Warehouse management tips</p>
                            </div>
                        </div>
                    </x-slot>

                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <x-icon name="info" size="sm" class="text-blue-500 mt-1" />
                            <div>
                                <h4 class="text-body font-semibold text-gray-700">Warehouse Hierarchy</h4>
                                <p class="text-body-sm text-gray-500">You can create parent-child relationships between warehouses for better organization.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <x-icon name="location" size="sm" class="text-green-500 mt-1" />
                            <div>
                                <h4 class="text-body font-semibold text-gray-700">Location Details</h4>
                                <p class="text-body-sm text-gray-500">Provide accurate location information for better inventory tracking and management.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <x-icon name="contact" size="sm" class="text-purple-500 mt-1" />
                            <div>
                                <h4 class="text-body font-semibold text-gray-700">Contact Information</h4>
                                <p class="text-body-sm text-gray-500">Add phone and email for warehouse-specific communications and notifications.</p>
                            </div>
                        </div>
                    </div>
                </x-card>
            </div>
        </div>
</form>
</div>
@endsection