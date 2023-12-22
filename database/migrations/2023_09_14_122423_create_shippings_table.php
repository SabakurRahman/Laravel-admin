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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('package_weight')->nullable();
            $table->integer('height')->nullable();
            $table->integer('width')->nullable();
            $table->integer('length')->nullable();
            $table->tinyInteger('product_type')->nullable()->comment('1 = Residential Interior, 2 = commercial Interior, 3=Furniture, 4=Custom Lights');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
