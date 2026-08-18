<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Medicine;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    // SHOW sale form
    public function create()
    {
        $medicines = Medicine::where('is_active', true)
            ->with(['batches' => function ($query) {
                $query->where('remaining_quantity', '>', 0)
                      ->where('expiry_date', '>=', now())
                      ->orderBy('expiry_date', 'asc'); // FIFO: oldest first
            }])
            ->orderBy('name')
            ->get();

        return view('sales.create', compact('medicines'));
    }

    // PROCESS sale
    public function store(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1',
            'customer_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $medicine = Medicine::findOrFail($request->medicine_id);
        $requestedQty = $request->quantity;

        // Check total available stock
        $totalAvailable = $medicine->totalStock();
        if ($requestedQty > $totalAvailable) {
            return back()->with('error', "Insufficient stock! Available: {$totalAvailable} {$medicine->unit}, Requested: {$requestedQty} {$medicine->unit}")
                         ->withInput();
        }

        // FIFO: Get batches ordered by expiry date (oldest first)
        $batches = Batch::where('medicine_id', $medicine->id)
            ->where('remaining_quantity', '>', 0)
            ->where('expiry_date', '>=', now())
            ->orderBy('expiry_date', 'asc')
            ->lockForUpdate() // Prevent concurrent sales
            ->get();

        $remainingToDeduct = $requestedQty;
        $saleDetails = [];
        $totalSalePrice = 0;

        DB::beginTransaction();

        try {
            foreach ($batches as $batch) {
                if ($remainingToDeduct <= 0) break;

                $deductFromBatch = min($batch->remaining_quantity, $remainingToDeduct);

                // Update batch
                $batch->remaining_quantity -= $deductFromBatch;
                $batch->save();

                // Calculate sale price
                $batchSalePrice = $deductFromBatch * $medicine->unit_price;
                $totalSalePrice += $batchSalePrice;

                // Record stock movement
                StockMovement::create([
                    'medicine_id' => $medicine->id,
                    'batch_id' => $batch->id,
                    'type' => 'out',
                    'quantity' => $deductFromBatch,
                    'unit_price' => $medicine->unit_price,
                    'total_price' => $batchSalePrice,
                    'notes' => $request->notes . ($request->customer_name ? " | Customer: {$request->customer_name}" : ""),
                    'user_id' => auth()->id(),
                ]);

                $saleDetails[] = [
                    'batch' => $batch->batch_number,
                    'qty' => $deductFromBatch,
                    'price' => $batchSalePrice,
                ];

                $remainingToDeduct -= $deductFromBatch;
            }

            DB::commit();

            // Build success message
            $detailsMsg = collect($saleDetails)->map(function ($d) {
                return "{$d['qty']} from {$d['batch']}";
            })->implode(', ');

            return redirect()->route('sales.create')->with('success', 
                "Sale recorded: {$requestedQty} {$medicine->unit} of {$medicine->name}. Total: Rs. " . number_format($totalSalePrice, 2) . 
                " ({$detailsMsg})");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Sale failed: ' . $e->getMessage())->withInput();
        }
    }
}