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
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('product_id')->nullable(false); 
            $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('variation_id')->nullable(); 
            $table->string('discount_info')->nullable();
            $table->double('price', 8, 2)->nullable();
            $table->double('old_price', 8, 2)->nullable();
            $table->double('cost', 8, 2)->nullable();
            $table->double('discount_fixed', 8, 2)->nullable();
            $table->double('discount_percent', 8, 2)->nullable();
            $table->timestamp('discount_start')->nullable();
            $table->timestamp('discount_end')->nullable();
            $table->tinyInteger('discount_type')->nullable()->comment('0 = manual, 1 = automatic,2 = none');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_prices');
    }
};
