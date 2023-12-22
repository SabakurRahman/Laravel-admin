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
        Schema::create('activity_logs', static function (Blueprint $table) {
            $table->id();
            $table->morphs('logable');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('note')->nullable();
            $table->string('ip')->nullable();
            $table->string('action')->nullable();
            $table->string('route')->nullable();
            $table->string('method')->nullable();
            $table->string('agent')->nullable();
            $table->text('old_data')->nullable();
            $table->text('new_data')->nullable();
            $table->string('attached_files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
