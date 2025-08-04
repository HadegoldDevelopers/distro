<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    // Show form
    public function edit()
    {
        $gateways = PaymentGateway::all();
        return view('admin.settings.paymentsettings', compact('gateways'));
    }

    // Update settings
    public function update(Request $request)
    {
        $input = $request->input('gateways', []);

        foreach ($input as $name => $data) {
            $gateway = PaymentGateway::where('name', $name)->first();
            if (!$gateway) continue;

            $gateway->enabled = isset($data['enabled']);
            $gateway->mode = $data['mode'] ?? 'sandbox';

            // Remove enabled & mode from settings
            $settings = collect($data)->except(['enabled', 'mode'])->toArray();

            // Optional: Encrypt sensitive data here before save

            $gateway->settings = $settings;

            $gateway->save();
        }

        return redirect()->back()->with('success', 'Payment gateways updated successfully.');
    }
}
