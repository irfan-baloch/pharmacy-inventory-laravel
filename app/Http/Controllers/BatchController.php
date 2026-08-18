<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Medicine;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    // LIST all batches
    public function index()
    {
        $batches = Batch::with(['medicine', 'supplier'])
            ->latest()
            ->paginate(15);
        return view('batches.index', compact('batches'));
    }

    // SHOW create form (Stock In)
    public function create()
    {
        $medicines = Medicine::where('is_active', true)->orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        return view('batches.create', compact('medicines', 'suppliers'));
    }

    // STORE new batch (Stock In)
    public function store(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'batch_number' => 'required|string|max:255',
            'expiry_date' => 'required|date|after:today',
            'quantity' => 'required|integer|min:1',
            'purchase_price' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Get medicine to convert pack to base unit
        $medicine = Medicine::findOrFail($request->medicine_id);

        // User enters quantity in PACKS (e.g., 50 strips)
        // System stores in BASE UNITS (e.g., 500 tablets)
        $packQuantity = $request->quantity;
        $baseQuantity = $packQuantity * $medicine->pack_size;

        // Create batch
        $batch = Batch::create([
            'medicine_id' => $request->medicine_id,
            'supplier_id' => $request->supplier_id,
            'batch_number' => $request->batch_number,
            'expiry_date' => $request->expiry_date,
            'quantity' => $baseQuantity,
            'remaining_quantity' => $baseQuantity,
            'purchase_price' => $request->purchase_price,
            'purchase_date' => $request->purchase_date,
        ]);

        // Record stock movement (Stock In)
        StockMovement::create([
            'medicine_id' => $request->medicine_id,
            'batch_id' => $batch->id,
            'type' => 'in',
            'quantity' => $baseQuantity,
            'unit_price' => $request->purchase_price,
            'total_price' => $baseQuantity * $request->purchase_price,
            'notes' => $request->notes,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('batches.index')->with('success', 
            "Stock added: {$packQuantity} {$medicine->pack_unit} ({$baseQuantity} {$medicine->unit}) of {$medicine->name}");
    }

    // SHOW single batch details
    public function show(Batch $batch)
    {
        $batch->load(['medicine', 'supplier', 'stockMovements.user']);
        return view('batches.show', compact('batch'));
    }

    // DELETE batch
    public function destroy(Batch $batch)
    {
        // Check if batch has sales (stock movements of type 'out')
        $hasSales = StockMovement::where('batch_id', $batch->id)->where('type', 'out')->exists();

        if ($hasSales) {
            return redirect()->route('batches.index')->with('error', 
                'Cannot delete batch with sales history. It has already been sold.');
        }

        // Delete related stock movements (type 'in')
        StockMovement::where('batch_id', $batch->id)->where('type', 'in')->delete();

        $batch->delete();
        return redirect()->route('batches.index')->with('success', 'Batch deleted successfully.');
    }
}