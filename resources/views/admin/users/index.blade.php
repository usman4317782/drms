@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="m-0 text-dark fw-bold">User Management</h3>
                    <p class="text-muted small mb-0">Manage system users, roles, and access permissions.</p>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary shadow-sm">
                        <i class="bi bi-plus-lg me-1"></i> Add New User
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <x-ui.card type="primary" :outline="true">
                <div class="table-responsive">
                    <table id="usersTable" class="table table-hover align-middle w-100 border-flat">
                        <thead class="bg-light">
                            <tr>
                                <th width="50">#</th>
                                <th>User Details</th>
                                <th>Role</th>
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
    <x-datatable.scripts tableId="usersTable" :route="route('admin.users.index')" :columns="[
        ['data' => 'DT_RowIndex', 'name' => 'id', 'orderable' => false, 'searchable' => false],
        ['data' => 'name', 'name' => 'name'],
        ['data' => 'role', 'name' => 'role'],
        ['data' => 'status', 'name' => 'status'],
        ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false],
    ]"
        searchPlaceholder="Search system users..." />
@endpush
