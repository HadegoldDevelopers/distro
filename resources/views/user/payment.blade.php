@extends('layouts.user')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-6 grid md:grid-cols-2 gap-8">
  {{-- Deposit Section --}}
  <div>
    <h2 class="text-2xl font-bold text-white mb-6">Choose Your Payment Method</h2>

    <form method="POST" action="{{ route('payment.process') }}" class="space-y-6">
      @csrf

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <label class="flex items-center p-4 bg-zinc-800 rounded cursor-pointer hover:bg-zinc-700">
          <input type="radio" name="payment_method" value="paystack" class="mr-4">
          <img src="https://upload.wikimedia.org/wikipedia/commons/6/61/Paystack_Logo.png" class="w-24" />
        </label>

        <label class="flex items-center p-4 bg-zinc-800 rounded cursor-pointer hover:bg-zinc-700">
          <input type="radio" name="payment_method" value="flutterwave" class="mr-4">
          <img src="https://flutterwave.com/images/logo-colored.svg" class="w-24" />
        </label>

        <label class="flex items-center p-4 bg-zinc-800 rounded cursor-pointer hover:bg-zinc-700">
          <input type="radio" name="payment_method" value="stripe" class="mr-4">
          <img src="https://upload.wikimedia.org/wikipedia/commons/4/4e/Stripe_Logo%2C_revised_2016.svg" class="w-24" />
        </label>

        <label class="flex items-center p-4 bg-zinc-800 rounded cursor-pointer hover:bg-zinc-700">
          <input type="radio" name="payment_method" value="paypal" class="mr-4">
          <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" class="w-24" />
        </label>

        <label class="flex items-center p-4 bg-zinc-800 rounded cursor-pointer hover:bg-zinc-700 col-span-2">
          <input type="radio" name="payment_method" value="bank" class="mr-4">
          <span class="text-white font-semibold">Bank Transfer (Manual)</span>
        </label>
      </div>

      <button type="submit"
        class="bg-orange-600 hover:bg-orange-700 text-white py-3 px-6 rounded font-semibold transition">
        Continue to Payment
      </button>
    </form>
  </div>

  {{-- Withdrawal Section --}}
  <div x-data="{ method: 'bank' }">
    <h2 class="text-2xl font-bold text-white mb-6">Withdrawal Information</h2>

    <div class="flex space-x-3 mb-4">
      <button @click="method = 'bank'" :class="method === 'bank' ? 'bg-orange-600' : 'bg-zinc-700'" class="px-4 py-2 rounded text-white text-sm font-medium">Bank</button>
      <button @click="method = 'paypal'" :class="method === 'paypal' ? 'bg-orange-600' : 'bg-zinc-700'" class="px-4 py-2 rounded text-white text-sm font-medium">PayPal</button>
      <button @click="method = 'crypto'" :class="method === 'crypto' ? 'bg-orange-600' : 'bg-zinc-700'" class="px-4 py-2 rounded text-white text-sm font-medium">Crypto</button>
    </div>

    <form method="POST" action="{{ route('withdrawal.save') }}" class="space-y-5">
      @csrf

      {{-- Bank --}}
      <div x-show="method === 'bank'" class="space-y-4">
        <input type="text" name="bank_name" placeholder="Bank Name" value="{{ old('bank_name', Auth::user()->bank_name) }}"
          class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 text-white rounded" required>
        <input type="text" name="account_number" placeholder="Account Number" value="{{ old('account_number', Auth::user()->account_number) }}"
          class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 text-white rounded" required>
        <input type="text" name="account_name" placeholder="Account Name" value="{{ old('account_name', Auth::user()->account_name) }}"
          class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 text-white rounded" required>
      </div>

      {{-- PayPal --}}
      <div x-show="method === 'paypal'" class="space-y-4" x-cloak>
        <input type="email" name="paypal_email" placeholder="PayPal Email" value="{{ old('paypal_email', Auth::user()->paypal_email) }}"
          class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 text-white rounded">
      </div>

      {{-- Crypto --}}
      <div x-show="method === 'crypto'" class="space-y-4" x-cloak>
        <!-- Wallet Address Input -->
        <input 
            type="text" 
            name="crypto_wallet" 
            placeholder="Wallet Address" 
            value="{{ old('crypto_wallet', Auth::user()->crypto_wallet) }}" 
            required
            class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 text-white rounded"
        >
    
        <!-- Crypto Type Dropdown -->
        <select 
            name="crypto_type" 
            id="crypto_type" 
            required
            class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 text-white rounded"
        >
            <option disabled {{ old('crypto_type', $user->crypto_type) ? '' : 'selected' }}>Select Crypto Type</option>
            <option value="btc" @if(old('crypto_type', $user->crypto_type) == 'btc') selected @endif>Bitcoin (BTC)</option>
            <option value="eth" @if(old('crypto_type', $user->crypto_type) == 'eth') selected @endif>Ethereum (ETH)</option>
            <option value="usdt" @if(old('crypto_type', $user->crypto_type) == 'usdt') selected @endif>USDT</option>
        </select>
    </div>
    <button type="submit"
        class="bg-green-600 hover:bg-green-700 text-white py-2 px-6 rounded font-medium transition">
        Save Payment Info
      </button>
      </div>

      
    </form>
  </div>
</div>
@endsection
