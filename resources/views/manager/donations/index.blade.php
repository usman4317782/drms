@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Donation Tracking</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-outline card-info shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Allocated Donations</h3>
                </div>
                <div class="card-body table-responsive">
                    <table id="managerDonationsTable" class="table table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Supporter</th>
                                <th>Type</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th width="150px">Update Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <x-datatable.scripts tableId="managerDonationsTable" :route="route('manager.donations.index')" :columns="[
        ['data' => 'DT_RowIndex', 'name' => 'id', 'orderable' => false, 'searchable' => false],
        ['data' => 'supporter_name', 'name' => 'supporter.name'],
        ['data' => 'type', 'name' => 'type'],
        ['data' => 'details', 'name' => 'details', 'orderable' => false, 'searchable' => false],
        ['data' => 'status', 'name' => 'status'],
        ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false],
    ]" />

    <script>
        function updateStatus(id, status) {
            $.ajax({
                url: `/manager/donations/${id}/status`,
                type: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(response) {
                    showAlert('success', response.message);
                    $('#managerDonationsTable').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    showAlert('danger', xhr.responseJSON.message || 'Error occurred.');
                }
            });
        }
    </script>
@endpush
