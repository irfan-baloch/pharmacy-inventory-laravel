<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;  
use Illuminate\Database\Eloquent\Relations\HasMany;    

class Medicine extends Model
{
    
    protected $fillable = [
        'category_id', 'name', 'generic_name', 'brand',
        'description', 'unit_price', 'unit', 'pack_size', 'pack_unit',
        'low_stock_threshold', 'image', 'is_active'
    ];

    // Relationship: Medicine belongs to one Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship: Medicine has many Batches
    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class);
    }

    // Relationship: Medicine has many Stock Movements
    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    // Helper: 1 pack = kitni base units
    public function packQuantity(): int
    {
        return $this->pack_size ?? 1;
    }

    // Helper: Full pack name e.g., "10 tablets per strip"
    public function packagingInfo(): string
    {
        return $this->pack_size . ' ' . $this->unit . ' per ' . $this->pack_unit;
    }

    // Helper: Total stock across all batches (sab batches ka remaining total)
    public function totalStock(): int
    {
        return $this->batches()->sum('remaining_quantity');
    }

    // Helper: Check if stock is low
    public function isLowStock(): bool
    {
        return $this->totalStock() <= $this->low_stock_threshold;
    }

}
