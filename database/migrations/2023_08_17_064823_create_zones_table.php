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
        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('name_bn')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1=Active, 0=Inactive');
            $table->tinyInteger('is_inside_dhaka')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};