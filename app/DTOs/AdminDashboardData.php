<?php

namespace App\DTOs;

use Illuminate\Support\Collection;

class AdminDashboardData
{
    public function __construct(
        public array $stats,
        public Collection $recentActivity,
        public $resourceChart,
        public $donationChart
    ) {}
}
