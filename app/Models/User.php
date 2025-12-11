<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    // Add these constants
    const TYPE_TEACHER = 'teacher';
    const TYPE_SCHOOL = 'school';
    const TYPE_ADMIN = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'registration_completed_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'registration_completed_at' => 'datetime',
        ];
    }

    // Relationships
    public function teacherProfile()
    {
        return $this->hasOne(TeacherProfile::class);
    }

    public function schoolProfile()
    {
        return $this->hasOne(SchoolProfile::class);
    }

    public function jobs()
    {
        return $this->hasMany(Available_Job::class, 'school_id');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'teacher_id');
    }

    public function appraisals()
    {
        return $this->hasMany(TeacherAppraisal::class, 'teacher_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function latestAppraisal()
    {
        return $this->hasOne(TeacherAppraisal::class, 'teacher_id')->latest();
    }

    // Scopes
    public function scopeTeachers($query)
    {
        return $query->where('type', self::TYPE_TEACHER);
    }

    public function scopeSchools($query)
    {
        return $query->where('type', self::TYPE_SCHOOL);
    }

    // Helpers
    public function isTeacher()
    {
        return $this->type === self::TYPE_TEACHER;
    }

    public function isSchool()
    {
        return $this->type === self::TYPE_SCHOOL;
    }

    public function isAdmin()
    {
        return $this->type === self::TYPE_ADMIN;
    }

    public static function getTypeOptions()
    {
        return [
            self::TYPE_TEACHER => 'Teacher',
            self::TYPE_SCHOOL => 'School',
            self::TYPE_ADMIN => 'Administrator',
        ];
    }
}
