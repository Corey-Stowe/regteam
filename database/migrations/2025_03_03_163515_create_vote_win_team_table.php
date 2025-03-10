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
        Schema::create('vote_win_team', function (Blueprint $table) {
            $table->id();
            $table->string('discord_id')->unique();
            $table->integer('team_pepapig');
            $table->integer('team_vuon_hoa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vote_win_team');
    }
};
