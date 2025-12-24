@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Donation Overview</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-outline card-success shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">All System Donations</h3>
                </div>
                <div class="card-body table-responsive">
                    <table id="adminDonationsTable" class="table table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Supporter</th>
                                <th>Camp</th>
                                <th>Type</th>
                                <th>Details</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <x-datatable.scripts tableId="adminDonationsTable" :route="route('admin.donations.index')" :columns="[
        ['data' => 'DT_RowIndex', 'name' => 'id', 'orderable' => false, 'searchable' => false],
        ['data' => 'supporter_name', 'name' => 'supporter.name'],
        ['data' => 'camp_name', 'name' => 'camp.name'],
        ['data' => 'type', 'name' => 'type'],
        ['data' => 'details', 'name' => 'details', 'orderable' => false, 'searchable' => false],
        ['data' => 'status', 'name' => 'status'],
    ]" />
@endpush
