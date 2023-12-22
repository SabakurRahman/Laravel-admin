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
        Schema::create('warrenties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->tinyInteger('warrenty_type')->nullable()->comment('1 = Expressed, 2 = Implied');
            $table->tinyInteger('warrenty_period')->nullable()->comment('1 = 3 month, 2 = 6 month ,3 =1 year');
            $table->string('warrenty_policy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warrenties');
    }
};
