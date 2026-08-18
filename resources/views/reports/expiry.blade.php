@extends('layouts.app')

@section('title', 'Expiry Report')
@section('page_title', 'Expiry Report')

@section('content')

<div class="space-y-6">

    <button onclick="window.print()" class="no-print bg-gray-700 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
        🖨 Print Report
    </button>

    {{-- Filters --}}
    <div class="bg-white rounded-lg shadow p-4">
        <form action="{{ route('reports.expiry') }}" method="GET" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[140px]">
                <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                    <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All</option>
                    <option value="expired" {{ $status == 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="expiring" {{ $status == 'expiring' ? 'selected' : '' }}>Expiring Soon</option>
                    <option value="safe" {{ $status == 'safe' ? 'selected' : '' }}>Safe</option>
                </select>
            </div>
            <div class="w-24">
                <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Within Days</label>
                <input type="number" name="days" value="{{ $days }}" min="1" max="365"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors h-[38px]">
                    Filter
                </button>
                <a href="{{ route('reports.expiry') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors h-[38px]">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow p-5 border-l-4 border-red-500">
            <p class="text-sm text-gray-500">Expired</p>
            <p class="text-2xl font-bold text-red-600">{{ $expiredCount }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-5 border-l-4 border-orange-500">
            <p class="text-sm text-gray-500">Expiring ({{ $days }} days)</p>
            <p class="text-2xl font-bold text-orange-600">{{ $expiringCount }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-5 border-l-4 border-green-500">
            <p class="text-sm text-gray-500">Safe</p>
            <p class="text-2xl font-bold text-green-600">{{ $safeCount }}</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Batch #</th>
                        <th class="px-6 py-3">Medicine</th>
                        <th class="px-6 py-3">Supplier</th>
                        <th class="px-6 py-3">Expiry Date</th>
                        <th class="px-6 py-3">Days Left</th>
                        <th class="px-6 py-3">Remaining</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($batches as $batch)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $batch->batch_number }}</td>
                        <td class="px-6 py-4">{{ optional($batch->medicine)->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ optional($batch->supplier)->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $batch->expiry_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 font-medium {{ $batch->isExpired() ? 'text-red-600' : ($batch->daysUntilExpiry() <= 30 ? 'text-orange-600' : 'text-gray-900') }}">{{ $batch->daysUntilExpiry() }}</td>
                        <td class="px-6 py-4">{{ $batch->remaining_quantity }} {{ optional($batch->medicine)->unit }}</td>
                        <td class="px-6 py-4">
                            @if($batch->isExpired())
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-medium">Expired</span>
                            @elseif($batch->daysUntilExpiry() <= 30)
                                <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded text-xs font-medium">Expiring Soon</span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium">Safe</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">No batches found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection