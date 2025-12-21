<?php

namespace App\DTOs;

use Illuminate\Support\Collection;

class ManagerDashboardData
{
    public function __construct(
        public array $stats,
        public Collection $recentTasks,
        public $taskStatusChart
    ) {}
}
