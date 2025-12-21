@props([
    'tableId',
    'route',
    'columns',
    'buttons' => true,
    'pageLength' => 10,
    'searchPlaceholder' => 'Search records...',
])

@push('scripts')
    <script>
        $(function() {
            const table = $('#{{ $tableId }}').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ $route }}',
                responsive: true,
                searching: true,
                lengthChange: true,
                dom: '<"d-flex justify-content-between align-items-center mb-3"l{{ $buttons ? 'B' : '' }}f>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                pageLength: {{ $pageLength }},
                @if ($buttons)
                    buttons: [{
                            extend: 'excel',
                            className: 'btn btn-sm btn-success px-3 border-0 shadow-sm rounded-start-pill',
                            text: '<i class="bi bi-file-earmark-excel me-1"></i> Excel',
                            exportOptions: {
                                columns: ':visible:not(:last-child)'
                            }
                        },
                        {
                            extend: 'pdf',
                            className: 'btn btn-sm btn-danger px-3 border-0 shadow-sm mx-1',
                            text: '<i class="bi bi-file-earmark-pdf me-1"></i> PDF',
                            exportOptions: {
                                columns: ':visible:not(:last-child)'
                            }
                        },
                        {
                            extend: 'print',
                            className: 'btn btn-sm btn-dark px-3 border-0 shadow-sm rounded-end-pill',
                            text: '<i class="bi bi-printer me-1"></i> Print',
                            exportOptions: {
                                columns: ':visible:not(:last-child)'
                            }
                        }
                    ],
                @endif
                columns: @json($columns),
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "{{ $searchPlaceholder }}",
                    paginate: {
                        next: '<i class="bi bi-chevron-right"></i>',
                        previous: '<i class="bi bi-chevron-left"></i>'
                    }
                }
            });

            // Theme-friendly styling for generated elements
            $('.dataTables_filter input').addClass('form-control shadow-sm mx-1');
            $('.dataTables_length select').addClass('form-select shadow-sm mx-1');
        });
    </script>
@endpush
