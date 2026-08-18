@extends('layouts.app')

@section('title', 'Edit Supplier')
@section('page_title', 'Edit Supplier')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Edit Supplier</h2>
            <p class="text-sm text-gray-500 mt-1">Update supplier details</p>
        </div>

        <form action="{{ route('suppliers.update', $supplier) }}" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Supplier Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $supplier->name) }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('name') border-red-500 @enderror">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $supplier->email) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <textarea name="address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">{{ old('address', $supplier->address) }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg text-sm font-medium">Update Supplier</button>
                <a href="{{ route('suppliers.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection