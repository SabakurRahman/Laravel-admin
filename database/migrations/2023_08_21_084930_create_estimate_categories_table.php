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
        Schema::create('estimate_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->tinyInteger('type')->nullable()->comment('1=Office_Interior, 2=Home_Interior');
            $table->integer('serial')->nullable();
            $table->tinyInteger('status')->nullable()->comment('1=Active, 2=Inactive');
            $table->string('banner')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_estimate_categories');
    }
};
