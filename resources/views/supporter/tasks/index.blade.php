@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Volunteer Marketplace</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-outline card-info shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Available Tasks</h3>
                </div>
                <div class="card-body table-responsive">
                    <table id="marketplaceTable" class="table table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Camp</th>
                                <th>Skills Needed</th>
                                <th>Priority</th>
                                <th>Manager</th>
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
    <x-datatable.scripts tableId="marketplaceTable" :route="route('supporter.tasks.index')" :columns="[
        ['data' => 'DT_RowIndex', 'name' => 'id', 'orderable' => false, 'searchable' => false],
        ['data' => 'title', 'name' => 'title'],
        ['data' => 'camp_name', 'name' => 'camp.name'],
        ['data' => 'required_skills', 'name' => 'required_skills'],
        ['data' => 'priority', 'name' => 'priority', 'orderable' => false],
        ['data' => 'manager_name', 'name' => 'manager.name'],
        ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false],
    ]" />

    <script>
        function acceptTask(taskId) {
            if (confirm('Are you sure you want to accept this task? You will be assigned as the volunteer.')) {
                $.ajax({
                    url: `/supporter/tasks/${taskId}/accept`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        showAlert('success', response.message);
                        $('#marketplaceTable').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        showAlert('danger', xhr.responseJSON.message || 'An error occurred.');
                    }
                });
            }
        }
    </script>
@endpush
