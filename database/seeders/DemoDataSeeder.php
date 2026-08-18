<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\StockMovement;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin User
        // User::create([
        //     'name' => 'Admin User',
        //     'email' => 'admin@pharma.com',
        //     'password' => Hash::make('password'),
        //     'role' => 'admin',
        // ]);

        // 2. Create Staff User
        // User::create([
        //     'name' => 'Staff Member',
        //     'email' => 'staff@pharma.com',
        //     'password' => Hash::make('password'),
        //     'role' => 'staff',
        // ]);

        // 3. Create Categories
        $categories = [
            ['name' => 'Tablet', 'slug' => 'tablet', 'description' => 'Oral solid dosage forms'],
            ['name' => 'Syrup', 'slug' => 'syrup', 'description' => 'Liquid oral medications'],
            ['name' => 'Injection', 'slug' => 'injection', 'description' => 'Injectable medications'],
            ['name' => 'Capsule', 'slug' => 'capsule', 'description' => 'Capsule dosage forms'],
            ['name' => 'Cream', 'slug' => 'cream', 'description' => 'Topical applications'],
        ];
        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // 4. Create Suppliers
        $suppliers = [
            ['name' => 'Getz Pharma', 'phone' => '0300-1234567', 'email' => 'getz@pharma.com', 'address' => 'Karachi, Pakistan'],
            ['name' => 'Sami Pharma', 'phone' => '0300-7654321', 'email' => 'sami@pharma.com', 'address' => 'Lahore, Pakistan'],
            ['name' => 'Barrett Hodgson', 'phone' => '0300-1112223', 'email' => 'bh@pharma.com', 'address' => 'Karachi, Pakistan'],
        ];
        foreach ($suppliers as $sup) {
            Supplier::create($sup);
        }

        // 5. Create Medicines
        $medicines = [
            [
                'category_id' => 1, 'name' => 'Panadol 500mg', 'generic_name' => 'Paracetamol',
                'brand' => 'GSK', 'unit_price' => 5.00, 'unit' => 'tablet', 'pack_size' => 10, 'pack_unit' => 'strip',
                'low_stock_threshold' => 50, 'is_active' => true,
            ],
            [
                'category_id' => 1, 'name' => 'Brufen 400mg', 'generic_name' => 'Ibuprofen',
                'brand' => 'Abbott', 'unit_price' => 8.00, 'unit' => 'tablet', 'pack_size' => 10, 'pack_unit' => 'strip',
                'low_stock_threshold' => 30, 'is_active' => true,
            ],
            [
                'category_id' => 2, 'name' => 'Augmentin Syrup', 'generic_name' => 'Amoxicillin',
                'brand' => 'GSK', 'unit_price' => 250.00, 'unit' => 'bottle', 'pack_size' => 1, 'pack_unit' => 'bottle',
                'low_stock_threshold' => 5, 'is_active' => true,
            ],
            [
                'category_id' => 3, 'name' => 'Insulin Glargine', 'generic_name' => 'Insulin',
                'brand' => 'Sanofi', 'unit_price' => 1200.00, 'unit' => 'vial', 'pack_size' => 1, 'pack_unit' => 'vial',
                'low_stock_threshold' => 3, 'is_active' => true,
            ],
            [
                'category_id' => 1, 'name' => 'Flagyl 400mg', 'generic_name' => 'Metronidazole',
                'brand' => 'Sanofi', 'unit_price' => 12.00, 'unit' => 'tablet', 'pack_size' => 10, 'pack_unit' => 'strip',
                'low_stock_threshold' => 20, 'is_active' => true,
            ],
        ];
        foreach ($medicines as $med) {
            Medicine::create($med);
        }

        // 6. Create Batches (with various expiry scenarios)
        $batches = [
            // Panadol - Normal stock
            ['medicine_id' => 1, 'supplier_id' => 1, 'batch_number' => 'PN-2026-A', 'expiry_date' => '2027-06-15', 'quantity' => 500, 'remaining_quantity' => 350, 'purchase_price' => 3.50, 'purchase_date' => '2026-01-15'],
            ['medicine_id' => 1, 'supplier_id' => 1, 'batch_number' => 'PN-2026-B', 'expiry_date' => '2027-12-20', 'quantity' => 300, 'remaining_quantity' => 300, 'purchase_price' => 3.80, 'purchase_date' => '2026-05-10'],
            
            // Brufen - Low stock
            ['medicine_id' => 2, 'supplier_id' => 2, 'batch_number' => 'BR-2026-A', 'expiry_date' => '2027-08-30', 'quantity' => 200, 'remaining_quantity' => 15, 'purchase_price' => 5.50, 'purchase_date' => '2026-02-20'],
            
            // Augmentin - Normal
            ['medicine_id' => 3, 'supplier_id' => 1, 'batch_number' => 'AU-2026-A', 'expiry_date' => '2027-03-10', 'quantity' => 50, 'remaining_quantity' => 22, 'purchase_price' => 180.00, 'purchase_date' => '2026-03-05'],
            
            // Insulin - Expiring soon
            ['medicine_id' => 4, 'supplier_id' => 3, 'batch_number' => 'IN-2026-A', 'expiry_date' => '2026-08-25', 'quantity' => 20, 'remaining_quantity' => 8, 'purchase_price' => 950.00, 'purchase_date' => '2026-01-10'],
            
            // Flagyl - Expired
            ['medicine_id' => 5, 'supplier_id' => 2, 'batch_number' => 'FL-2025-A', 'expiry_date' => '2026-05-01', 'quantity' => 100, 'remaining_quantity' => 40, 'purchase_price' => 8.00, 'purchase_date' => '2025-08-15'],
        ];
        foreach ($batches as $batch) {
            Batch::create($batch);
        }

        // 7. Create some stock movements (sales)
        $movements = [
            ['medicine_id' => 1, 'batch_id' => 1, 'type' => 'out', 'quantity' => 50, 'unit_price' => 5.00, 'total_price' => 250.00, 'user_id' => 2, 'created_at' => Carbon::now()->subHours(2)],
            ['medicine_id' => 1, 'batch_id' => 1, 'type' => 'out', 'quantity' => 100, 'unit_price' => 5.00, 'total_price' => 500.00, 'user_id' => 2, 'created_at' => Carbon::now()->subHours(5)],
            ['medicine_id' => 2, 'batch_id' => 3, 'type' => 'out', 'quantity' => 30, 'unit_price' => 8.00, 'total_price' => 240.00, 'user_id' => 2, 'created_at' => Carbon::now()->subDay()],
            ['medicine_id' => 3, 'batch_id' => 4, 'type' => 'out', 'quantity' => 5, 'unit_price' => 250.00, 'total_price' => 1250.00, 'user_id' => 2, 'created_at' => Carbon::now()->subDays(2)],
            ['medicine_id' => 1, 'batch_id' => 1, 'type' => 'in', 'quantity' => 500, 'unit_price' => 3.50, 'total_price' => 1750.00, 'user_id' => 1, 'created_at' => Carbon::now()->subDays(10)],
        ];
        foreach ($movements as $mov) {
            StockMovement::create($mov);
        }
    }
}