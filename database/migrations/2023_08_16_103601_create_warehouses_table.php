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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name')->nullable();
            $table->text('admin_comment')->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('street_address')->nullable();
            $table->tinyInteger('status')->nullable()->comment('1=active, 0=inactive');
            $table->bigInteger('country_id')->nullable() ;
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
