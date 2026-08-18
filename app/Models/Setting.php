<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Setting extends Model
{
    
    protected $fillable = [
        'key',          // 'key' = setting ka naam (e.g., "site_name")
        'value',        // 'value' = us setting ki value (e.g., "My Pharmacy")
    ];
    
    // Static helper: Setting value get karna (easy syntax)
    public static function getValue(string $key, mixed $default = null): mixed
    {
        // Database me 'key' search karega
        $setting = self::where('key', $key)->first();

        // Agar mila to uski 'value' return karega, warna default value
        return $setting ? $setting->value : $default;
    }

    // Static helper: Setting value save/update karna
    public static function setValue(string $key, mixed $value): void
    {
        // Agar key exist karti hai to update karega, warna new record create karega
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

}
