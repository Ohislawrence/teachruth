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
        Schema::create('teacher_appraisals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->decimal('overall_score', 5, 2); // Score out of 100
            $table->json('scores_breakdown'); // Store category scores as JSON
            $table->text('strengths'); // AI-generated strengths
            $table->text('improvement_areas'); // AI-generated improvement suggestions
            $table->text('detailed_feedback'); // Comprehensive AI feedback
            $table->string('appraisal_report_path')->nullable(); // Path to generated PDF report
            $table->boolean('is_latest')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_appraisals');
    }
};
