<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Medicine;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $totalMedicines = Medicine::where('is_active', true)->count();
        $totalStock = Batch::sum('remaining_quantity') ?? 0;
        $alertDays = (int) Setting::getValue('low_stock_alert_days', 30);
        $lowStockMedicines = Medicine::where('is_active', true)
            ->get()
            ->filter(function ($medicine) {
                return $medicine->isLowStock();
            });

        $lowStockCount = $lowStockMedicines->count();

        $expiringSoon = Batch::where('remaining_quantity', '>', 0)
            ->where('expiry_date', '<=', Carbon::now()->addDays($alertDays))
            ->where('expiry_date', '>=', Carbon::now())
            ->with('medicine')
            ->get();

        $expiringSoonCount = $expiringSoon->count();

        $expired = Batch::where('remaining_quantity', '>', 0)
            ->where('expiry_date', '<', Carbon::now())
            ->with('medicine')
            ->get();

        $expiredCount = $expired->count();

        $todaySales = StockMovement::where('type', 'out')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_price') ?? 0;

        $recentMovements = StockMovement::with(['medicine', 'user'])
            ->latest()
            ->take(10)
            ->get();
            
        $upcomingExpiry = Batch::where('remaining_quantity', '>', 0)
            ->where('expiry_date', '<=', Carbon::now()->addDays($alertDays))
            ->where('expiry_date', '>=', Carbon::now())
            ->with('medicine')
            ->orderBy('expiry_date', 'asc')
            ->take(5)
            ->get();

        $upcomingLowStock = Medicine::where('is_active', true)
            ->get()
            ->filter(function ($medicine) {
                return $medicine->isLowStock();
            })
            ->take(5);

        return view('dashboard', compact(
            'totalMedicines',
            'totalStock',
            'lowStockCount',
            'expiringSoonCount',
            'expiredCount',
            'todaySales',
            'recentMovements',
            'upcomingExpiry',
            'upcomingLowStock'
        ));
    }
}
