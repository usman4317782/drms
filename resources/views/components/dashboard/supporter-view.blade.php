@props(['data'])

<div class="row">
    <x-dashboard.stat-card title="Accepted Tasks" :value="$data->stats['accepted_tasks']" icon="cart-check-fill" color="primary"
        :link="route('supporter.tasks.my')" />
    <x-dashboard.stat-card title="Impact Score" :value="$data->stats['completed_tasks']" icon="patch-check-fill" color="success" />
    <x-dashboard.stat-card title="Pending Execution" :value="$data->stats['pending_tasks']" icon="hourglass-split" color="warning"
        :link="route('supporter.tasks.my')" />
    <x-dashboard.stat-card title="Global Impact" value="High" icon="globe-americas" color="info" />
</div>

<div class="row mt-4">
    <x-dashboard.chart-card title="Personal Impact (Tasks Completed)" :chart="$data->impactChart" width="col-lg-12" />
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header border-0 bg-transparent">
                <h3 class="card-title fw-bold">Recent Contributions</h3>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($data->acceptedTasks as $task)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-heart-fill text-danger me-2"></i>
                                <strong>{{ $task->title }}</strong> at {{ $task->camp->name }}
                            </div>
                            <span
                                class="badge text-bg-{{ $task->status === 'completed' ? 'success' : 'warning' }} rounded-pill">
                                {{ ucfirst($task->status) }}
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-center py-4 text-muted small">No recent task contributions.
                            Visit the Marketplace!</li>
                    @endforelse
                </ul>
            </div>
            <div class="card-footer bg-transparent border-0 text-center">
                <a href="{{ route('supporter.tasks.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                    Explore Marketplace <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
