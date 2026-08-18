@extends('layouts.app')

@section('title', 'Batch ' . $batch->batch_number)
@section('page_title', 'Batch Details')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">

    {{-- Batch Info Card --}}
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Batch {{ $batch->batch_number }}</h2>
                <p class="text-gray-500 mt-1">{{ optional($batch->medicine)->name ?? 'Unknown Medicine' }}</p>
            </div>
            @if($batch->isExpired())
                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-sm font-medium">Expired</span>
            @elseif($batch->daysUntilExpiry() <= 30)
                <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-sm font-medium">Expiring Soon</span>
            @else
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-sm font-medium">Active</span>
            @endif
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase">Original Qty</p>
                <p class="text-xl font-bold text-gray-800">{{ $batch->quantity }}</p>
                <p class="text-xs text-gray-400">{{ optional($batch->medicine)->unit }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase">Remaining</p>
                <p class="text-xl font-bold {{ $batch->remaining_quantity == 0 ? 'text-red-600' : 'text-gray-800' }}">{{ $batch->remaining_quantity }}</p>
                <p class="text-xs text-gray-400">{{ optional($batch->medicine)->unit }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase">Purchase Price</p>
                <p class="text-xl font-bold text-gray-800">Rs. {{ number_format($batch->purchase_price, 2) }}</p>
                <p class="text-xs text-gray-400">per {{ optional($batch->medicine)->unit }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase">Expiry</p>
                <p class="text-xl font-bold {{ $batch->isExpired() ? 'text-red-600' : 'text-gray-800' }}">{{ $batch->expiry_date->format('M d, Y') }}</p>
                <p class="text-xs text-gray-400">{{ $batch->daysUntilExpiry() }} days left</p>
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-500 uppercase mb-1">Supplier</p>
                <p class="text-sm text-gray-800">{{ optional($batch->supplier)->name ?? 'Not specified' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase mb-1">Purchase Date</p>
                <p class="text-sm text-gray-800">{{ $batch->purchase_date->format('M d, Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Stock Movement History --}}
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">Stock Movement History</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Type</th>
                        <th class="px-6 py-3">Quantity</th>
                        <th class="px-6 py-3">Unit Price</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">User</th>
                        <th class="px-6 py-3">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($batch->stockMovements as $movement)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            @if($movement->type === 'in')
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-medium">Stock In</span>
                            @else
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs font-medium">Sale</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium">{{ $movement->quantity }}</td>
                        <td class="px-6 py-4 text-gray-500">Rs. {{ number_format($movement->unit_price, 2) }}</td>
                        <td class="px-6 py-4 text-gray-500">Rs. {{ number_format($movement->total_price, 2) }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ optional($movement->user)->name ?? 'System' }}</td>
                        <td class="px-6 py-4 text-gray-500 text-xs">{{ $movement->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">No movement history for this batch.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('batches.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">&larr; Back to Batches</a>
    </div>
</div>

@endsection