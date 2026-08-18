@extends('layouts.app')

@section('title', 'New Sale')
@section('page_title', 'New Sale')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow">

        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Record New Sale</h2>
            <p class="text-sm text-gray-500 mt-1">Sell medicine to customer (FIFO auto-applied)</p>
        </div>

        <form action="{{ route('sales.store') }}" method="POST" class="p-6 space-y-4" id="saleForm">
            @csrf

            {{-- Medicine --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Medicine <span class="text-red-500">*</span></label>
                <select name="medicine_id" id="medicine_id" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('medicine_id') border-red-500 @enderror">
                    <option value="">Select Medicine</option>
                    @foreach($medicines as $medicine)
                        @php
                            $batchData = $medicine->batches->map(function($b) {
                                return [
                                    'number' => $b->batch_number,
                                    'remaining' => $b->remaining_quantity,
                                    'expiry' => $b->expiry_date->format('M d, Y')
                                ];
                            });
                        @endphp
                    <option value="{{ $medicine->id }}" 
                            data-unit="{{ $medicine->unit }}"
                            data-price="{{ $medicine->unit_price }}"
                            data-stock="{{ $medicine->totalStock() }}"
                            data-batches='{{ $batchData->toJson() }}'
                            {{ old('medicine_id') == $medicine->id ? 'selected' : '' }}>
                        {{ $medicine->name }} (Stock: {{ $medicine->totalStock() }} {{ $medicine->unit }})
                    </option>
                    @endforeach
                </select>
                @error('medicine_id')
                    <p class="text-red-500 text-xs mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Batch Preview (FIFO) --}}
            <div id="batchPreview" class="bg-gray-50 rounded-lg p-4" style="display: none;">
                <p class="text-xs font-semibold text-gray-500 uppercase mb-2">FIFO Batch Order (Oldest First)</p>
                <div id="batchList" class="space-y-2"></div>
            </div>

            {{-- Quantity --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Quantity <span class="text-red-500">*</span>
                        <span id="unitLabel" class="text-xs text-gray-400 font-normal">(base unit)</span>
                    </label>
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" required min="1"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('quantity') border-red-500 @enderror"
                           placeholder="e.g., 10">
                    @error('quantity')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs text-gray-400 mt-1" id="stockInfo">Select medicine to see available stock</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Customer Name</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
                           placeholder="Optional">
                </div>
            </div>

            {{-- Total Calculation --}}
            <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4" id="totalBox" style="display: none;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-emerald-800">Sale Total</p>
                        <p class="text-xs text-emerald-600" id="totalDetail">0 units @ Rs. 0.00</p>
                    </div>
                    <p class="text-2xl font-bold text-emerald-700" id="totalAmount">Rs. 0.00</p>
                </div>
            </div>

            {{-- Notes --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <textarea name="notes" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500" placeholder="Optional">{{ old('notes') }}</textarea>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors">
                    Complete Sale
                </button>
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                    Cancel
                </a>
            </div>
        </form>

    </div>
</div>

<script>
    document.getElementById('medicine_id').addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        if (!this.value) {
            document.getElementById('batchPreview').style.display = 'none';
            document.getElementById('stockInfo').textContent = 'Select medicine to see available stock';
            return;
        }

        const unit = option.getAttribute('data-unit');
        const price = parseFloat(option.getAttribute('data-price'));
        const stock = parseInt(option.getAttribute('data-stock'));
        const batches = JSON.parse(option.getAttribute('data-batches'));

        document.getElementById('unitLabel').textContent = '(' + unit + 's)';
        document.getElementById('stockInfo').textContent = 'Available: ' + stock + ' ' + unit;
        document.getElementById('stockInfo').className = stock > 0 ? 'text-xs text-emerald-600 mt-1' : 'text-xs text-red-600 mt-1';

        // Show batch preview
        const batchList = document.getElementById('batchList');
        batchList.innerHTML = '';
        batches.forEach((batch, index) => {
            const div = document.createElement('div');
            div.className = 'flex items-center justify-between text-sm p-2 rounded ' + (index === 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-white text-gray-600');
            div.innerHTML = '<span>' + batch.number + ' (Exp: ' + batch.expiry + ')</span><span class="font-medium">' + batch.remaining + ' left</span>';
            batchList.appendChild(div);
        });
        document.getElementById('batchPreview').style.display = 'block';

        updateTotal();
    });

    document.getElementById('quantity').addEventListener('input', updateTotal);

    function updateTotal() {
        const medicineSelect = document.getElementById('medicine_id');
        const option = medicineSelect.options[medicineSelect.selectedIndex];
        if (!medicineSelect.value) {
            document.getElementById('totalBox').style.display = 'none';
            return;
        }

        const price = parseFloat(option.getAttribute('data-price')) || 0;
        const qty = parseInt(document.getElementById('quantity').value) || 0;
        const total = qty * price;

        if (qty > 0) {
            document.getElementById('totalBox').style.display = 'block';
            document.getElementById('totalDetail').textContent = qty + ' units @ Rs. ' + price.toFixed(2);
            document.getElementById('totalAmount').textContent = 'Rs. ' + total.toFixed(2);
        } else {
            document.getElementById('totalBox').style.display = 'none';
        }
    }
</script>

@endsection