<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;   

class StockMovement extends Model
{
    
    protected $fillable = [
        'medicine_id',   // Konsi medicine ka movement hai (Panadol, Calpol, etc.)
        'batch_id',      // Konsi batch se stock move hua (PN-12345)
        'type',          // 'in' = stock aaya (purchase), 'out' = stock gaya (sale)
        'quantity',      // Kitni quantity move hui (e.g., 2 tablets, 1 strip)
        'unit_price',    // Us waqt per unit price (e.g., Rs. 5 per tablet)
        'total_price',   // quantity * unit_price (e.g., 2 * 5 = Rs. 10)
        'reference_type',// Kis transaction se linked hai (sale/purchase)
        'reference_id',  // Us transaction ka ID (e.g., Sale # 101)
        'notes',         // Extra info (e.g., urgent sale, damaged stock)
        'user_id'        // Kaunsa staff ne transaction kiya
    ];

    public function medicine(): BelongsTo
    {
        // Har stock movement ek medicine se belong karta hai
        // Example: Movement -> Medicine: Panadol
        return $this->belongsTo(Medicine::class);
    }

    public function batch(): BelongsTo
    {
        // Har stock movement ek batch se belong karta hai
        // Example: Movement -> Batch: PN-12345
        return $this->belongsTo(Batch::class);
    }

    public function user(): BelongsTo
    {
        // Har stock movement ek user (staff) se belong karta hai
        // Example: Movement -> User: Cashier #3
        return $this->belongsTo(User::class);
    }

}
