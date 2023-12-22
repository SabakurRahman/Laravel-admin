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
        Schema::create('our_projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('client_name')->nullable();
            $table->foreignId('project_category_id')->nullable()->constrained('project_categories')->onDelete('cascade');
            $table->string('project_location')->nullable();
            $table->text('project_description')->nullable();
            $table->integer('total_area')->nullable();
            $table->integer('total_cost')->nullable();
            $table->tinyInteger('status')->nullable()->comment('1=active, 0=inactive');
            $table->tinyInteger('type')->default(1)->nullable()->comment('1=Office Interior, 2=Home Interior');
            $table->tinyInteger('is_show_on_home_page')->default(2)->nullable()->comment('1=yes,2=no');
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('our_projects');
    }
};
