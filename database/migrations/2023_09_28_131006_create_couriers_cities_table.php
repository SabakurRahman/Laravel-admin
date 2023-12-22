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
        Schema::create('couriers_cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courier_id')->constrained('couriers')->cascadeOnUpdate()->cascadeOnUpdate();
            $table->foreignId('city_id')->constrained('cities')->cascadeOnUpdate()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('couriers_cities');
    }
};
