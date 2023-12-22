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
        Schema::create('visitor_information', static function (Blueprint $table) {
            $table->id();
            $table->string('agent')->nullable();
            $table->string('ip')->nullable();
            $table->integer('session')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('zip')->nullable();
            $table->string('long')->nullable();
            $table->string('lat')->nullable();
            $table->string('long_react')->nullable();
            $table->string('lat_react')->nullable();
            $table->string('region')->nullable();
            $table->string('timeZone')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->string('device')->nullable();
            $table->string('device_type')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_information');
    }
};
