@extends('layouts.app')

@section('title', 'Add Medicine')
@section('page_title', 'Add Medicine')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow">

        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Add New Medicine</h2>
            <p class="text-sm text-gray-500 mt-1">Add medicine to inventory</p>
        </div>

        <form action="{{ route('medicines.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Medicine Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('name') border-red-500 @enderror"
                           placeholder="e.g., Panadol 500mg">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Generic Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Generic Name</label>
                    <input type="text" name="generic_name" value="{{ old('generic_name') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
                           placeholder="e.g., Paracetamol">
                </div>

                {{-- Brand --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                    <input type="text" name="brand" value="{{ old('brand') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
                           placeholder="e.g., GSK">
                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                    <select name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('category_id') border-red-500 @enderror">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Unit Price --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Unit Price (Rs.) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="unit_price" value="{{ old('unit_price') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('unit_price') border-red-500 @enderror"
                           placeholder="e.g., 5.00">
                    @error('unit_price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Unit --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Base Unit <span class="text-red-500">*</span></label>
                    <input type="text" name="unit" value="{{ old('unit', 'tablet') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('unit') border-red-500 @enderror"
                           placeholder="e.g., tablet, bottle, vial">
                    @error('unit')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Pack Size --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pack Size <span class="text-red-500">*</span></label>
                    <input type="number" name="pack_size" value="{{ old('pack_size', 1) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('pack_size') border-red-500 @enderror"
                           placeholder="e.g., 10 (tablets per strip)">
                    @error('pack_size')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Pack Unit --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pack Unit <span class="text-red-500">*</span></label>
                    <input type="text" name="pack_unit" value="{{ old('pack_unit', 'strip') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('pack_unit') border-red-500 @enderror"
                           placeholder="e.g., strip, box, pack">
                    @error('pack_unit')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Low Stock Threshold --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Low Stock Alert At <span class="text-red-500">*</span></label>
                    <input type="number" name="low_stock_threshold" value="{{ old('low_stock_threshold', 10) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('low_stock_threshold') border-red-500 @enderror"
                           placeholder="e.g., 10">
                    @error('low_stock_threshold')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Image --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Medicine Image</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('image') border-red-500 @enderror">
                    @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs text-gray-400 mt-1">Max 2MB (JPG, PNG)</p>
                </div>
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500" placeholder="Optional details">{{ old('description') }}</textarea>
            </div>

            {{-- Active --}}
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded">
                <label for="is_active" class="text-sm text-gray-700">Active (available for sale)</label>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors">
                    Save Medicine
                </button>
                <a href="{{ route('medicines.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                    Cancel
                </a>
            </div>
        </form>

    </div>
</div>

@endsection