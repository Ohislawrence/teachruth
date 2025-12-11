<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESSFUL = 'successful';
    const STATUS_FAILED = 'failed';

    protected $fillable = [
        'user_id',
        'payment_reference',
        'amount',
        'currency',
        'status',
        'gateway_response',
        'metadata',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
        'paid_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeSuccessful($query)
    {
        return $query->where('status', self::STATUS_SUCCESSFUL);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    // Helpers
    public function isSuccessful()
    {
        return $this->status === self::STATUS_SUCCESSFUL;
    }

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isFailed()
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function markAsSuccessful($gatewayResponse = null)
    {
        $this->update([
            'status' => self::STATUS_SUCCESSFUL,
            'gateway_response' => $gatewayResponse,
            'paid_at' => now(),
        ]);
    }

    public function markAsFailed($gatewayResponse = null)
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'gateway_response' => $gatewayResponse,
        ]);
    }
}
