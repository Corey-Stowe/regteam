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
        Schema::create('tft_calendar', function (Blueprint $table) {
            $table->id('calendar_id');
            $table->string('event_name');
            $table->dateTime('event_date');
            $table->string('event_location')->nullable();
            $table->text('event_description')->nullable();
            $table->boolean('is_cancelled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tft_calendar');
    }
};
