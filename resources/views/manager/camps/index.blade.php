@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <h3 class="m-0">My Assigned Camps</h3>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-body table-responsive">
                    <table id="campsTable" class="table table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Camp</th>
                                <th>Location</th>
                                <th>Facilities</th>
                                <th>Capacity</th>
                                <th>Occupancy</th>
                                <th>Status</th>
                                <th width="100px">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <x-datatable.scripts tableId="campsTable" :route="route('manager.camps.index')" :columns="[
        ['data' => 'DT_RowIndex', 'name' => 'id', 'orderable' => false, 'searchable' => false],
        ['data' => 'name', 'name' => 'name'],
        ['data' => 'location', 'name' => 'location'],
        ['data' => 'facilities', 'name' => 'facilities', 'orderable' => false],
        ['data' => 'capacity', 'name' => 'capacity'],
        ['data' => 'current_occupancy', 'name' => 'current_occupancy'],
        ['data' => 'status', 'name' => 'status'],
        ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false],
    ]" />
@endpush
