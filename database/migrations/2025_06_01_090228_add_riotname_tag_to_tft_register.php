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
            $table->string('riotname_tag')->nullable()->after('riotname_id');
            $table->string('puuid')->nullable()->after('riotname_tag');
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
