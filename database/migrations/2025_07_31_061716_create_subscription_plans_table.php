<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');               // Plan name (e.g., "Artist Pro")
            $table->string('role');               // User role this plan applies to (e.g., "artist", "label")
            $table->decimal('price', 8, 2);      // Price of the plan
            $table->string('currency', 3)->default('USD'); // 3-letter ISO code like USD, EUR
            $table->string('billing_cycle');     // e.g., monthly, yearly
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
