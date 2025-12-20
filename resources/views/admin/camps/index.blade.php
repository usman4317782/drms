@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="m-0 text-dark fw-bold">Camp Management</h3>
                    <p class="text-muted small mb-0">Monitor and manage relief camps across different districts.</p>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.camps.create') }}" class="btn btn-primary shadow-sm">
                        <i class="bi bi-plus-lg me-1"></i> Add New Camp
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <x-ui.card type="primary" :outline="true">
                <div class="table-responsive">
                    <table id="campsTable" class="table table-hover align-middle w-100">
                        <thead class="bg-light">
                            <tr>
                                <th width="50">#</th>
                                <th>Camp Name</th>
                                <th>Location</th>
                                <th>Manager</th>
                                <th>Facilities</th>
                                <th>Status</th>
                                <th width="100">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </x-ui.card>
        </div>
    </div>
@endsection

@push('scripts')
    <x-datatable.scripts tableId="campsTable" :route="route('admin.camps.index')" :columns="[
        ['data' => 'DT_RowIndex', 'name' => 'id', 'orderable' => false, 'searchable' => false],
        ['data' => 'name', 'name' => 'name'],
        ['data' => 'location', 'name' => 'location'],
        ['data' => 'manager', 'name' => 'manager'],
        ['data' => 'facilities', 'name' => 'facilities', 'orderable' => false, 'searchable' => false],
        ['data' => 'status', 'name' => 'status'],
        ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false],
    ]"
        searchPlaceholder="Search camps by name or location..." />
@endpush
