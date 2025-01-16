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
        Schema::create('team_fight_calendar', function (Blueprint $table) {
            $table->id();
            $table->string('team_id_self');
            $table->string('team_id_opponent');
            $table->string('team_id_winner');
            $table->string('team_id_loser');
            $table->date('team_fight_date');
            $table->string('team_fight_status');
            $table->string('team_fight_note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_fight_calendar');
    }
};
