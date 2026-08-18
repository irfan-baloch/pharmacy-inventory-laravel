@extends('layouts.app') 
@section('title', 'Categories') 
@section('page_title', 'Categories') 
@section('content')
<div class="bg-white rounded-lg shadow">

    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">All Categories</h2>
            <p class="text-sm text-gray-500 mt-1">Manage medicine categories</p>
        </div>
        <a href="{{ route('categories.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm
        font-medium transition-colors">
            + Add Category
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Slug</th>
                    <th class="px-6 py-3">Description</th>
                    <th class="px-6 py-3">Medicines</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $category->slug }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $category->description ?? '-' }}</td>
                        <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-medium">
                        {{ $category->medicines->count() }}
                        </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('categories.edit', $category) }}"
                            class="text-emerald-600 hover:text-emerald-700 font-medium text-sm
                            mr-3">
                                Edit
                            </a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST"
                            class="inline"
                            onsubmit="return confirm('Delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700 font-medium
                                text-sm">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        No categories found. <a href="{{ route('categories.create') }}"
                        class="text-emerald-600 hover:underline">Add one</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-200">
    {{ $categories->links() }}
    </div>

</div>
@endsection
