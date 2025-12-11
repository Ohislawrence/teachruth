<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualifyingQuestion extends Model
{
    use HasFactory;

    const TYPE_MULTIPLE_CHOICE = 'multiple_choice';
    const TYPE_TEXT = 'text';
    const TYPE_BOOLEAN = 'boolean';

    protected $fillable = [
        'question',
        'type',
        'options',
        'is_active',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // Helpers
    public function isMultipleChoice()
    {
        return $this->type === self::TYPE_MULTIPLE_CHOICE;
    }

    public function isText()
    {
        return $this->type === self::TYPE_TEXT;
    }

    public function isBoolean()
    {
        return $this->type === self::TYPE_BOOLEAN;
    }
}
