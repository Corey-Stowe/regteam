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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('team_name');
            $table->string('team_leader_name');
            $table->string('team_leader_email');
            $table->string('team_leader_phone');
            $table->string('team_leader_discord_uid');
            $table->string('tos_agreement');
            $table->string('team_status');
            $table->string('team_code')->unique();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team');
    }
};
