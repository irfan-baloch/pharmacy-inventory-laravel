<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // SHOW settings form
    public function index()
    {
        $settings = [
            'pharmacy_name' => Setting::getValue('pharmacy_name', 'PharmaStock'),
            'pharmacy_address' => Setting::getValue('pharmacy_address', ''),
            'pharmacy_phone' => Setting::getValue('pharmacy_phone', ''),
            'pharmacy_email' => Setting::getValue('pharmacy_email', ''),
            'currency' => Setting::getValue('currency', 'Rs.'),
            'low_stock_alert_days' => Setting::getValue('low_stock_alert_days', '30'),
        ];

        return view('settings.index', compact('settings'));
    }

    // UPDATE settings
    public function update(Request $request)
    {
        $request->validate([
            'pharmacy_name' => 'required|string|max:255',
            'pharmacy_address' => 'nullable|string',
            'pharmacy_phone' => 'nullable|string|max:20',
            'pharmacy_email' => 'nullable|email|max:255',
            'currency' => 'required|string|max:10',
            'low_stock_alert_days' => 'required|integer|min:1|max:365',
        ]);

        Setting::setValue('pharmacy_name', $request->pharmacy_name);
        Setting::setValue('pharmacy_address', $request->pharmacy_address);
        Setting::setValue('pharmacy_phone', $request->pharmacy_phone);
        Setting::setValue('pharmacy_email', $request->pharmacy_email);
        Setting::setValue('currency', $request->currency);
        Setting::setValue('low_stock_alert_days', $request->low_stock_alert_days);

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully!');
    }
}