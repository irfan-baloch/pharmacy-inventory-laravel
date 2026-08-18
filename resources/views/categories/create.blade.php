@extends('layouts.app')

@section('title', 'Add Category')
@section('page_title', 'Add Category')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Add New Category</h2>
            <p class="text-sm text-gray-500 mt-1">Create a new medicine category</p>
        </div>

        <form action="{{ route('categories.store') }}" method="POST" class="p-6 space-y-4">
            @csrf

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-500 @enderror"
                       placeholder="e.g., Tablet, Syrup, Injection">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                          placeholder="Optional description">{{ old('description') }}</textarea>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors">
                    Save Category
                </button>
                <a href="{{ route('categories.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                    Cancel
                </a>
            </div>
        </form>

    </div>
</div>

@endsection