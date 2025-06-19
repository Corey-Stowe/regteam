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
        Schema::create('tft_register', function (Blueprint $table) {
            $table->id('register_id');
            $table->string('discord_id')->unique();
            $table->string('riotname_id')->unique();
            $table->string('join_type')->default('all');
            $table->string('fullname');
            $table->string('phonenumber');
            $table->date('DoB');
            $table->string('id_number')->nullable();
            $table->date('register_date')->default(now());
            $table->string('bank_account_number')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->boolean('tos_accepted')->default(false);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tft_register');
    }
};
