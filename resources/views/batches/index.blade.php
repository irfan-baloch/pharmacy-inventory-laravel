@extends('layouts.app')

@section('title', 'Batches & Stock')
@section('page_title', 'Batches & Stock')

@section('content')

<div class="bg-white rounded-lg shadow">

    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">All Batches</h2>
            <p class="text-sm text-gray-500 mt-1">Track stock batches with expiry and supplier</p>
        </div>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('batches.create') }}" 
           class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            + Stock In (Purchase)
        </a>
        @endif
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Batch #</th>
                    <th class="px-4 py-3">Medicine</th>
                    <th class="px-4 py-3">Supplier</th>
                    <th class="px-4 py-3">Expiry</th>
                    <th class="px-4 py-3">Qty / Rem</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($batches as $batch)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $batch->batch_number }}</td>
                    <td class="px-4 py-3">
                        <p class="font-medium text-gray-800">{{ optional($batch->medicine)->name ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">{{ optional($batch->medicine)->unit }}</p>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ optional($batch->supplier)->name ?? 'N/A' }}</td>
                    <td class="px-4 py-3">
                        <p class="text-sm {{ $batch->isExpired() ? 'text-red-600 font-medium' : ($batch->daysUntilExpiry() <= 30 ? 'text-orange-600' : 'text-gray-600') }}">
                            {{ $batch->expiry_date->format('M d, Y') }}
                        </p>
                        <p class="text-xs text-gray-400">{{ $batch->daysUntilExpiry() }} days left</p>
                    </td>
                    <td class="px-4 py-3">
                        <p class="text-sm text-gray-800">{{ $batch->quantity }} / <span class="font-medium">{{ $batch->remaining_quantity }}</span></p>
                        <p class="text-xs text-gray-400">{{ optional($batch->medicine)->unit }}</p>
                    </td>
                    <td class="px-4 py-3">
                        @if($batch->isExpired())
                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-medium">Expired</span>
                        @elseif($batch->daysUntilExpiry() <= 30)
                            <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded text-xs font-medium">Expiring Soon</span>
                        @elseif($batch->remaining_quantity == 0)
                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-medium">Out of Stock</span>
                        @else
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium">Active</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('batches.show', $batch) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm mr-2">View</a>
                        @if(auth()->user()->isAdmin())
                        <form action="{{ route('batches.destroy', $batch) }}" method="POST" class="inline" onsubmit="return confirm('Delete this batch? This cannot be undone if sales exist.');">
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
                        No batches found. <a href="{{ route('batches.create') }}" class="text-emerald-600 hover:underline">Add stock</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4 border-t border-gray-200">
        {{ $batches->links() }}
    </div>
</div>

@endsection