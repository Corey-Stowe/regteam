<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tft_data', function (Blueprint $table) {
            $table->id('data_id');
            $table->string('discord_id');
            $table->foreignId('calendar_id')
                ->constrained('tft_calendar', 'calendar_id')
                ->onDelete('cascade');
            $table->string('tft_rank')->nullable();
            $table->integer('tft_points')->default(0);
            $table->string('tft_division')->nullable();
            $table->string('api_placement')->nullable();
            $table->string('api_level')->nullable();
            $table->string('api_gold_left')->nullable();
            $table->string('api_last_round')->nullable();
            $table->string('api_total_damage')->nullable();
            $table->string('api_players_eliminated')->nullable();
            $table->string('api_game_length')->nullable();
            $table->string('api_game_datetime')->nullable();
            $table->json('api_traits')->nullable();
            $table->json('api_units')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tft_data');
    }
};
