<?php

namespace App\Services\PaymentGateways;

use App\Models\PaymentGateway;
use App\Services\CurrencyConverter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackService
{
  protected $secretKey;

  public function __construct()
  {
    $gateway = PaymentGateway::where('name', 'paystack')->firstOrFail();
    $settings = $gateway->settings ?? [];

    if (empty($settings['secret_key'])) {
      throw new \Exception('Paystack secret key is not set in the payment gateway settings.');
    }

    $this->secretKey = $settings['secret_key'];
  }

  public function initiatePayment($user, $amount, $currency, $plan)
  {
    $converter = new CurrencyConverter();

    if (strtoupper($currency) !== 'NGN') {
      $convertedAmount = $converter->convert($amount, $currency, 'NGN');
      if ($convertedAmount === null) {
        throw new \Exception("Currency conversion failed.");
      }
    } else {
      $convertedAmount = $amount;
    }

    $amountInKobo = intval($convertedAmount * 100);
    $callbackUrl = route('payment.callback', ['gateway' => 'paystack']);

    $response = Http::withToken($this->secretKey)
      ->post('https://api.paystack.co/transaction/initialize', [
        'email' => $user->email,
        'amount' => $amountInKobo,
        'currency' => 'NGN',
        'callback_url' => $callbackUrl,
        'metadata' => [
          'plan_id' => $plan->id,
          'user_id' => $user->id,
        ],
      ]);

    Log::info('Paystack response', [
      'status' => $response->status(),
      'body' => $response->body(),
    ]);

    $data = $response->json();

    if ($response->successful() && isset($data['data']['authorization_url'])) {
      return $data['data']['authorization_url'];
    }

    throw new \Exception('Paystack payment initialization failed: ' . ($data['message'] ?? 'Unknown error'));
  }

  public function verifyTransaction(string $reference): array
  {
    $response = Http::withToken($this->secretKey)
      ->get("https://api.paystack.co/transaction/verify/{$reference}");

    if (!$response->successful()) {
      Log::error('Paystack verification failed', [
        'reference' => $reference,
        'response' => $response->body(),
      ]);
      throw new \Exception('Failed to verify Paystack transaction.');
    }

    $data = $response->json();

    if (($data['data']['status'] ?? null) !== 'success') {
      Log::warning('Paystack transaction not successful', [
        'reference' => $reference,
        'status' => $data['data']['status'] ?? 'undefined',
      ]);
      throw new \Exception('Transaction not successful.');
    }

    return $data['data']; // Full transaction info here
  }
}
