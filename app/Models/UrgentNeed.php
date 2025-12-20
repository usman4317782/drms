<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrgentNeed extends Model
{
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
