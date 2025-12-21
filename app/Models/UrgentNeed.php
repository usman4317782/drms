<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrgentNeed extends Model
{
    use HasFactory;
    // Status Constants
    public const STATUS_PENDING   = 'pending';
    public const STATUS_FULFILLED = 'fulfilled';

    // Priority Constants
    public const PRIORITY_LOW    = 'low';
    public const PRIORITY_MEDIUM = 'medium';
    public const PRIORITY_HIGH   = 'high';
    protected $fillable = [
        'camp_id',
        'category',
        'description',
        'quantity',
        'priority',
        'status',
    ];

    public function camp()
    {
        return $this->belongsTo(Camp::class);
    }

    public function getPriorityColorAttribute(): string
    {
        return match ($this->priority) {
            'high'   => 'danger',
            'medium' => 'warning',
            'low'    => 'info',
            default  => 'secondary',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'fulfilled' => 'success',
            'pending'   => 'warning',
            default     => 'secondary',
        };
    }
}
