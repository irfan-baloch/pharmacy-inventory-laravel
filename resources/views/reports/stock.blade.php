@extends('layouts.app')

@section('title', 'Stock Report')
@section('page_title', 'Stock Report')

@section('content')

<div class="space-y-6">

    <button onclick="window.print()" class="no-print bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
        🖨 Print Report
    </button>
    {{-- Filters --}}
    <div class="bg-white rounded-lg shadow p-4">
        <form action="{{ route('reports.stock') }}" method="GET" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[140px]">
                <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Category</label>
                <select name="category_id" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[140px]">
                <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Stock Status</label>
                <select name="stock_status" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                    <option value="all" {{ request('stock_status') == 'all' ? 'selected' : '' }}>All</option>
                    <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Low Stock</option>
                    <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-3 rounded-lg text-sm font-medium transition-colors h-[38px]">
                    Filter
                </button>
                <a href="{{ route('reports.stock') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors h-[38px]">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-sm text-gray-500">Total Medicines</p>
            <p class="text-2xl font-bold text-gray-800">{{ $medicines->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-sm text-gray-500">Low Stock</p>
            <p class="text-2xl font-bold text-amber-600">{{ $medicines->filter(function($m){ return $m->isLowStock(); })->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-sm text-gray-500">Out of Stock</p>
            <p class="text-2xl font-bold text-red-600">{{ $medicines->filter(function($m){ return $m->totalStock() == 0; })->count() }}</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Medicine</th>
                        <th class="px-6 py-3">Category</th>
                        <th class="px-6 py-3">Unit Price</th>
                        <th class="px-6 py-3">Stock</th>
                        <th class="px-6 py-3">Threshold</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($medicines as $medicine)
                    @php $stock = $medicine->totalStock(); @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900">{{ $medicine->name }}</p>
                            <p class="text-xs text-gray-500">{{ $medicine->generic_name ?? '' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">{{ optional($medicine->category)->name ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-900">{{ $currency }} {{ number_format($medicine->unit_price, 2) }}</td>
                        <td class="px-6 py-4 font-medium {{ $stock == 0 ? 'text-red-600' : ($medicine->isLowStock() ? 'text-amber-600' : 'text-gray-900') }}">{{ $stock }} {{ $medicine->unit }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $medicine->low_stock_threshold }}</td>
                        <td class="px-6 py-4">
                            @if($stock == 0)
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-medium">Out of Stock</span>
                            @elseif($medicine->isLowStock())
                                <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded text-xs font-medium">Low Stock</span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium">OK</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">No medicines found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection  