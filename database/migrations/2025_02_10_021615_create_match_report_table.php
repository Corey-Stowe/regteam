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
        Schema::create('match_report', function (Blueprint $table) {
            $table->id('report_id')->unsigned();
            $table->foreignId('match_id')->constrained('team_fight_calendar')->cascadeOnDelete();
            $table->integer('team_win')->unsigned();
            $table->string('video_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_report');
    }
};
