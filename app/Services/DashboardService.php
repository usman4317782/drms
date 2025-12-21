<?php

namespace App\Services;

use App\Models\Task;
use App\Models\Camp;
use App\Models\User;
use App\Models\UrgentNeed;
use App\DTOs\AdminDashboardData;
use App\DTOs\ManagerDashboardData;
use App\DTOs\SupporterDashboardData;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Service class for aggregating role-based dashboard metrics and charts.
 * Optimized for both MySQL and SQLite drivers.
 */
class DashboardService
{
    public function __construct(
        protected LarapexChart $chart
    ) {}

    /**
     * Get data for the Admin Dashboard.
     */
    public function getAdminData(): AdminDashboardData
    {
        $stats = [
            'total_users' => User::count(),
            'total_camps' => Camp::count(),
            'pending_needs' => UrgentNeed::where('status', UrgentNeed::STATUS_PENDING)->count(),
            'task_completion' => Task::where('status', Task::STATUS_COMPLETED)->count(),
        ];

        $recentActivity = Task::with('camp')->latest()->take(5)->get();

        // Resource distribution (Tasks per camp)
        $campTasks = Camp::withCount('tasks')->get();

        /** @var \ArielMejiaDev\LarapexCharts\Charts\PieChart $resourceChart */
        $resourceChart = $this->chart->pieChart()
            ->setTitle('Task Distribution Across Camps')
            ->addData($campTasks->pluck('tasks_count')->toArray())
            ->setLabels($campTasks->pluck('name')->toArray());

        // Monthly task volume (Recent activity trends) - Portable Version
        $activityData = Task::select('created_at')
            ->where('created_at', '>=', now()->subMonths(6))
            ->get()
            ->groupBy(fn($task) => Carbon::parse($task->created_at)->format('M'))
            ->map(fn($group) => $group->count());

        /** @var \ArielMejiaDev\LarapexCharts\Charts\LineChart $activityChart */
        $activityChart = $this->chart->lineChart()
            ->setTitle('System Activity (Tasks Created)')
            ->addData('Tasks', $activityData->values()->toArray())
            ->setXAxis($activityData->keys()->toArray());

        return new AdminDashboardData($stats, $recentActivity, $resourceChart, $activityChart);
    }

    /**
     * Get data for the Camp Manager Dashboard.
     */
    public function getManagerData(int $userId): ManagerDashboardData
    {
        $managedCampIds = Camp::where('manager_id', $userId)->pluck('id');

        $stats = [
            'managed_camps' => count($managedCampIds),
            'pending_tasks' => Task::whereIn('camp_id', $managedCampIds)->where('status', Task::STATUS_PENDING)->count(),
            'open_needs' => UrgentNeed::whereIn('camp_id', $managedCampIds)->where('status', UrgentNeed::STATUS_PENDING)->count(),
        ];

        $recentTasks = Task::whereIn('camp_id', $managedCampIds)->latest()->take(5)->get();

        $taskBreakdown = Task::whereIn('camp_id', $managedCampIds)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        /** @var \ArielMejiaDev\LarapexCharts\Charts\DonutChart $taskStatusChart */
        $taskStatusChart = $this->chart->donutChart()
            ->setTitle('Task Status Breakdown')
            ->addData($taskBreakdown->pluck('count')->toArray())
            ->setLabels($taskBreakdown->pluck('status')->map(fn($s) => ucfirst($s))->toArray());

        return new ManagerDashboardData($stats, $recentTasks, $taskStatusChart);
    }

    /**
     * Get data for the Supporter Dashboard.
     */
    public function getSupporterData(int $userId): SupporterDashboardData
    {
        $stats = [
            'accepted_tasks' => Task::where('assigned_to', $userId)->count(),
            'completed_tasks' => Task::where('assigned_to', $userId)->where('status', Task::STATUS_COMPLETED)->count(),
            'pending_tasks' => Task::where('assigned_to', $userId)->where('status', Task::STATUS_IN_PROGRESS)->count(),
        ];

        $acceptedTasks = Task::where('assigned_to', $userId)->with('camp')->latest()->take(5)->get();

        // Personal Impact (Tasks completed over time) - Portable Version
        $impactData = Task::where('assigned_to', $userId)
            ->where('status', Task::STATUS_COMPLETED)
            ->where('completed_at', '>=', now()->subMonths(6))
            ->get()
            ->groupBy(fn($task) => Carbon::parse($task->completed_at)->format('M'))
            ->map(fn($group) => $group->count());

        /** @var \ArielMejiaDev\LarapexCharts\Charts\BarChart $impactChart */
        $impactChart = $this->chart->barChart()
            ->setTitle('Your Impact (Tasks Completed)')
            ->addData('Completed', $impactData->values()->toArray())
            ->setXAxis($impactData->keys()->toArray());

        return new SupporterDashboardData($stats, $acceptedTasks, $impactChart);
    }
}
