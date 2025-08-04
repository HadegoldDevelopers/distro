<?php

namespace App\Services\PaymentGateways;

use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Http;

class NowpaymentService
{
  protected $apiKey;

  public function __construct()
  {
    $gateway = PaymentGateway::where('name', 'nowpayment')->firstOrFail();

    /** @var array $settings */
    $settings = is_array($gateway->settings) ? $gateway->settings : [];


    if (empty($settings['api_key'])) {
      throw new \Exception('API key for NowPayment is not set.');
    }

    $this->apiKey = $settings['api_key'];
  }

  public function initiatePayment($user, $amount, $currency, $plan)
  {
    $callbackUrl = route('payment.callback', ['gateway' => 'nowpayment']);

    $response = Http::withHeaders([
      'x-api-key' => $this->apiKey,
    ])->post('https://api.nowpayments.io/v1/invoice', [
      'price_amount' => $amount,
      'price_currency' => $currency,
      'pay_currency' => 'btc', // Optional, customize as needed
      'ipn_callback_url' => $callbackUrl,
      'order_id' => 'plan_' . $plan->id,
      'order_description' => $plan->description ?? 'Subscription Payment',
      // 'buyer_email' => $user->email,
    ]);

    if ($response->successful() && isset($response['invoice_url'])) {
      return $response['invoice_url'];
    }

    logger()->error('NowPayments error', [
      'status' => $response->status(),
      'body' => $response->body(),
    ]);

    throw new \Exception('NowPayment payment initialization failed.');
  }
}
