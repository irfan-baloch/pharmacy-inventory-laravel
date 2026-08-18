@extends('layouts.app')

@section('title', 'Suppliers')
@section('page_title', 'Suppliers')

@section('content')

<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">All Suppliers</h2>
            <p class="text-sm text-gray-500 mt-1">Manage medicine suppliers</p>
        </div>
        <a href="{{ route('suppliers.create') }}" 
           class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            + Add Supplier
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Phone</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Address</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($suppliers as $supplier)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $supplier->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $supplier->phone ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $supplier->email ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $supplier->address ?? '-' }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('suppliers.edit', $supplier) }}" class="text-emerald-600 hover:text-emerald-700 font-medium text-sm mr-3">Edit</a>
                        <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline" onsubmit="return confirm('Delete this supplier?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700 font-medium text-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        No suppliers found. <a href="{{ route('suppliers.create') }}" class="text-emerald-600 hover:underline">Add one</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4 border-t border-gray-200">
        {{ $suppliers->links() }}
    </div>
</div>

@endsection