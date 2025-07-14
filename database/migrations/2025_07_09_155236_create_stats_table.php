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
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->year('year');                     // e.g. 2025
            $table->unsignedTinyInteger('month');     // e.g. 1–12

            $table->foreignId('music_id')->constrained('music')->onDelete('cascade');
            
            $table->string('store');       // e.g. Spotify, Apple Music
            $table->string('country', 2);  // ISO country code like 'NG', 'US'
            $table->string('quality');     // e.g. 128kbps, 320kbps, FLAC

            $table->unsignedBigInteger('streams')->default(0); // number of streams

            $table->timestamps();

            // Prevent duplicate entries for the same stat combo
            $table->unique(['year', 'month', 'music_id', 'store', 'country', 'quality'], 'unique_stream_stat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};
