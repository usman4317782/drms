<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Camp extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'district',
        'location',
        'capacity',
        'status',
        'manager_id',
        'facilities',
        'current_occupancy',
    ];


    protected $casts = [
        'facilities' => 'array',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function urgentNeeds()
    {
        return $this->hasMany(UrgentNeed::class);
    }

    /**
     * Tasks associated with this camp.
     */
    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the task completion percentage for this camp.
     * Note: Assumes tasks_count and completed_tasks_count are loaded.
     */
    public function getTaskCompletionPercentageAttribute(): int
    {
        if ($this->tasks_count === 0) {
            return 0;
        }

        return (int) round(($this->completed_tasks_count / $this->tasks_count) * 100);
    }
}
