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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title')->nullable();
            $table->string('title_bn')->nullable();
            $table->string('slug')->nullable();
            $table->string('slug_bn')->nullable();
            $table->string('sku')->nullable();
            $table->string('model')->nullable();
            $table->tinyInteger('product_type')->default(1)->nullable()->comment('1=simple, 2=grouped with variant');
            $table->tinyInteger('is_published')->default(1)->nullable()->comment('1=pending,2=published,3=not published');
            $table->tinyInteger('is_show_on_home_page')->default(2)->nullable()->comment('1=yes,2=no');
            $table->tinyInteger('is_allow_review')->default(1)->nullable()->comment('1=allowed,2=not allowed');
            $table->tinyInteger('is_new')->default(1)->nullable()->comment('1=new,2=not new');
            $table->tinyInteger('is_prime')->default(1)->nullable()->comment('1=prime,2=not prime');
            $table->integer('sort_order')->nullable();
            $table->text('description')->nullable();
            $table->text('description_bn')->nullable();
            $table->text('short_description')->nullable();
            $table->text('short_description_bn')->nullable();
            $table->text('comment')->nullable();
            $table->unsignedBigInteger('country_id')->nullable()->comment('product origin');
            $table->unsignedBigInteger('manufacturer_id')->nullable();
            // $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('updated_by_id')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->tinyInteger('is_saved')->nullable()->comment('1 = saved, 2 = draft');
            $table->integer('sold')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
