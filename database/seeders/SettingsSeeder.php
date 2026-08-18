<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'pharmacy_name' => 'Ali Medical Store',
            'pharmacy_address' => 'Main Bazaar, Karachi, Pakistan',
            'pharmacy_phone' => '0300-1234567',
            'pharmacy_email' => 'info@alimedical.com',
            'currency' => 'Rs.',
            'low_stock_alert_days' => '30',
        ];

        foreach ($defaults as $key => $value) {
            Setting::setValue($key, $value);
        }
    }
}