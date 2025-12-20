@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Task Management</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('manager.tasks.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Create Task
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-body table-responsive">
                    <table id="tasksTable" class="table table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Camp</th>
                                <th>Assigned To</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th width="120px">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <x-datatable.scripts tableId="tasksTable" :route="route('manager.tasks.index')" :columns="[
        ['data' => 'DT_RowIndex', 'name' => 'id', 'orderable' => false, 'searchable' => false],
        ['data' => 'title', 'name' => 'title'],
        ['data' => 'camp_name', 'name' => 'camp.name'],
        ['data' => 'assigned_name', 'name' => 'assignedTo.name'],
        ['data' => 'priority', 'name' => 'priority', 'orderable' => false],
        ['data' => 'status', 'name' => 'status', 'orderable' => false],
        ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false],
    ]" />
@endpush
