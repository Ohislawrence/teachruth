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
        Schema::create('qualifying_questions', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->enum('type', ['multiple_choice', 'text', 'boolean']);
            $table->json('options')->nullable(); // For multiple choice questions
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qualifying_questions');
    }
};
