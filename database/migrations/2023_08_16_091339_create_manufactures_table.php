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
        Schema::create('manufactures', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('name_bn')->nullable();
            $table->text('description')->nullable();
            $table->text('description_bn')->nullable();
            $table->string('photo')->nullable();
            $table->tinyInteger('status')->nullable()->comment('1=active, 0=inactive');
            $table->integer('serial')->default(0) ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manufactures');
    }
};
