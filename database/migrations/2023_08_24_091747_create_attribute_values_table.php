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
        Schema::disableForeignKeyConstraints();
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('name_bn')->nullable();
            $table->integer('display_order')->default(1)->nullable();
            $table->tinyInteger('status')->default(1)->nullable()->comment('1=Active, 2=Pending');
            $table->foreignId('attribute_id')->constrained('attributes')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_values');
    }
};
