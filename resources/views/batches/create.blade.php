@extends('layouts.app')

@section('title', 'Stock In (Purchase)')
@section('page_title', 'Stock In (Purchase)')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow">

        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Add New Stock (Purchase)</h2>
            <p class="text-sm text-gray-500 mt-1">Record medicine purchase from supplier</p>
        </div>

        <form action="{{ route('batches.store') }}" method="POST" class="p-6 space-y-4" id="stockInForm">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Medicine --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Medicine <span class="text-red-500">*</span></label>
                    <select name="medicine_id" id="medicine_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('medicine_id') border-red-500 @enderror">
                        <option value="">Select Medicine</option>
                        @foreach($medicines as $medicine)
                            <option value="{{ $medicine->id }}" 
                                    data-pack-size="{{ $medicine->pack_size }}" 
                                    data-pack-unit="{{ $medicine->pack_unit }}"
                                    data-unit="{{ $medicine->unit }}"
                                    data-unit-price="{{ $medicine->unit_price }}"
                                    {{ old('medicine_id') == $medicine->id ? 'selected' : '' }}>
                                {{ $medicine->name }} ({{ $medicine->pack_size }} {{ $medicine->unit }}/{{ $medicine->pack_unit }})
                            </option>
                        @endforeach
                    </select>
                    @error('medicine_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs text-gray-400 mt-1" id="packagingInfo">Select a medicine to see packaging details</p>
                </div>

                {{-- Batch Number --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Batch Number <span class="text-red-500">*</span></label>
                    <input type="text" name="batch_number" value="{{ old('batch_number') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('batch_number') border-red-500 @enderror"
                           placeholder="e.g., PN-2026-A">
                    @error('batch_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Supplier --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
                    <select name="supplier_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                        <option value="">Select Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Quantity (in Packs) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Quantity <span class="text-red-500">*</span>
                        <span id="qtyLabel" class="text-xs text-gray-400 font-normal">(packs)</span>
                    </label>
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" required min="1"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('quantity') border-red-500 @enderror"
                           placeholder="e.g., 50">
                    @error('quantity')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs text-emerald-600 mt-1" id="calculation">Enter quantity to see base unit calculation</p>
                </div>

                {{-- Purchase Price per Unit --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Purchase Price per Unit (Rs.) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="purchase_price" id="purchase_price" value="{{ old('purchase_price') }}" required min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('purchase_price') border-red-500 @enderror"
                           placeholder="e.g., 3.50">
                    @error('purchase_price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs text-gray-400 mt-1">Per base unit cost (not per pack)</p>
                </div>

                {{-- Expiry Date --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date <span class="text-red-500">*</span></label>
                    <input type="date" name="expiry_date" value="{{ old('expiry_date') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('expiry_date') border-red-500 @enderror">
                    @error('expiry_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Purchase Date --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Purchase Date <span class="text-red-500">*</span></label>
                    <input type="date" name="purchase_date" value="{{ old('purchase_date', date('Y-m-d')) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('purchase_date') border-red-500 @enderror">
                    @error('purchase_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Notes --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <textarea name="notes" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500" placeholder="Optional notes">{{ old('notes') }}</textarea>
            </div>

            {{-- Summary Box --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4" id="summaryBox" style="display: none;">
                <p class="text-sm font-medium text-blue-800 mb-1">Purchase Summary</p>
                <p class="text-sm text-blue-700" id="summaryText">Select medicine and enter quantity to see summary</p>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors">
                    Record Purchase
                </button>
                <a href="{{ route('batches.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                    Cancel
                </a>
            </div>
        </form>

    </div>
</div>

<script>
    document.getElementById('medicine_id').addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        const packSize = option.getAttribute('data-pack-size');
        const packUnit = option.getAttribute('data-pack-unit');
        const unit = option.getAttribute('data-unit');

        if (packSize && packUnit) {
            document.getElementById('packagingInfo').textContent = 
                `Packaging: ${packSize} ${unit} per ${packUnit}`;
            document.getElementById('qtyLabel').textContent = `(${packUnit}s)`;
        }
        updateCalculation();
    });

    document.getElementById('quantity').addEventListener('input', updateCalculation);
    document.getElementById('purchase_price').addEventListener('input', updateCalculation);

    function updateCalculation() {
        const medicineSelect = document.getElementById('medicine_id');
        const option = medicineSelect.options[medicineSelect.selectedIndex];
        const packSize = parseInt(option.getAttribute('data-pack-size')) || 1;
        const packUnit = option.getAttribute('data-pack-unit') || 'pack';
        const unit = option.getAttribute('data-unit') || 'unit';
        const qty = parseInt(document.getElementById('quantity').value) || 0;
        const price = parseFloat(document.getElementById('purchase_price').value) || 0;

        const baseQty = qty * packSize;
        const totalCost = baseQty * price;

        if (qty > 0 && medicineSelect.value) {
            document.getElementById('calculation').textContent = 
                `${qty} ${packUnit} = ${baseQty} ${unit}`;
            document.getElementById('summaryBox').style.display = 'block';
            document.getElementById('summaryText').textContent = 
                `You are purchasing ${qty} ${packUnit} (${baseQty} ${unit}) at Rs. ${price}/${unit}. Total cost: Rs. ${totalCost.toFixed(2)}`;
        } else {
            document.getElementById('calculation').textContent = 'Enter quantity to see base unit calculation';
            document.getElementById('summaryBox').style.display = 'none';
        }
    }
</script>

@endsection