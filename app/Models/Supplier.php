<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;  

class Supplier extends Model
{
    
    protected $fillable = ['name', 'phone', 'email', 'address'];
    
    // Relationship: Ek Supplier ne bohat si Batches supply ki hain
    public function batches(): HasMany
    {
    return $this->hasMany(Batch::class);
    }

}
