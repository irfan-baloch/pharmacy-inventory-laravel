@extends('layouts.app')

@section('title', 'Settings')
@section('page_title', 'System Settings')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    {{-- Pharmacy Info Card --}}
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Pharmacy Information</h2>
            <p class="text-sm text-gray-500 mt-1">Update your pharmacy details and system preferences</p>
        </div>
        
        <form action="{{ route('settings.update') }}" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Pharmacy Name --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pharmacy Name <span class="text-red-500">*</span></label>
                    <input type="text" name="pharmacy_name" value="{{ old('pharmacy_name', $settings['pharmacy_name']) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('pharmacy_name') border-red-500 @enderror"
                        placeholder="e.g., Ali Medical Store">
                    @error('pharmacy_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Address --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <textarea name="pharmacy_address" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
                        placeholder="Full address">{{ old('pharmacy_address', $settings['pharmacy_address']) }}</textarea>
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="pharmacy_phone" value="{{ old('pharmacy_phone', $settings['pharmacy_phone']) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
                        placeholder="e.g., 0300-1234567">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="pharmacy_email" value="{{ old('pharmacy_email', $settings['pharmacy_email']) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
                        placeholder="e.g., info@pharmacy.com">
                </div>

                {{-- Currency --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Currency Symbol <span class="text-red-500">*</span></label>
                    <input type="text" name="currency" value="{{ old('currency', $settings['currency']) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('currency') border-red-500 @enderror"
                        placeholder="e.g., Rs., $, €">
                    @error('currency')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Low Stock Alert Days --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Alert Days <span class="text-red-500">*</span></label>
                    <input type="number" name="low_stock_alert_days" value="{{ old('low_stock_alert_days', $settings['low_stock_alert_days']) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('low_stock_alert_days') border-red-500 @enderror"
                        placeholder="e.g., 30">
                    @error('low_stock_alert_days')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs text-gray-400 mt-1">Days before expiry to show warning</p>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200 mt-4">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors">
                    Save Settings
                </button>
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>

    {{-- Quick Stats Card --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">System Overview</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-2xl font-bold text-emerald-600">{{ \App\Models\Medicine::count() }}</p>
                <p class="text-xs text-gray-500">Total Medicines</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-2xl font-bold text-blue-600">{{ \App\Models\Batch::count() }}</p>
                <p class="text-xs text-gray-500">Total Batches</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-2xl font-bold text-amber-600">{{ \App\Models\Supplier::count() }}</p>
                <p class="text-xs text-gray-500">Suppliers</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-2xl font-bold text-purple-600">{{ \App\Models\Category::count() }}</p>
                <p class="text-xs text-gray-500">Categories</p>
            </div>
        </div>
    </div>

    {{-- About Card --}}
    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-lg shadow p-6 text-white">
        <h3 class="text-lg font-bold mb-2">Pharmacy Inventory System</h3>
        <p class="text-sm text-emerald-100 mb-4">Version 1.0 | Built with Laravel 12 + Tailwind CSS</p>
        <div class="flex flex-wrap gap-2 text-xs">
            <span class="px-2 py-1 bg-white/20 rounded">FIFO Stock Management</span>
            <span class="px-2 py-1 bg-white/20 rounded">Expiry Tracking</span>
            <span class="px-2 py-1 bg-white/20 rounded">Role-Based Access</span>
            <span class="px-2 py-1 bg-white/20 rounded">Batch Tracking</span>
        </div>
    </div>

</div>
@endsection