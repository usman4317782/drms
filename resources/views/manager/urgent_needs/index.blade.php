@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Urgent Needs</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('manager.urgent-needs.create') }}" class="btn btn-danger">
                        <i class="bi bi-plus-circle me-1"></i> Record Urgent Need
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-outline card-danger shadow-sm">
                <div class="card-body table-responsive">
                    <table id="urgentNeedsTable" class="table table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Camp</th>
                                <th>Category</th>
                                <th>Quantity</th>
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
    <x-datatable.scripts tableId="urgentNeedsTable" :route="route('manager.urgent-needs.index')" :columns="[
        ['data' => 'DT_RowIndex', 'name' => 'id', 'orderable' => false, 'searchable' => false],
        ['data' => 'camp', 'name' => 'camp.name'],
        ['data' => 'category', 'name' => 'category'],
        ['data' => 'quantity', 'name' => 'quantity'],
        ['data' => 'priority', 'name' => 'priority', 'orderable' => false],
        ['data' => 'status', 'name' => 'status', 'orderable' => false],
        ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false],
    ]" />
@endpush
