<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_REVIEWED = 'reviewed';
    const STATUS_SHORTLISTED = 'shortlisted';
    const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'job_id',
        'teacher_id',
        'cover_letter',
        'status',
        'school_feedback',
    ];

    // Relationships
    public function job()
    {
        return $this->belongsTo(Available_Job::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function teacherProfile()
    {
        return $this->belongsTo(TeacherProfile::class, 'teacher_id', 'user_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeReviewed($query)
    {
        return $query->where('status', self::STATUS_REVIEWED);
    }

    public function scopeShortlisted($query)
    {
        return $query->where('status', self::STATUS_SHORTLISTED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    // Helpers
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isShortlisted()
    {
        return $this->status === self::STATUS_SHORTLISTED;
    }

    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }
}
