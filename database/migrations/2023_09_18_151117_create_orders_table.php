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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('total_quantity')->nullable();
            $table->float('total_amount')->nullable();
            $table->float('total_discount_amount')->nullable();
            $table->float('total_payable_amount')->nullable();
            $table->tinyInteger('payment_status')->nullable();
            $table->tinyInteger('shipping_status')->nullable();
            $table->tinyInteger('order_status')->nullable();
            $table->string('comment')->nullable();
            $table->string('user_ip')->nullable();
            $table->float('shipping_charge')->nullable();
            $table->unsignedBigInteger('shipping_address_id')->nullable();
            $table->unsignedBigInteger('billing_address_id')->nullable();
            $table->tinyInteger('order_from')->nullable()->comment('1 = customer, 2 = admin');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('courier_id')->nullable();
            $table->timestamp('order_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
