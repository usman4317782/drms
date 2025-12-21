@props(['data'])

<div class="row">
    <x-dashboard.stat-card title="System Users" :value="$data->stats['total_users']" icon="people-fill" color="primary" :link="route('admin.users.index')" />
    <x-dashboard.stat-card title="Active Camps" :value="$data->stats['total_camps']" icon="houses-fill" color="success" :link="route('admin.camps.index')" />
    <x-dashboard.stat-card title="Pending Needs" :value="$data->stats['pending_needs']" icon="exclamation-diamond-fill" color="warning"
        :link="route('admin.urgent-needs.index')" />
    <x-dashboard.stat-card title="Tasks Completed" :value="$data->stats['task_completion']" icon="check-circle-fill" color="info"
        :link="route('admin.oversight.tasks')" />
</div>

<div class="row mt-4">
    <x-dashboard.chart-card title="Task Distribution Across Camps" :chart="$data->resourceChart" />
    <x-dashboard.chart-card title="Recent System Activity" :chart="$data->donationChart" />
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header border-0 bg-transparent">
                <h3 class="card-title fw-bold">Recent Task Audit</h3>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($data->recentActivity as $activity)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-activity text-primary me-2"></i>
                                <strong>{{ $activity->title }}</strong> at {{ $activity->camp->name }}
                            </div>
                            <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                        </li>
                    @empty
                        <li class="list-group-item text-center py-4 text-muted small">No recent activity detected</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
