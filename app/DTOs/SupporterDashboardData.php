<?php

namespace App\DTOs;

use Illuminate\Support\Collection;

class SupporterDashboardData
{
    public function __construct(
        public array $stats,
        public Collection $acceptedTasks,
        public $impactChart
    ) {}
}
