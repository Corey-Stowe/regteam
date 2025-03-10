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
        Schema::create('self_match_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('match_report', 'report_id')->cascadeOnDelete();
            $table->integer('self_discord_id')->unsigned();
            $table->integer('self_round');
            $table->integer('self_hero');
            $table->integer('self_kills');
            $table->integer('self_death');
            $table->integer('self_assist');
            $table->integer('self_score');
            $table->integer('self_toal_gold');
            $table->integer('self_is_mvp');
            $table->integer('self_is_winner');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('self__match_history');
    }
};
