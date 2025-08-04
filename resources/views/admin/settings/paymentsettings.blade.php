@extends('layouts.admin')

@section('title', 'Payment Gateways Settings')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-zinc-900 rounded-lg shadow-md text-white">
    <h1 class="text-3xl font-bold mb-6">Payment Gateways Settings</h1>

    @include('partials.flash-messages')

    <form method="POST" action="{{ route('admin.settings.payment-gateways.update') }}">
        @csrf
        @method('PUT')

        @foreach($gateways as $gateway)
            <div class="mb-8 border-b border-zinc-700 pb-6">
                <h2 class="text-xl font-semibold mb-2">{{ $gateway->display_name }}</h2>

                <label class="inline-flex items-center space-x-2 mb-3">
                    <input type="checkbox" name="gateways[{{ $gateway->name }}][enabled]" value="1" {{ $gateway->enabled ? 'checked' : '' }} class="form-checkbox text-orange-600">
                    <span>Enabled</span>
                </label>

                <div class="mb-4">
                    <label for="mode_{{ $gateway->name }}" class="block mb-1">Mode</label>
                    <select name="gateways[{{ $gateway->name }}][mode]" id="mode_{{ $gateway->name }}" class="w-full rounded bg-zinc-800 p-2 text-white border border-zinc-700">
                        <option value="sandbox" {{ $gateway->mode === 'sandbox' ? 'selected' : '' }}>Sandbox</option>
                        <option value="live" {{ $gateway->mode === 'live' ? 'selected' : '' }}>Live</option>
                    </select>
                </div>

                @if($gateway->settings)
                    @foreach($gateway->settings as $key => $value)
                        <div class="mb-3">
                            <label for="{{ $gateway->name }}_{{ $key }}" class="block mb-1">{{ ucwords(str_replace('_', ' ', $key)) }}</label>
                            <input type="text" name="gateways[{{ $gateway->name }}][{{ $key }}]" id="{{ $gateway->name }}_{{ $key }}" value="{{ old("gateways.{$gateway->name}.{$key}", $value) }}" class="w-full rounded bg-zinc-800 p-2 text-white border border-zinc-700">
                        </div>
                    @endforeach
                @else
                    {{-- Provide empty fields for typical keys for common gateways --}}
                    @if($gateway->name === 'paystack')
                        <div class="mb-3">
                            <label for="paystack_public_key" class="block mb-1">Public Key</label>
                            <input type="text" name="gateways[paystack][public_key]" id="paystack_public_key" value="{{ old('gateways.paystack.public_key') }}" class="w-full rounded bg-zinc-800 p-2 text-white border border-zinc-700">
                        </div>
                        <div class="mb-3">
                            <label for="paystack_secret_key" class="block mb-1">Secret Key</label>
                            <input type="text" name="gateways[paystack][secret_key]" id="paystack_secret_key" value="{{ old('gateways.paystack.secret_key') }}" class="w-full rounded bg-zinc-800 p-2 text-white border border-zinc-700">
                        </div>
                    @elseif($gateway->name === 'paypal')
                        <div class="mb-3">
                            <label for="paypal_client_id" class="block mb-1">Client ID</label>
                            <input type="text" name="gateways[paypal][client_id]" id="paypal_client_id" value="{{ old('gateways.paypal.client_id') }}" class="w-full rounded bg-zinc-800 p-2 text-white border border-zinc-700">
                        </div>
                        <div class="mb-3">
                            <label for="paypal_client_secret" class="block mb-1">Client Secret</label>
                            <input type="text" name="gateways[paypal][client_secret]" id="paypal_client_secret" value="{{ old('gateways.paypal.client_secret') }}" class="w-full rounded bg-zinc-800 p-2 text-white border border-zinc-700">
                        </div>
                      @elseif($gateway->name === 'nowpayment')
        <div class="mb-3">
            <label for="nowpayment_api_key" class="block mb-1">API Key</label>
            <input type="text" name="gateways[nowpayment][api_key]" id="nowpayment_api_key" value="{{ old('gateways.nowpayment.api_key') }}" class="w-full rounded bg-zinc-800 p-2 text-white border border-zinc-700">
        </div>
                    @elseif($gateway->name === 'coinpayments')
                        <div class="mb-3">
                            <label for="coinpayments_public_key" class="block mb-1">Public Key</label>
                            <input type="text" name="gateways[coinpayments][public_key]" id="coinpayments_public_key" value="{{ old('gateways.coinpayments.public_key') }}" class="w-full rounded bg-zinc-800 p-2 text-white border border-zinc-700">
                        </div>
                        <div class="mb-3">
                            <label for="coinpayments_private_key" class="block mb-1">Private Key</label>
                            <input type="text" name="gateways[coinpayments][private_key]" id="coinpayments_private_key" value="{{ old('gateways.coinpayments.private_key') }}" class="w-full rounded bg-zinc-800 p-2 text-white border border-zinc-700">
                        </div>
                        <div class="mb-3">
                          <label for="coinpayments_merchant_id" class="block mb-1">Merchant ID</label>
                          <input type="text" name="gateways[coinpayments][merchant_id]" id="coinpayments_merchant_id" value="{{ old('gateways.coinpayments.merchant_id') }}" class="w-full rounded bg-zinc-800 p-2 text-white border border-zinc-700">
                        </div>
  
                    @endif
                @endif
            </div>
        @endforeach

        <button type="submit" class="bg-orange-600 hover:bg-orange-700 px-6 py-3 rounded font-semibold shadow">
            Save Settings
        </button>
    </form>
</div>
@endsection
