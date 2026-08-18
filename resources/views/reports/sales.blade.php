@extends('layouts.app')

@section('title', 'Sales Report')
@section('page_title', 'Sales Report')

@section('content')

<div class="space-y-6">

    

    {{-- Filters --}}
    <div class="bg-white rounded-lg shadow p-4">
        <form action="{{ route('reports.sales') }}" method="GET" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[140px]">
                <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ $startDate }}" 
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div class="flex-1 min-w-[140px]">
                <label class="block text-xs font-medium text-gray-500 uppercase mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ $endDate }}" 
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors h-[38px]">
                    Filter
                </button>
                <a href="{{ route('reports.sales') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors h-[38px]">
                    This Month
                </a>
            </div>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-sm text-gray-500">Total Sales</p>
            <p class="text-2xl font-bold text-emerald-600">{{ $currency }} {{ number_format($totalSales, 2) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-sm text-gray-500">Items Sold</p>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalQuantity) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-sm text-gray-500">Transactions</p>
            <p class="text-2xl font-bold text-gray-800">{{ $totalTransactions }}</p>
        </div>
    </div>

    {{-- Sales by Medicine --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Sales by Medicine</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Medicine</th>
                        <th class="px-6 py-3 text-right">Quantity Sold</th>
                        <th class="px-6 py-3 text-right">Total Revenue</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($salesByMedicine as $sale)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $sale['name'] }}</td>
                        <td class="px-6 py-4 text-right">{{ $sale['quantity'] }}</td>
                        <td class="px-6 py-4 text-right font-medium text-emerald-600">{{ $currency }} {{ number_format($sale['total'], 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500">No sales found for this period.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Detailed Transactions --}}
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">Detailed Transactions</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Medicine</th>
                        <th class="px-6 py-3">Qty</th>
                        <th class="px-6 py-3">Unit Price</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">User</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($movements as $movement)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-500 text-xs">{{ $movement->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ optional($movement->medicine)->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $movement->quantity }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $currency }} {{ number_format($movement->unit_price, 2) }}</td>
                        <td class="px-6 py-4 font-medium text-emerald-600">{{ $currency }} {{ number_format($movement->total_price, 2) }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ optional($movement->user)->name ?? 'System' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">No transactions found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection