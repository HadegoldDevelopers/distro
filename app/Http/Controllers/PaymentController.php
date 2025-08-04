<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\PaymentGateway;
use App\Services\PaymentGateways\PaystackService;

use App\Models\SubscriptionPlan;


class PaymentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $paymentGateways = PaymentGateway::where('enabled', true)->get();
        $paymentMethods = $paymentGateways->mapWithKeys(function ($gateway) {
            return [$gateway->name => $gateway->display_name];
        })->toArray();

        // Get current subscription plan based on user role
        $currentPlan = SubscriptionPlan::where('role', $user->role)->first();

        // Allow upgrade from artist to label only
        $upgradePlan = null;
        if ($user->role === 'artist') {
            $upgradePlan = SubscriptionPlan::where('role', 'label')->first();
        }

        return view('user.payment', [
            'user' => $user,
            'paymentMethods' => $paymentMethods,
            'currentPlan' => $currentPlan,
            'upgradePlan' => $upgradePlan,
        ]);
    }
    public function show()
    {
        $user = Auth::user();

        $paymentGateways = PaymentGateway::where('enabled', true)->get();

        $paymentMethods = $paymentGateways->mapWithKeys(function ($gateway) {
            return [$gateway->name => $gateway->display_name];
        })->toArray();

        $currentPlan = SubscriptionPlan::where('role', $user->role)->first();

        $upgradePlan = null;
        if ($user->role === 'artist') {
            $upgradePlan = SubscriptionPlan::where('role', 'label')->first();
        }

        return view('user.payment', compact('user', 'paymentMethods', 'currentPlan', 'upgradePlan'));
    }
    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string|exists:payment_gateways,name,enabled,1',
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $user = Auth::user();
        $plan = SubscriptionPlan::findOrFail($request->subscription_plan_id);
        $paymentMethod = $request->payment_method;

        if ($paymentMethod === 'manual') {
            // Show manual payment instructions page or process manual payment request
            return redirect()->route('subscription.manual.instructions')
                ->with('success', 'Manual payment initiated. Follow instructions to complete.');
        }

        $serviceClass = "App\\Services\\PaymentGateways\\" . ucfirst($paymentMethod) . "Service";

        if (!class_exists($serviceClass)) {
            return back()->withErrors(['payment_method' => 'Unsupported payment method.']);
        }

        $service = app($serviceClass);

        try {
            $paymentUrl = $service->initiatePayment($user, $plan->price, $plan->currency ?? 'USD', $plan);
        } catch (\Exception $e) {
            return back()->withErrors(['payment_method' => $e->getMessage()]);
        }

        return redirect($paymentUrl)->with('success', 'Redirecting to payment gateway...');
    }
    public function handleCallback(Request $request, string $gateway, PaystackService $paystackService)
    {
        switch ($gateway) {
            case 'paystack':
                $reference = $request->input('reference') ?? $request->input('trxref');

                Log::info('Paystack callback received reference', ['reference' => $reference]);

                if (!$reference) {
                    return response()->json(['error' => 'No reference provided'], 400);
                }

                try {
                    $transaction = $paystackService->verifyTransaction($reference);

                    // Process metadata if present
                    $metadata = $transaction['metadata'] ?? [];

                    // Your custom logic here: update user/plan/payment
                    Log::info('Paystack payment verified via callback', $transaction);

                    return response()->json(['message' => 'Payment confirmed']);
                } catch (\Exception $e) {
                    Log::error('Paystack callback error', ['message' => $e->getMessage()]);
                    return response()->json(['error' => 'Payment verification failed.'], 500);
                }

            case 'paypal':
                // TODO: Add PayPal handling logic
                break;

            case 'nowpayment':
                logger()->info('NowPayments callback received', $request->all());

                $orderId = $request->input('order_id');
                $status = $request->input('payment_status');

                if ($status === 'confirmed') {
                    // Mark order as paid in your DB
                    // E.g., update user subscription, activate plan, etc.
                }

                return response()->json(['message' => 'OK']);
        }

        return response()->json(['error' => 'Unsupported payment gateway'], 400);
    }

    public function cancel()
    {
        return redirect()->route('payment.index')->with('error', 'Payment was cancelled.');
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

        $user = Auth::user();

        $user->bank_name = $request->bank_name;
        $user->account_number = $request->account_number;
        $user->account_name = $request->account_name;
        $user->paypal_email = $request->paypal_email;
        $user->crypto_wallet = $request->crypto_wallet;
        $user->crypto_type = $request->crypto_type;
        $user->save();

        return back()->with('success', 'Withdrawal information updated successfully!');
    }

    public function upgrade(Request $request)
    {
        $request->validate([
            'new_plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $user = Auth::user();
        $newPlan = SubscriptionPlan::findOrFail($request->new_plan_id);

        if ($user->role === 'artist' && $newPlan->role === 'label') {
            $user->role = 'label';
            $user->save();

            return redirect()->route('user.payment')->with('success', 'You have successfully upgraded to the Label plan!');
        }

        return redirect()->route('user.payment')->with('error', 'Upgrade not allowed.');
    }
}
