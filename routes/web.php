<?php
use App\Http\Controllers\BatchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SupplierController;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Route;

// BREEZE AUTH ROUTES
require __DIR__.'/auth.php';

// AUTHENTICATED ROUTES
Route::middleware(['auth'])->group(function () {

    // Profile routes (Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('logout', Logout::class)->name('logout');

    // Dashboard (Both admin & staff)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
    // ADMIN ONLY
    Route::middleware(['admin'])->group(function () {
        
        // Categories
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        
        // Suppliers
        Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
        Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
        Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
        Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
        Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
        Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

        // Medicines (Admin CRUD)
        Route::get('/medicines/create', [MedicineController::class, 'create'])->name('medicines.create');
        Route::post('/medicines', [MedicineController::class, 'store'])->name('medicines.store');
        Route::get('/medicines/{medicine}/edit', [MedicineController::class, 'edit'])->name('medicines.edit');
        Route::put('/medicines/{medicine}', [MedicineController::class, 'update'])->name('medicines.update');
        Route::delete('/medicines/{medicine}', [MedicineController::class, 'destroy'])->name('medicines.destroy');

        // Batches (Admin CRUD)
        Route::get('/batches/create', [BatchController::class, 'create'])->name('batches.create');
        Route::post('/batches', [BatchController::class, 'store'])->name('batches.store');
        Route::delete('/batches/{batch}', [BatchController::class, 'destroy'])->name('batches.destroy');

        // Settings (UPDATED - Real controller)
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    
    });

    // BOTH ADMIN & STAFF
    Route::middleware(['staff'])->group(function () {

        // Medicines (View for all, CRUD for admin)
        Route::get('/medicines', [MedicineController::class, 'index'])->name('medicines.index');
        Route::get('/medicines/{medicine}', [MedicineController::class, 'show'])->name('medicines.show');

        // Batches (View for all)
        Route::get('/batches', [BatchController::class, 'index'])->name('batches.index');
        Route::get('/batches/{batch}', [BatchController::class, 'show'])->name('batches.show');

        // Sales
        Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
        Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');

        // Reports
        Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
        Route::get('/reports/expiry', [ReportController::class, 'expiry'])->name('reports.expiry');
        Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');

    });
});
    
// HOME REDIRECT
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('welcome');
});
