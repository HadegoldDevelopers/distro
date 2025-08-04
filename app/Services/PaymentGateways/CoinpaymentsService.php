<?php

namespace App\Services\PaymentGateways;

use App\Models\PaymentGateway;

class CoinpaymentsService
{
  protected string $publicKey;
  protected string $privateKey;
  protected string $merchantId;
  protected string $apiUrl = 'https://www.coinpayments.net/api.php';

  public function __construct()
  {
    $gateway = PaymentGateway::where('name', 'coinpayments')->firstOrFail();
    $settings = $gateway->settings ?? [];

    $this->publicKey = $settings['public_key'] ?? throw new \Exception('CoinPayments public key missing.');
    $this->privateKey = $settings['private_key'] ?? throw new \Exception('CoinPayments private key missing.');
    $this->merchantId = $settings['merchant_id'] ?? throw new \Exception('CoinPayments merchant ID missing.');
  }

  /**
   * Send signed API request to CoinPayments.
   *
   * @param array $params Request parameters
   * @return array API response result
   * @throws \Exception on failure
   */
  protected function apiRequest(array $params): array
  {
    $params['version'] = 1;
    $params['key'] = $this->publicKey;
    $params['format'] = 'json';

    $postData = http_build_query($params, '', '&');

    $hmac = hash_hmac('sha512', $postData, $this->privateKey);

    $ch = curl_init($this->apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'HMAC: ' . $hmac,
      'Content-Type: application/x-www-form-urlencoded',
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);

    $response = curl_exec($ch);

    if ($response === false) {
      $error = curl_error($ch);
      curl_close($ch);
      throw new \Exception('CoinPayments cURL error: ' . $error);
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
      throw new \Exception('CoinPayments returned invalid JSON: ' . json_last_error_msg());
    }

    if (!isset($data['error']) || $data['error'] !== 'ok') {
      $errorMessage = $data['error'] ?? 'Unknown error from CoinPayments API.';
      throw new \Exception('CoinPayments API error: ' . $errorMessage);
    }

    return $data['result'];
  }

  /**
   * Initiate a payment transaction.
   *
   * @param \App\Models\User $user
   * @param float $amount
   * @param string $currency ISO code, e.g., USD
   * @param object $plan
   * @return array Transaction details from CoinPayments
   * @throws \Exception
   */
  public function initiatePayment($user, float $amount, string $currency, $plan): array
  {
    $params = [
      'cmd' => 'create_transaction',
      'amount' => $amount,
      'currency1' => strtoupper($currency),   // User's payment currency
      'currency2' => 'BTC',                    // Your receive currency, change if needed
      'buyer_email' => $user->email,
      'item_name' => $plan->name ?? 'Subscription Plan',
      'ipn_url' => route('payment.callback', ['gateway' => 'coinpayments']),
      'custom' => json_encode([
        'user_id' => $user->id,
        'plan_id' => $plan->id,
      ]),
    ];

    return $this->apiRequest($params);
  }
}
