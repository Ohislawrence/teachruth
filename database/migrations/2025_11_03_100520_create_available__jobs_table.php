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
        Schema::create('available__jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->enum('subject', [
                'mathematics', 'english', 'science', 'social_studies',
                'physics', 'chemistry', 'biology', 'history',
                'geography', 'computer_science', 'physical_education',
                'arts', 'music', 'french', 'yoruba', 'igbo', 'hausa', 'other'
            ]);
            $table->enum('level', ['nursery', 'primary', 'junior_secondary', 'senior_secondary']);
            $table->string('class_grade')->nullable();
            $table->string('state');
            $table->string('lga');
            $table->enum('employment_type', ['full_time', 'part_time', 'contract']);
            $table->decimal('salary_range_min', 10, 2)->nullable();
            $table->decimal('salary_range_max', 10, 2)->nullable();
            $table->date('application_deadline');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('available__jobs');
    }
};
