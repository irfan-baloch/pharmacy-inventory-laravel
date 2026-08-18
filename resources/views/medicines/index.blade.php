@extends('layouts.app')

@section('title', 'Medicines')
@section('page_title', 'Medicines')

@section('content')

<div class="bg-white rounded-lg shadow">

    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">All Medicines</h2>
            <p class="text-sm text-gray-500 mt-1">Manage medicine inventory</p>
        </div>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('medicines.create') }}" 
           class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            + Add Medicine
        </a>
        @endif
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Image</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Price</th>
                    <th class="px-4 py-3">Stock</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($medicines as $medicine)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        @if($medicine->image)
                            <img src="{{ asset('storage/' . $medicine->image) }}" alt="{{ $medicine->name }}" class="w-10 h-10 rounded-lg object-cover">
                        @else
                            <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 text-xs">No Img</div>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <p class="font-medium text-gray-900">{{ $medicine->name }}</p>
                        <p class="text-xs text-gray-500">{{ $medicine->generic_name ?? '' }}</p>
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">{{ optional($medicine->category)->name ?? 'N/A' }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-900">Rs. {{ number_format($medicine->unit_price, 2) }}</td>
                    <td class="px-4 py-3">
                        @php $stock = $medicine->totalStock(); @endphp
                        <span class="px-2 py-1 rounded text-xs font-medium {{ $medicine->isLowStock() ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                            {{ $stock }} {{ $medicine->unit }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        @if($medicine->is_active)
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">Active</span>
                        @else
                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">Inactive</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('medicines.show', $medicine) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm mr-2">View</a>
                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('medicines.edit', $medicine) }}" class="text-emerald-600 hover:text-emerald-700 font-medium text-sm mr-2">Edit</a>
                        <form action="{{ route('medicines.destroy', $medicine) }}" method="POST" class="inline" onsubmit="return confirm('Delete this medicine?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700 font-medium text-sm">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                        No medicines found. <a href="{{ route('medicines.create') }}" class="text-emerald-600 hover:underline">Add one</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4 border-t border-gray-200">
        {{ $medicines->links() }}
    </div>
</div>

@endsection