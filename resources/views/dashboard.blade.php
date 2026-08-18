@extends('layouts.app') @section('title', 'Dashboard') @section('page_title',
'Dashboard Overview') @section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Medicines</p>
                <p class="text-2xl font-bold text-gray-800">
                    {{ $totalMedicines ?? 0 }}
                </p>
            </div>
            <div
                class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center  text-xl"
            >
                &#x1F48A;
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Stock Units</p>
                <p class="text-2xl font-bold text-gray-800">
                    {{ number_format($totalStock ?? 0) }}
                </p>
            </div>
            <div
                class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center  text-xl"
            >
                &#x1F4E6;
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Low Stock Items</p>
                <p
                    class="text-2xl font-bold {{ ($lowStockCount ?? 0) > 0 ? 'text-amber-600' :
 'text-gray-800' }}"
                >
                    {{ $lowStockCount ?? 0 }}
                </p>
            </div>
            <div
                class="w-10 h-10 {{ ($lowStockCount ?? 0) > 0 ? 'bg-amber-100' : 'bg-gray-100' }}
 rounded-lg flex items-center justify-center text-xl"
            >
                &#x26A0;
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Today's Sales</p>
                <p class="text-2xl font-bold text-gray-800">
                    Rs. {{ number_format($todaySales ?? 0, 2)  }}
                </p>
            </div>
            <div
                class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center  text-xl"
            >
                &#x1F4B0;
            </div>
        </div>
    </div>
</div>
<!-- Alerts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-800">Expiring Soon (30 Days)</h3>
            <span
                class="px-2 py-1 rounded text-xs font-medium {{ ($expiringSoonCount ?? 0) > 0 ?
 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700' }}"
            >
                {{ $expiringSoonCount ?? 0 }} items
            </span>
        </div>

        @if(isset($upcomingExpiry) && $upcomingExpiry->count() > 0)
        <div class="space-y-2">
            @foreach($upcomingExpiry as $batch)
            <div
                class="flex items-center justify-between p-3 bg-gray-50 rounded"
            >
                <div>
                    <p class="text-sm font-medium text-gray-800">
                        {{ optional($batch->medicine)->name ?? 'Unknown' }}
                    </p>
                    <p class="text-xs text-gray-500">
                        Batch: {{ $batch->batch_number }}
                    </p>
                </div>
                <div class="text-right">
                    <p
                        class="text-sm font-medium {{ $batch->daysUntilExpiry() <= 7 ? 'text-red-600'
 : 'text-orange-600' }}"
                    >
                        {{ $batch->daysUntilExpiry() }} days
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ $batch->expiry_date->format('M d, Y') }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-6 text-gray-400">
            <p class="text-2xl mb-2">&#x2705;</p>
            <p>No items expiring soon</p>
        </div>
        @endif
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-800">Low Stock Alert</h3>
            <span
                class="px-2 py-1 rounded text-xs font-medium {{ ($lowStockCount ?? 0) > 0 ?
 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700' }}"
            >
                {{ $lowStockCount ?? 0 }} items
            </span>
        </div>
        @if(isset($upcomingLowStock) && $upcomingLowStock->count() > 0)
        <div class="space-y-2">
            @foreach($upcomingLowStock as $medicine)
            <div
                class="flex items-center justify-between p-3 bg-gray-50 rounded"
            >
                <div>
                    <p class="text-sm font-medium text-gray-800">
                        {{ $medicine->name }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ optional($medicine->category)->name ?? 
                        'Uncategorized' }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-amber-600">
                        {{ $medicine->totalStock() }}  left
                    </p>
                    <p class="text-xs text-gray-500">
                        Min: {{ $medicine->low_stock_threshold }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-6 text-gray-400">
            <p class="text-2xl mb-2">&#x2705;</p>
            <p>All stock levels healthy</p>
        </div>
        @endif
    </div>
</div>
<!-- Recent Activity -->
<div class="bg-white rounded-lg shadow p-5">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold text-gray-800">Recent Stock Movements</h3>
        <span class="text-xs text-gray-500">Last 10 transactions</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-3 py-2 text-left rounded-l">Medicine</th>
                    <th class="px-3 py-2 text-left">Type</th>
                    <th class="px-3 py-2 text-left">Qty</th>
                    <th class="px-3 py-2 text-left">User</th>
                    <th class="px-3 py-2 text-left rounded-r">Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @if(isset($recentMovements) && $recentMovements->count() > 0)
                @foreach($recentMovements as $movement)
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-3 font-medium text-gray-800">
                        {{ optional($movement->medicine)->name ?? 'N/A' }}
                    </td>
                    <td class="px-3 py-3">
                        @if($movement->type === 'in')
                        <span
                            class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs"
                            >Stock  In</span
                        >
                        @else
                        <span
                            class="px-2 py-1 bg-purple-100 text-purple-700 rounded  text-xs"
                            >Sale</span
                        >
                        @endif
                    </td>
                    <td class="px-3 py-3">{{ $movement->quantity }}</td>
                    <td class="px-3 py-3 text-gray-600">
                        {{ optional($movement->user)->name ??  'System' }}
                    </td>
                    <td class="px-3 py-3 text-gray-500 text-xs">
                        {{  $movement->created_at->diffForHumans() }}
                    </td>
                </tr>
                @endforeach @else
                <tr>
                    <td colspan="5" class="px-3 py-6 text-center text-gray-400">
                        No stock movements yet
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
