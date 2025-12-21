@extends('layouts.app')

@section('title', 'Task Monitoring | ' . config('adminlte.site_name', 'DRMS'))

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Global Task Monitoring</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-outline card-warning shadow-sm">
                <div class="card-header border-0">
                    <h3 class="card-title text-muted small text-uppercase fw-bold">System-Wide Task Audit</h3>
                </div>
                <div class="card-body table-responsive">
                    <table id="oversightTasksTable" class="table table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Camp</th>
                                <th>Manager</th>
                                <th>Volunteer</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th width="80px">Details</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Modal -->
    <div class="modal fade" id="taskDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Task Oversight Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="taskDetailsContent">
                    <div class="d-flex justify-content-center py-5">
                        <div class="spinner-border text-warning" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close Oversight View</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <x-datatable.scripts tableId="oversightTasksTable" :route="route('admin.oversight.tasks')" :buttons="false" :columns="[
        ['data' => 'DT_RowIndex', 'name' => 'id', 'orderable' => false, 'searchable' => false],
        ['data' => 'title', 'name' => 'title'],
        ['data' => 'camp_name', 'name' => 'camp.name'],
        ['data' => 'manager_name', 'name' => 'manager.name'],
        ['data' => 'assigned_name', 'name' => 'assignedTo.name'],
        ['data' => 'priority', 'name' => 'priority', 'orderable' => false],
        ['data' => 'status', 'name' => 'status', 'orderable' => false],
        ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false],
    ]" />

    <script>
        function viewTaskDetails(taskId) {
            const modalElement = $('#taskDetailsModal');
            const modalContent = $('#taskDetailsContent');
            const modal = new bootstrap.Modal(modalElement[0]);

            // Show loader using jQuery
            modalContent.html(`
                <div class="d-flex justify-content-center py-5">
                    <div class="spinner-border text-warning" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>`);
            modal.show();

            // Fetch dynamic details using jQuery for consistency
            const url = "{{ route('admin.oversight.show', ':id') }}".replace(':id', taskId);

            $.get(url, function(data) {
                modalContent.html(`
                    <div class="alert alert-info py-2 small mb-3">
                        <i class="bi bi-info-circle me-1"></i> This is a read-only oversight view (Oversight Policy enforced).
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-uppercase text-muted fw-bold small">Task Information</h6>
                        <h5 class="mb-1">${data.title}</h5>
                        <p class="text-secondary small mb-0">${data.description}</p>
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <label class="text-muted small d-block">Status</label>
                            ${data.status}
                        </div>
                        <div class="col-6">
                            <label class="text-muted small d-block">Priority</label>
                            ${data.priority}
                        </div>
                        <div class="col-6">
                            <label class="text-muted small d-block">Camp</label>
                            <span class="fw-bold text-dark">${data.camp}</span>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small d-block">Due Date</label>
                            <span class="text-dark">${data.due_date}</span>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small d-block">Manager</label>
                            <span class="text-dark">${data.manager}</span>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small d-block">Assigned To</label>
                            <span class="text-dark">${data.assigned_to}</span>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div>
                        <h6 class="text-uppercase text-muted fw-bold small">Required Skills</h6>
                        <p class="text-dark small mb-0">${data.required_skills}</p>
                    </div>

                    <div class="mt-4 pt-2 border-top">
                        <small class="text-muted italic">Task Audit ID: #ST-OVR-${data.id}</small>
                    </div>
                `);
            }).fail(function() {
                modalContent.html(`
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i> Failed to load task details. Please try again.
                    </div>
                `);
            });
        }
    </script>
@endpush
