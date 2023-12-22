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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->morphs('addressable');
            $table->integer('phone')->nullable();
            $table->unsignedBigInteger('division_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('zone_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('address_type')->nullable()->comment('1= Billing address, 2= Shipping Address, 3= Office Address');
            $table->boolean('is_default')->nullable()->comment('1=Yes,0=No');
            $table->string('street_address')->nullable();
            $table->string('street_address_bn')->nullable();
            $table->string('landmark')->nullable();
            $table->string('zip_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
