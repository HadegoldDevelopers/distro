<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
  protected $apiUrl = 'https://open.er-api.com/v6/latest/'; // free exchange rate API base URL

  /**
   * Convert amount from one currency to another.
   *
   * @param float $amount
   * @param string $fromCurrency  (e.g. 'USD')
   * @param string $toCurrency    (e.g. 'NGN')
   * @return float|null           Converted amount or null on failure
   */
  public function convert(float $amount, string $fromCurrency, string $toCurrency): ?float
  {
    $response = Http::get($this->apiUrl . strtoupper($fromCurrency));

    if ($response->successful()) {
      $rates = $response->json('rates');

      if (isset($rates[$toCurrency])) {
        $rate = $rates[$toCurrency];
        return $amount * $rate;
      }
    }

    return null;
  }
}
