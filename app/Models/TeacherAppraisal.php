<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAppraisal extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'overall_score',
        'scores_breakdown',
        'strengths',
        'improvement_areas',
        'detailed_feedback',
        'appraisal_report_path',
        'is_latest',
    ];

    protected $casts = [
        'overall_score' => 'decimal:2',
        'scores_breakdown' => 'array',
        'is_latest' => 'boolean',
    ];

    // Relationships
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Accessors - Convert string back to array for frontend if needed
    public function getStrengthsArrayAttribute()
    {
        if (empty($this->strengths)) {
            return [];
        }

        // Split by period and filter empty strings
        $items = array_filter(array_map('trim', explode('.', $this->strengths)));
        return array_values($items);
    }

    public function getImprovementAreasArrayAttribute()
    {
        if (empty($this->improvement_areas)) {
            return [];
        }

        // Split by period and filter empty strings
        $items = array_filter(array_map('trim', explode('.', $this->improvement_areas)));
        return array_values($items);
    }

    // Accessors
    public function getReportUrlAttribute()
    {
        return $this->appraisal_report_path ? asset('storage/' . $this->appraisal_report_path) : null;
    }

    public function getGradeAttribute()
    {
        $score = $this->overall_score;

        if ($score >= 90) return 'A+';
        if ($score >= 80) return 'A';
        if ($score >= 70) return 'B';
        if ($score >= 60) return 'C';
        if ($score >= 50) return 'D';
        return 'F';
    }

    // Scopes
    public function scopeLatest($query)
    {
        return $query->where('is_latest', true);
    }

    // Methods
    public function markAsLatest()
    {
        // Remove latest flag from other appraisals for this teacher
        self::where('teacher_id', $this->teacher_id)
            ->where('id', '!=', $this->id)
            ->update(['is_latest' => false]);

        $this->update(['is_latest' => true]);
    }
}
