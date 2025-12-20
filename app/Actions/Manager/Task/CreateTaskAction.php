<?php

namespace App\Actions\Manager\Task;

use App\Models\Task;
use App\DTOs\TaskData;
use Illuminate\Support\Facades\DB;

class CreateTaskAction
{
    /**
     * Create a new task.
     */
    public function execute(TaskData $data): Task
    {
        return DB::transaction(function () use ($data) {
            return Task::create($data->toArray());
        });
    }
}
