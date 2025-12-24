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

        // Resource distribution (Top 10 Tasks per camp)
        $campTasks = Camp::withCount('tasks')
            ->orderByDesc('tasks_count')
            ->limit(10)
            ->get();

        /** @var \ArielMejiaDev\LarapexCharts\Charts\BarChart $resourceChart */
        $resourceChart = $this->chart->barChart()
            ->setTitle('Top 10 Active Camps')
            ->setSubtitle('Camps with highest task volume')
            ->addData('Tasks', $campTasks->pluck('tasks_count')->toArray())
            ->setLabels($campTasks->pluck('name')->toArray())
            ->setColors(['#0d6efd']);

        // Monthly task volume - DB-Level Aggregation for Performance
        $driver = DB::getDriverName();
        $monthExpression = $driver === 'sqlite'
            ? "strftime('%m', created_at)"
            : "MONTH(created_at)";

        $activityResults = Task::select(
            DB::raw("$monthExpression as month_num"),
            DB::raw('count(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month_num')
            ->orderBy('month_num')
            ->get();

        // Convert SQLite/MySQL month numbers to human names
        $months = [];
        $counts = [];
        foreach ($activityResults as $result) {
            $months[] = Carbon::createFromFormat('m', $result->month_num)->format('M');
            $counts[] = $result->count;
        }

        /** @var \ArielMejiaDev\LarapexCharts\Charts\BarChart $activityChart */
        $activityChart = $this->chart->barChart()
            ->setTitle('Monthly Activity')
            ->setSubtitle('Tasks created in the last 6 months')
            ->addData('Tasks Created', $counts)
            ->setXAxis($months)
            ->setColors(['#198754']);

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

        /** @var \ArielMejiaDev\LarapexCharts\Charts\BarChart $taskStatusChart */
        $taskStatusChart = $this->chart->barChart()
            ->setTitle('Task Statuses')
            ->setSubtitle('Current breakdown for your camps')
            ->addData('Count', $taskBreakdown->pluck('count')->toArray())
            ->setXAxis($taskBreakdown->pluck('status')->map(fn($s) => ucfirst($s))->toArray())
            ->setColors(['#ffc107']);

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

        // Personal Impact (Tasks completed over time) - DB-Level Aggregation
        $driver = DB::getDriverName();
        $monthExpression = $driver === 'sqlite'
            ? "strftime('%m', completed_at)"
            : "MONTH(completed_at)";

        $impactResults = Task::where('assigned_to', $userId)
            ->where('status', Task::STATUS_COMPLETED)
            ->where('completed_at', '>=', now()->subMonths(6))
            ->select(
                DB::raw("$monthExpression as month_num"),
                DB::raw('count(*) as count')
            )
            ->groupBy('month_num')
            ->orderBy('month_num')
            ->get();

        $months = [];
        $counts = [];
        foreach ($impactResults as $result) {
            $months[] = Carbon::createFromFormat('m', $result->month_num)->format('M');
            $counts[] = $result->count;
        }

        /** @var \ArielMejiaDev\LarapexCharts\Charts\BarChart $impactChart */
        $impactChart = $this->chart->barChart()
            ->setTitle('Your Impact')
            ->setSubtitle('Tasks completed in the last 6 months')
            ->addData('Tasks Completed', $counts)
            ->setXAxis($months)
            ->setColors(['#0dcaf0']);

        return new SupporterDashboardData($stats, $acceptedTasks, $impactChart);
    }
}
