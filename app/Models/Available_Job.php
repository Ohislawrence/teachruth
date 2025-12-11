<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Available_Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'title',
        'description',
        'subject',
        'level',
        'class_grade',
        'state',
        'lga',
        'employment_type',
        'salary_range_min',
        'salary_range_max',
        'application_deadline',
        'is_active',
    ];

    protected $casts = [
        'application_deadline' => 'date',
        'salary_range_min' => 'decimal:2',
        'salary_range_max' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(User::class, 'school_id');
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function schoolProfile()
    {
        return $this->belongsTo(SchoolProfile::class, 'school_id', 'user_id');
    }

    // Accessors
    public function getSalaryRangeAttribute()
    {
        if ($this->salary_range_min && $this->salary_range_max) {
            return '₦' . number_format($this->salary_range_min) . ' - ₦' . number_format($this->salary_range_max);
        } elseif ($this->salary_range_min) {
            return '₦' . number_format($this->salary_range_min);
        }

        return 'Negotiable';
    }

    public function getIsExpiredAttribute()
    {
        return $this->application_deadline->isPast();
    }

    public function getIsActiveAttribute($value)
    {
        return $value && !$this->is_expired;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('application_deadline', '>=', now());
    }

    public function scopeBySubject($query, $subject)
    {
        return $query->where('subject', $subject);
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    public function scopeByState($query, $state)
    {
        return $query->where('state', $state);
    }

    public function scopeByLga($query, $lga)
    {
        return $query->where('lga', $lga);
    }

    public function scopeFilter(Builder $query, array $filters = [])
    {
        return $query->when($filters['search'] ?? null, function (Builder $query, $search) {
        $query->where(function (Builder $query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhereHas('schoolProfile', function (Builder $query) use ($search) {
                      $query->where('school_name', 'like', '%' . $search . '%');
                  });
        });
        })
        ->when($filters['subject'] ?? null, function (Builder $query, $subject) {
            $query->where('subject', $subject);
        })
        ->when($filters['level'] ?? null, function (Builder $query, $level) {
            $query->where('level', $level);
        })
        ->when($filters['state'] ?? null, function (Builder $query, $state) {
            $query->where('state', 'like', '%' . $state . '%');
        });
    }


}
