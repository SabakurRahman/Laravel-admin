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
        Schema::create('unit_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('estimate_category_id')->nullable();
            $table->unsignedBigInteger('estimate_sub_category_id')->nullable();
            // $table->unsignedBigInteger('unit_id')->nullable();
            $table->tinyInteger('type')->nullable()->comment('1=office_interior, 0=home_interior');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_prices');
    }
};
