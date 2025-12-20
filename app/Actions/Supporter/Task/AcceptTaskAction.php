<?php

namespace App\Actions\Supporter\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AcceptTaskAction
{
    public function execute(Task $task, User $user): void
    {
        if (!$user->hasRole(['supporter', 'volunteer', 'donor'])) {
            throw new \Exception('Only Supporters, Volunteers and Donors can accept tasks.');
        }

        DB::transaction(function () use ($task, $user) {
            // Lock the task row until the transaction is complete
            $lockedTask = Task::where('id', $task->id)->lockForUpdate()->first();

            if ($lockedTask->assigned_to !== null) {
                throw new \Exception('This task has just been assigned to someone else.');
            }

            $lockedTask->update([
                'assigned_to' => $user->id,
                'status' => 'in_progress',
            ]);
        });
    }
}
