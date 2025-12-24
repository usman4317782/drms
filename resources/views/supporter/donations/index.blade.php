@extends('layouts.app')

@section('content')
    <x-ui.page-header title="My Donations">
        <x-slot name="actions">
            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                data-bs-target="#createDonationModal">
                <i class="bi bi-plus-circle me-1"></i> New Donation
            </button>
            <a href="{{ route('supporter.donations.bulk') }}" class="btn btn-outline-dark shadow-sm ms-2">
                <i class="bi bi-stack me-1"></i> Bulk Submission
            </a>
        </x-slot>
    </x-ui.page-header>

    <div class="app-content mt-4">
        <div class="container-fluid">
            <!-- Stats Row -->
            <div class="row g-4 mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm bg-info text-white overflow-hidden">
                        <div class="card-body p-4 position-relative">
                            <div class="position-absolute end-0 top-0 p-3 opacity-25">
                                <i class="bi bi-heart-pulse-fill" style="font-size: 3rem;"></i>
                            </div>
                            <h6 class="text-uppercase fw-bold opacity-75 mb-1 small">Total Contributions</h6>
                            <h2 class="fw-bold mb-0">{{ $totalDonations ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <x-ui.card outlineColor="danger" title="Donation History" icon="bi-clock-history">
                <div class="table-responsive">
                    <table id="donationsTable" class="table table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Details</th>
                                <th>Camp</th>
                                <th>Status</th>
                                <th width="100px">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </x-ui.card>
        </div>
    </div>

    <!-- Create Donation Modal (Component-like Structure) -->
    <div class="modal fade" id="createDonationModal" aria-labelledby="createDonationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form id="createDonationForm">
                @csrf
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title fw-bold" id="createDonationModalLabel">
                            <i class="bi bi-gift me-2"></i>Quick Donation
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Type</label>
                                <select name="type" id="donationType" class="form-select" required
                                    onchange="toggleTypeFields(this, '#cashFields', '#inKindFields')">
                                    <option value="cash">💰 Cash Donation</option>
                                    <option value="in_kind">📦 In-Kind (Items)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Camp (Optional)</label>
                                <select name="camp_id" class="form-select select2-single" data-placeholder="Select a camp">
                                    <option value=""></option>
                                    @foreach ($camps as $camp)
                                        <option value="{{ $camp->id }}">{{ $camp->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="cashFields" class="col-12 row g-3">
                                <div class="col-md-12">
                                    <x-form.input name="amount" label="Amount (PKR)" type="number" step="0.01"
                                        min="1" placeholder="Enter amount..." />
                                </div>
                            </div>

                            <div id="inKindFields" class="col-12 row g-3 d-none">
                                <div class="col-md-6">
                                    <x-form.input name="quantity" label="Quantity" type="number" min="1"
                                        placeholder="0" />
                                </div>
                                <div class="col-md-6">
                                    <x-form.input name="unit" label="Unit" placeholder="e.g. kg, boxes" />
                                </div>
                            </div>

                            <div class="col-12">
                                <x-form.textarea name="description" label="Notes" rows="2"
                                    placeholder="Tell us more about your donation..." />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <span class="spinner-border spinner-border-sm d-none me-1" role="status"
                                aria-hidden="true"></span>
                            Confirm Submission
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <x-datatable.scripts tableId="donationsTable" :route="route('supporter.donations.index')" :columns="[
        ['data' => 'DT_RowIndex', 'name' => 'id', 'orderable' => false, 'searchable' => false],
        ['data' => 'type', 'name' => 'type'],
        ['data' => 'details', 'name' => 'details', 'orderable' => false, 'searchable' => false],
        ['data' => 'camp_name', 'name' => 'camp.name'],
        ['data' => 'status', 'name' => 'status'],
        ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false],
    ]" />

    <script>
        $(document).ready(function() {
            function initSelect2() {
                $('.select2-single').select2({
                    theme: 'bootstrap-5',
                    placeholder: 'Search for a camp',
                    allowClear: true,
                    dropdownParent: $('#createDonationModal'),
                    width: '100%'
                });
            }

            $('#createDonationModal').on('shown.bs.modal', initSelect2);

            window.toggleTypeFields = function(selector, cashId, inKindId) {
                const type = $(selector).val();
                if (type === 'cash') {
                    $(cashId).removeClass('d-none');
                    $(inKindId).addClass('d-none');
                } else {
                    $(cashId).addClass('d-none');
                    $(inKindId).removeClass('d-none');
                }
            };

            $('#createDonationForm').on('submit', function(e) {
                e.preventDefault();
                const $btn = $(this).find('button[type="submit"]');
                $btn.prop('disabled', true).find('.spinner-border').removeClass('d-none');

                $.ajax({
                    url: '{{ route('supporter.donations.store') }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        showAlert('success', 'Thank you for your generous donation!');
                        $('#createDonationModal').modal('hide');
                        $('#createDonationForm')[0].reset();
                        $('.select2-single').val(null).trigger('change');
                        $('#donationsTable').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        showAlert('danger', xhr.responseJSON.message || 'Validation error.');
                    },
                    complete: function() {
                        $btn.prop('disabled', false).find('.spinner-border').addClass('d-none');
                    }
                });
            });

            window.deleteDonation = function(id) {
                if (confirm('Delete this donation record?')) {
                    $.ajax({
                        url: `/supporter/donations/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            showAlert('success', response.message);
                            $('#donationsTable').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            showAlert('danger', xhr.responseJSON.message || 'Error occurred.');
                        }
                    });
                }
            };
        });
    </script>
@endpush
