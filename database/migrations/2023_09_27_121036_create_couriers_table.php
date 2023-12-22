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
        Schema::create('couriers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('inside_courier_charge')->nullable();
            $table->string('outside_courier_charge')->nullable();
            $table->string('inside_condition_charge')->nullable();
            $table->string('outside_condition_charge')->nullable();
            $table->string('inside_return_charge')->nullable();
            $table->string('outside_return_charge')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('couriers');
    }
};
