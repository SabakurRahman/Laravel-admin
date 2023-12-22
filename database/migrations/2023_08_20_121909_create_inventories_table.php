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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('is_available_for_pre_order')->nullable()->comment('0 = not available, 1 = available');
            $table->tinyInteger('is_enable_call_for_price')->nullable()->comment('0 = not enabled, 1 = enabled');
            $table->tinyInteger('is_returnable')->nullable()->comment('0 = not returnable, 1 = returnable');
            $table->tinyInteger('disable_buy_button')->nullable()->comment('0 = not disable, 1 = disable');
            $table->tinyInteger('is_disable_wishlist_button')->nullable()->comment('0 = not disable, 1 = disable');
            // $table->unsignedBigInteger('product_id')->nullable(false);
            $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('variation_id')->nullable();
            $table->tinyInteger('inventory_method')->nullable()->comment('0 = Do not Track Inventory, 1 = Track Inventory');
            $table->timestamp('available_date')->nullable();
            $table->integer('max_cart_quantity')->nullable();
            $table->integer('min_cart_quantity')->nullable();
            $table->integer('stock')->nullable();
            $table->tinyInteger('low_stock_alert')->default(0)->nullable(false)->comment('0=Enable, 1=Disable');
            $table->timestamps();



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');


            // Schema::table('inventories', function (Blueprint $table) {
            // $table->dropForeign('inventories_product_id_foreign');
            // });
    }
};
