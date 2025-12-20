<?php

namespace App\Actions\Manager\Task;

use App\Models\Task;
use App\DTOs\TaskData;
use Illuminate\Support\Facades\DB;

class UpdateTaskAction
{
    /**
     * Update an existing task.
     */
    public function execute(Task $task, TaskData $data): Task
    {
        return DB::transaction(function () use ($task, $data) {
            $updateData = $data->toArray();

            // Auto-set completed_at if status changed to completed
            if ($data->status === 'completed' && $task->status !== 'completed') {
                $updateData['completed_at'] = now();
            } elseif ($data->status !== 'completed') {
                $updateData['completed_at'] = null;
            }

            $task->update($updateData);

            return $task->fresh();
        });
    }
}
