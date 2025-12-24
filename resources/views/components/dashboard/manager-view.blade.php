@props(['data'])

<div class="row">
    <x-dashboard.stat-card title="Managed Camps" :value="$data->stats['managed_camps']" icon="house-heart-fill" color="primary"
        :link="route('manager.camps.index')" />
    <x-dashboard.stat-card title="Pending Tasks" :value="$data->stats['pending_tasks']" icon="list-check" color="warning" :link="route('manager.tasks.index')" />
    <x-dashboard.stat-card title="Open Needs" :value="$data->stats['open_needs']" icon="exclamation-triangle-fill" color="danger"
        :link="route('manager.urgent-needs.index')" />
    <x-dashboard.stat-card title="Operational Health" value="Stable" icon="heart-pulse-fill" color="success" />
</div>

<!-- Operational Progress -->
<div class="row mt-4">
    <x-dashboard.progress-card title="Need Fulfillment Rate" :percentage="65" color="danger" icon="cart-plus-fill" />
    <x-dashboard.progress-card title="Task Completion Speed" :percentage="80" color="warning" icon="speedometer2" />
    <x-dashboard.progress-card title="Camp Capacity" :percentage="45" color="success" icon="people-fill" />
    <x-dashboard.progress-card title="Resource Allocation" :percentage="90" color="info" icon="box-seam-fill" />
</div>

<div class="row mt-4">
    <x-dashboard.chart-card title="Camp Analytics" :chart="$data->taskStatusChart" width="col-lg-12" />
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header border-0 bg-transparent">
                <h3 class="card-title fw-bold">Recent Tasks in Your Camps</h3>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($data->recentTasks as $task)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-gear-wide-connected text-warning me-2"></i>
                                <strong>{{ $task->title }}</strong> - {{ ucfirst($task->status) }}
                            </div>
                            <small class="text-muted">{{ $task->created_at->diffForHumans() }}</small>
                        </li>
                    @empty
                        <li class="list-group-item text-center py-4 text-muted small">No recent tasks managed</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
