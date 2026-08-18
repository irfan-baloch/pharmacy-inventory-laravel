<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;  
use Illuminate\Database\Eloquent\Relations\HasMany;  

class Category extends Model
{

    // Mass assignment protection - sirf yeh fields direct fill ho sakti hain
    protected $fillable = ['name', 'slug', 'description'];
    
    // Relationship: Ek Category ke bohat se Medicines hain
    public function medicines(): HasMany
    {
    return $this->hasMany(Medicine::class);
    }
    
}
