<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Medicine;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Setting;

class ReportController extends Controller
{
    // STOCK REPORT
    public function stock(Request $request)
    {

        $currency = Setting::getValue('currency', 'Rs.');

        $query = Medicine::with('category')
            ->where('is_active', true)
            ->orderBy('name');

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by stock status
        if ($request->stock_status === 'low') {
            $medicines = $query->get()->filter(function ($m) {
                return $m->isLowStock();
            });
        } elseif ($request->stock_status === 'out') {
            $medicines = $query->get()->filter(function ($m) {
                return $m->totalStock() == 0;
            });
        } else {
            $medicines = $query->get();
        }

        $categories = \App\Models\Category::orderBy('name')->get();

        return view('reports.stock', compact('medicines', 'categories', 'currency'));
    }

    // EXPIRY REPORT
    public function expiry(Request $request)
    {
        $days = (int) $request->get('days', 30);
        $status = $request->get('status', 'all');
        $currency = Setting::getValue('currency', 'Rs.');

        $query = Batch::with(['medicine', 'supplier'])
            ->where('remaining_quantity', '>', 0)
            ->orderBy('expiry_date', 'asc');

        if ($status === 'expired') {
            $query->where('expiry_date', '<', Carbon::now());
        } elseif ($status === 'expiring') {
            $query->where('expiry_date', '>=', Carbon::now())
                  ->where('expiry_date', '<=', Carbon::now()->addDays($days));
        } elseif ($status === 'safe') {
            $query->where('expiry_date', '>', Carbon::now()->addDays($days));
        }

        $batches = $query->get();

        // Summary counts
        $expiredCount = Batch::where('remaining_quantity', '>', 0)
            ->where('expiry_date', '<', Carbon::now())->count();

        $expiringCount = Batch::where('remaining_quantity', '>', 0)
            ->where('expiry_date', '>=', Carbon::now())
            ->where('expiry_date', '<=', Carbon::now()->addDays(30))->count();

        $safeCount = Batch::where('remaining_quantity', '>', 0)
            ->where('expiry_date', '>', Carbon::now()->addDays(30))->count();

        return view('reports.expiry', compact('batches', 'days', 'status', 'expiredCount', 'expiringCount', 'safeCount', 'currency'));
    }

    // SALES REPORT
    public function sales(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        $currency = Setting::getValue('currency', 'Rs.');

        $movements = StockMovement::with(['medicine', 'user'])
            ->where('type', 'out')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalSales = $movements->sum('total_price');
        $totalQuantity = $movements->sum('quantity');
        $totalTransactions = $movements->count();

        // Group by medicine
        $salesByMedicine = $movements->groupBy('medicine_id')->map(function ($items) {
            return [
                'name' => $items->first()->medicine->name ?? 'Unknown',
                'quantity' => $items->sum('quantity'),
                'total' => $items->sum('total_price'),
            ];
        })->sortByDesc('total');

        return view('reports.sales', compact('movements', 'startDate', 'endDate', 'totalSales', 'totalQuantity', 'totalTransactions', 'salesByMedicine', 'currency'));
    }
}