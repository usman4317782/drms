<?php

namespace App\Actions\Supporter\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CompleteTaskAction
{
    public function execute(Task $task, User $user): void
    {
        if ($task->assigned_to !== $user->id) {
            throw new \Exception('You can only complete tasks assigned to you.');
        }

        DB::transaction(function () use ($task) {
            $task->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);
        });
    }
}
