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
        Schema::create('product_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('variation_id')->nullable(); 
            $table->string('photo')->nullable();
            $table->integer('serial')->nullable();
            $table->string('title')->nullable();
            $table->string('alt_text')->nullable();
            $table->unsignedBigInteger('product_id')->nullable(false);
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_photos');
    }
};
