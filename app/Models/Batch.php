<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;  
use Illuminate\Database\Eloquent\Relations\HasMany;  

class Batch extends Model
{
    
    protected $fillable = [
        'medicine_id', 'supplier_id', 'batch_number',
        'expiry_date', 'quantity', 'remaining_quantity',
        'purchase_price', 'purchase_date'
    ];

    // Cast dates to Carbon objects (date manipulation ke liye)
    protected $casts = [
        'expiry_date' => 'date',
        'purchase_date' => 'date',
    ];
    

    // Har batch ek medicine se belong karta hai
    // e.g., Batch PN-12345 -> Medicine: Panadol
    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }

    // Har batch ek supplier se belong karta hai (optional)
    // e.g., Batch PN-12345 -> Supplier: GSK
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    // Har batch ke multiple stock movements ho sakte hain
    // e.g., Batch PN-12345 -> 100 strips purchase, 20 strips sale
    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    // Helper: Check if batch is expired
    public function isExpired(): bool
    {
        return $this->expiry_date->isPast();
    }

    // Helper: Days until expiry (negative = already expired)
    public function daysUntilExpiry(): int
    {
        // Batata hai ke expiry tak kitne din bache hain
        // Negative value ka matlab hai batch already expire ho chuka hai
        // e.g., Expiry = 2026-08-15 -> aaj 2026-07-28 -> 18 din bache
        return now()->diffInDays($this->expiry_date, false);
    }

}
