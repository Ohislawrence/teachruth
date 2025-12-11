<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'school_name',
        'about',
        'phone',
        'address',
        'state',
        'lga',
        'website',
        'logo_path',
        'school_type',
        'ownership',
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getLogoUrlAttribute()
    {
        return $this->logo_path ? asset('storage/' . $this->logo_path) : null;
    }

    public function getWebsiteUrlAttribute()
    {
        return $this->website ? (strpos($this->website, 'http') === 0 ? $this->website : 'https://' . $this->website) : null;
    }

    // Scopes
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }
}
