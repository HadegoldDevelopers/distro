<?php

namespace App\Services\PaymentGateways;

use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaypalService
{
  protected $clientId;
  protected $secret;
  protected $baseUrl;

  public function __construct()
  {
    $gateway = PaymentGateway::where('name', 'paypal')->firstOrFail();
    $settings = $gateway->settings??[];

    Log::info('PayPal settings loaded:', $settings);

    if (empty($settings['client_id']) || empty($settings['client_secret'])) {
      throw new \Exception('PayPal client ID and secret are not set in the payment gateway settings.');
    }

    $this->clientId = $settings['client_id'] ?? null;
    $this->secret = $settings['client_secret'] ?? null;
    // Use sandbox or live URL based on mode or settings
    // Use the model attribute 'mode' instead of inside settings array
    if (!empty($gateway->mode) && strtolower($gateway->mode) === 'live') {
      $this->baseUrl = 'https://api-m.paypal.com';  // Live URL
    } else {
      $this->baseUrl = $settings['sandbox'] ?? 'https://api-m.sandbox.paypal.com';  // Sandbox URL
    }
  }

  protected function getAccessToken()
  {
    $response = Http::withBasicAuth($this->clientId, $this->secret)
      ->asForm()
      ->post("{$this->baseUrl}/v1/oauth2/token", ['grant_type' => 'client_credentials']);

    if ($response->successful()) {
      return $response['access_token'];
    }
    throw new \Exception('Unable to get PayPal access token.');
  }

  public function initiatePayment($user, $amount, $currency, $plan)
  {
    $token = $this->getAccessToken();

    $callbackUrl = route('payment.callback', ['gateway' => 'paypal']);
    $cancelUrl = route('payment.cancel');

    $orderData = [
      'intent' => 'CAPTURE',
      'purchase_units' => [[
        'amount' => [
          'currency_code' => $currency,
          'value' => number_format($amount, 2, '.', ''),
        ],
        'description' => $plan->description,
        'custom_id' => $plan->id,
      ]],
      'application_context' => [
        'return_url' => $callbackUrl,
        'cancel_url' => $cancelUrl,
      ],
    ];

    $response = Http::withToken($token)
      ->post("{$this->baseUrl}/v2/checkout/orders", $orderData);

    if ($response->successful() && !empty($response['links'])) {
      foreach ($response['links'] as $link) {
        if ($link['rel'] === 'approve') {
          return $link['href'];
        }
      }
    }

    throw new \Exception('PayPal payment initialization failed.');
  }
}
