@extends('layouts.app')

@section('content')
    <x-ui.page-header title="Bulk Donation" :breadcrumbs="[['label' => 'Donations', 'link' => route('supporter.donations.index')], ['label' => 'Bulk Submission']]">
        <x-slot name="actions">
            <a href="{{ route('supporter.donations.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to History
            </a>
        </x-slot>
    </x-ui.page-header>

    <div class="app-content">
        <div class="container-fluid">
            <x-ui.card outlineColor="dark" title="Multi-Row Submission" icon="bi-stack">
                <form id="bulkDonationForm">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="bulkDonationTable">
                            <thead class="bg-light">
                                <tr>
                                    <th width="180px">Type</th>
                                    <th width="300px">Assign Camp</th>
                                    <th width="150px">Amount/Qty</th>
                                    <th width="120px">Unit</th>
                                    <th>Description</th>
                                    <th width="50px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="donation-row">
                                    <td>
                                        <select name="donations[0][type]" class="form-select border-2" required
                                            onchange="handleBulkTypeChange(this)">
                                            <option value="cash">💰 Cash</option>
                                            <option value="in_kind">📦 In-Kind</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="donations[0][camp_id]" class="form-select select2-bulk"
                                            data-placeholder="Search Camp">
                                            <option value=""></option>
                                            @foreach ($camps as $camp)
                                                <option value="{{ $camp->id }}">{{ $camp->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="donations[0][amount]"
                                            class="form-control border-2 donation-amount" step="0.01" min="1"
                                            required placeholder="0.00">
                                        <input type="number" name="donations[0][quantity]"
                                            class="form-control border-2 donation-quantity d-none" min="1"
                                            placeholder="0">
                                    </td>
                                    <td>
                                        <input type="text" name="donations[0][unit]"
                                            class="form-control border-2 donation-unit d-none" placeholder="kg/pcs">
                                    </td>
                                    <td>
                                        <input type="text" name="donations[0][description]" class="form-control border-2"
                                            placeholder="Brief note...">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-light text-danger border-0" disabled
                                            onclick="removeBulkRow(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer bg-white border-top-0 pt-4 text-between d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-primary shadow-sm px-4" onclick="addBulkRow()">
                            <i class="bi bi-plus-lg me-1"></i> Add Another Item
                        </button>
                        <button type="submit" class="btn btn-dark px-5 shadow">
                            <span class="spinner-border spinner-border-sm d-none me-1" role="status"
                                aria-hidden="true"></span>
                            Submit All Donations
                        </button>
                    </div>
                </form>
            </x-ui.card>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            function initSelect2(selector) {
                $(selector).select2({
                    theme: 'bootstrap-5',
                    placeholder: 'Search for a camp',
                    allowClear: true,
                    width: '100%'
                });
            }

            initSelect2('.select2-bulk');

            let rowIndex = 1;
            window.addBulkRow = function() {
                const row = $('.donation-row').first().clone();

                row.find('select, input').each(function() {
                    const name = $(this).attr('name');
                    if (name) {
                        $(this).attr('name', name.replace('[0]', '[' + rowIndex + ']'));
                    }
                    if ($(this).is('select')) {
                        $(this).val('cash');
                    } else {
                        $(this).val('');
                    }
                });

                row.find('.donation-amount').removeClass('d-none').prop('required', true);
                row.find('.donation-quantity, .donation-unit').addClass('d-none').prop('required', false);

                row.find('.select2-container').remove();
                row.find('select').attr('class', 'form-select select2-bulk').show();

                row.find('button').prop('disabled', false);
                $('#bulkDonationTable tbody').append(row);

                initSelect2(row.find('.select2-bulk'));
                rowIndex++;
            };

            window.removeBulkRow = function(btn) {
                $(btn).closest('tr').remove();
            };

            window.handleBulkTypeChange = function(select) {
                const row = $(select).closest('tr');
                const type = $(select).val();

                if (type === 'cash') {
                    row.find('.donation-amount').removeClass('d-none').prop('required', true);
                    row.find('.donation-quantity, .donation-unit').addClass('d-none').prop('required', false);
                } else {
                    row.find('.donation-amount').addClass('d-none').prop('required', false);
                    row.find('.donation-quantity, .donation-unit').removeClass('d-none').prop('required', true);
                }
            };

            $('#bulkDonationForm').on('submit', function(e) {
                e.preventDefault();
                const $btn = $(this).find('button[type="submit"]');
                $btn.prop('disabled', true).find('.spinner-border').removeClass('d-none');

                $.ajax({
                    url: '{{ route('supporter.donations.bulk_store') }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        showAlert('success', response.message);
                        setTimeout(() => {
                            window.location.href =
                                '{{ route('supporter.donations.index') }}';
                        }, 1500);
                    },
                    error: function(xhr) {
                        showAlert('danger', xhr.responseJSON.message ||
                            'Bulk submission failed.');
                        $btn.prop('disabled', false).find('.spinner-border').addClass('d-none');
                    }
                });
            });
        });
    </script>
@endpush
