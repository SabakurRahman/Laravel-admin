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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->morphs('faqable');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('question_title')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->nullable()->comment('1 = Active, 0 = Inactive');
            // $table->foreignId('faq_page_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
