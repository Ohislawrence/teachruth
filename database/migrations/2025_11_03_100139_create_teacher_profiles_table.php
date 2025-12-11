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
        Schema::create('teacher_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('phone')->nullable();
            $table->text('bio')->nullable();
            $table->string('qualification')->nullable();
            $table->integer('years_of_experience')->default(0);
            $table->string('specialization')->nullable();
            $table->string('state')->nullable();
            $table->string('lga')->nullable(); // Local Government Area
            $table->string('resume_path')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->boolean('is_public')->default(true);
            $table->json('qualifying_answers')->nullable(); // Store Q&A as JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_profiles');
    }
};
