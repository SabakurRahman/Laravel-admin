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
        Schema::create('project_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('photo')->nullable();
            $table->string('title')->nullable();
            $table->integer('serial')->nullable();
            $table->tinyInteger('is_primary')->nullable()->comment('1=primary, 0=not primary');
            $table->foreignId('our_project_id')->constrained('our_projects')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_photos');
    }
};
