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
        Schema::create('opponent_match_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('match_report', 'report_id')->cascadeOnDelete();
            $table->integer('opponent_discord_id')->unsigned();
            $table->integer('opponent_round');
            $table->string('opponent_hero');
            $table->integer('opponent_kills');
            $table->integer('opponent_death');
            $table->integer('opponent_assist');
            $table->integer('opponent_score');
            $table->integer('opponent_total_gold');
            $table->integer('opponent_is_mvp');
            $table->integer('opponent_is_winner');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opponent_match_history');
    }
};
