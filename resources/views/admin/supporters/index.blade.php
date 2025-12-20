@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="m-0 text-dark fw-bold">Supporter Management</h3>
                    <p class="text-muted small mb-0">Manage Donors and Volunteers, their skills, and historical role
                        assignments.</p>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.supporters.create') }}" class="btn btn-primary shadow-sm">
                        <i class="bi bi-plus-lg me-1"></i> Add New Supporter
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <x-ui.card type="primary" :outline="true">
                <div class="table-responsive">
                    <table id="supportersTable" class="table table-hover align-middle w-100 border-flat">
                        <thead class="bg-light">
                            <tr>
                                <th width="50">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Status</th>
                                <th width="120">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </x-ui.card>
        </div>
    </div>
@endsection

@push('scripts')
    <x-datatable.scripts tableId="supportersTable" :route="route('admin.supporters.index')" :columns="[
        ['data' => 'DT_RowIndex', 'name' => 'id', 'orderable' => false, 'searchable' => false],
        ['data' => 'name', 'name' => 'name'],
        ['data' => 'email', 'name' => 'email'],
        ['data' => 'roles_list', 'name' => 'roles_list', 'orderable' => false, 'searchable' => false],
        ['data' => 'status', 'name' => 'status'],
        ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false],
    ]"
        searchPlaceholder="Search supporters..." />
@endpush
