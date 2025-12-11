<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeacherProfile extends Model
{
     use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'bio',
        'qualification',
        'years_of_experience',
        'specialization',
        'state',
        'lga',
        'resume_path',
        'linkedin_url',
        'is_public',
        'qualifying_answers',
    ];

    protected $casts = [
        'qualifying_answers' => 'array',
        'is_public' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getResumeUrlAttribute()
    {
        return $this->resume_path ? asset('storage/' . $this->resume_path) : null;
    }

    // Helpers
    public function isComplete()
    {
        return !empty($this->qualification) && !empty($this->specialization);
    }
}
