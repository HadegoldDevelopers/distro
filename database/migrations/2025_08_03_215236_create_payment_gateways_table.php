<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentGatewaysTable extends Migration
{
    public function up()
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();        // internal name, e.g. 'paystack'
            $table->string('display_name');          // friendly name, e.g. 'Paystack'
            $table->boolean('enabled')->default(false);
            $table->string('mode')->default('sandbox'); // 'sandbox' or 'live'
            $table->json('settings')->nullable();    // JSON for API keys etc
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_gateways');
    }
}
