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
        Schema::create('estimate_prices', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('unit_price_id')->nullable();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->integer('max_size')->nullable();
            $table->integer('min_size')->nullable();
            $table->integer('price')->nullable();
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });
    } 

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimate_prices');
    }
};
