@extends('layouts.app')

@section('title', $medicine->name)
@section('page_title', 'Medicine Details')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">

    {{-- Medicine Info Card --}}
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-start gap-6">
            @if($medicine->image)
                <img src="{{ asset('storage/' . $medicine->image) }}" alt="{{ $medicine->name }}" class="w-24 h-24 rounded-lg object-cover">
            @else
                <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">No Image</div>
            @endif

            <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $medicine->name }}</h2>
                    @if($medicine->is_active)
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">Active</span>
                    @else
                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">Inactive</span>
                    @endif
                </div>
                <p class="text-gray-500">{{ $medicine->generic_name ?? 'No generic name' }} | {{ $medicine->brand ?? 'No brand' }}</p>
                <p class="text-sm text-gray-400 mt-1">Category: {{ optional($medicine->category)->name ?? 'N/A' }}</p>
            </div>

            <div class="text-right">
                <p class="text-3xl font-bold text-emerald-600">Rs. {{ number_format($medicine->unit_price, 2) }}</p>
                <p class="text-sm text-gray-500">per {{ $medicine->unit }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6 pt-6 border-t border-gray-100">
            <div>
                <p class="text-xs text-gray-500 uppercase">Packaging</p>
                <p class="font-medium text-gray-800">{{ $medicine->pack_size }} {{ $medicine->unit }} / {{ $medicine->pack_unit }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Total Stock</p>
                <p class="font-medium {{ $medicine->isLowStock() ? 'text-red-600' : 'text-gray-800' }}">{{ $medicine->totalStock() }} {{ $medicine->unit }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Low Alert At</p>
                <p class="font-medium text-gray-800">{{ $medicine->low_stock_threshold }} {{ $medicine->unit }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase">Status</p>
                <p class="font-medium {{ $medicine->isLowStock() ? 'text-red-600' : 'text-green-600' }}">{{ $medicine->isLowStock() ? 'Low Stock!' : 'In Stock' }}</p>
            </div>
        </div>

        @if($medicine->description)
        <div class="mt-4 pt-4 border-t border-gray-100">
            <p class="text-xs text-gray-500 uppercase mb-1">Description</p>
            <p class="text-gray-600">{{ $medicine->description }}</p>
        </div>
        @endif
    </div>

    {{-- Batches List --}}
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">Stock Batches</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Batch #</th>
                        <th class="px-6 py-3">Supplier</th>
                        <th class="px-6 py-3">Expiry</th>
                        <th class="px-6 py-3">Qty</th>
                        <th class="px-6 py-3">Remaining</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($medicine->batches as $batch)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium">{{ $batch->batch_number }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ optional($batch->supplier)->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $batch->expiry_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4">{{ $batch->quantity }}</td>
                        <td class="px-6 py-4">{{ $batch->remaining_quantity }}</td>
                        <td class="px-6 py-4">
                            @if($batch->isExpired())
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">Expired</span>
                            @elseif($batch->daysUntilExpiry() <= 30)
                                <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded text-xs">Expiring Soon</span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">Good</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">No batches found for this medicine.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('medicines.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">&larr; Back to Medicines</a>
    </div>
</div>

@endsection