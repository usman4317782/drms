@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">My Volunteer Tasks</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('supporter.tasks.index') }}" class="btn btn-primary">
                        <i class="bi bi-shop me-1"></i> Visit Marketplace
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-outline card-success shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Assigned Tasks</h3>
                </div>
                <div class="card-body table-responsive">
                    <table id="myTasksTable" class="table table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Camp</th>
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
    <x-datatable.scripts tableId="myTasksTable" :route="route('supporter.tasks.my')" :columns="[
        ['data' => 'DT_RowIndex', 'name' => 'id', 'orderable' => false, 'searchable' => false],
        ['data' => 'title', 'name' => 'title'],
        ['data' => 'camp_name', 'name' => 'camp.name'],
        ['data' => 'status', 'name' => 'status'],
        ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false],
    ]" />

    <script>
        function completeTask(taskId) {
            if (confirm('Are you sure you want to mark this task as completed?')) {
                $.ajax({
                    url: `/supporter/tasks/${taskId}/complete`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        showAlert('success', response.message);
                        $('#myTasksTable').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        showAlert('danger', xhr.responseJSON.message || 'An error occurred.');
                    }
                });
            }
        }
    </script>
@endpush
