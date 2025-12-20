@extends('layouts.app')

@section('title', 'Urgent Needs')

@section('content')
    <x-ui.page-header title="Urgent Needs" description="Monitor and fulfill resource requests from all relief camps."
        icon="bi bi-exclamation-octagon" />

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <x-ui.card title="All Active Needs" type="primary" :outline="true">
                        <div class="table-responsive">
                            <table id="urgentNeedsTable" class="table table-hover align-middle w-100">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Camp</th>
                                        <th>Manager</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th style="width: 100px;">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </x-ui.card>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <x-datatable.scripts tableId="urgentNeedsTable" :route="route('admin.urgent-needs.index')" :columns="[
        ['data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
        ['data' => 'camp', 'name' => 'camp.name'],
        ['data' => 'manager', 'name' => 'camp.manager.name'],
        ['data' => 'category', 'name' => 'category'],
        ['data' => 'quantity', 'name' => 'quantity'],
        ['data' => 'priority', 'orderable' => false],
        ['data' => 'status', 'orderable' => false],
        ['data' => 'actions', 'orderable' => false, 'searchable' => false],
    ]"
        searchPlaceholder="Search needs by camp or category..." />
@endpush
