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
        Schema::table('tft_register', function (Blueprint $table) {
          $table->boolean('is_in_calendar')->default(false)->after('tos_accepted');
          $table->boolean('is_excluded')->default(false)->after('is_in_calendar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tft_register', function (Blueprint $table) {
            //
        });
    }
};
