<?php

namespace App\Services;

use App\Models\Task;
use App\Models\Camp;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Service class for system-wide oversight and monitoring.
 * This class provides aggregated data for the Admin Oversight module.
 */
class OversightService
{
    /**
     * Get comprehensive details for a specific task.
     */
    public function getTaskDetails(int $taskId): Task
    {
        return Task::with(['camp', 'manager', 'assignedTo'])
            ->findOrFail($taskId);
    }
}
