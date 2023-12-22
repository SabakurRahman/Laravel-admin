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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('variation_id')->nullable();
            $table->string('name')->nullable();
            $table->string('sku')->nullable();
            $table->integer('quantity')->nullable();
            $table->float('cost')->nullable();
            $table->float('previous_unit_price')->nullable();
            $table->float('unit_price')->nullable();
            $table->float('discount_fixed')->nullable();
            $table->float('discount_percent')->nullable();
            $table->timestamp('discount_start')->nullable();
            $table->timestamp('discount_end')->nullable();
            $table->string('discount_text')->nullable();
            $table->float('total_amount')->nullable();
            $table->float('discount_amount')->nullable();
            $table->float('payable_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
