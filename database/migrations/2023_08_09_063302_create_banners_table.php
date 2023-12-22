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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title')->nullable();
            $table->string('photo')->nullable();
            $table->tinyInteger('type')->default(1)->comment('Const Banner = 1, Slider  = 2, Advertisement = 3');
            $table->string('serial')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1:Active, 0:Inactive');
            $table->foreignId('banner_size_id')->nullable()->constrained('banner_sizes');
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
