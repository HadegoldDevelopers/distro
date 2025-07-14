<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PaymentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('user.payment', [
            'user' => $user,
            'paymentMethods' => [
                'paypal' => 'PayPal',
                'stripe' => 'Stripe',
                'bank_transfer' => 'Bank Transfer',
                
            ],
        ]);
    }

    public function process(Request $request)
    {
        // Handle logic for selected payment method (e.g., redirect to gateway)
        return back()->with('success', 'Payment initiated successfully.');
    }
    public function saveWithdrawal(Request $request)
    {
        $request->validate([
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:30',
            'account_name' => 'nullable|string|max:255',
            'paypal_email' => 'nullable|email|max:255',
            'crypto_wallet' => 'nullable|string|max:255',
            'crypto_type' => 'nullable|string|max:50',
        ]);
        $user = User::find(Auth::id());

        $user->bank_name = $request->bank_name;
        $user->account_number = $request->account_number;
        $user->account_name = $request->account_name;
        $user->paypal_email = $request->paypal_email;
        $user->crypto_wallet = $request->crypto_wallet;
        $user->crypto_type = $request->crypto_type;
        $user->save();
        $user->save();

        return back()->with('success', 'Withdrawal information updated successfully!');
    }
}
