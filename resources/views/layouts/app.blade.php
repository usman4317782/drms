<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'DRMS'))</title>

    <!--begin::Fonts-->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!--end::Fonts-->

    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" />
    <!--end::Third Party Plugin(OverlayScrollbars)-->

    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" />
    <!--end::Third Party Plugin(Bootstrap Icons)-->

    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.css') }}" />
    <!--end::Required Plugin(AdminLTE)-->

    <!--begin::Custom Styles-->
    @stack('styles')
    <!--end::Custom Styles-->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <!-- DataTables Buttons -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').each(function() {
                $(this).select2({
                    theme: 'bootstrap-5',
                    placeholder: $(this).data('placeholder') || 'Select an option',
                    allowClear: !$(this).prop('required'),
                    width: '100%'
                });
            });
        });

        /**
         * Standardized AJAX Alert Helper
         */
        function showAlert(type, message) {
            const icon = type === 'success' ? 'bi-check-circle-fill' :
                type === 'danger' ? 'bi-exclamation-octagon-fill' :
                type === 'warning' ? 'bi-exclamation-triangle-fill' : 'bi-info-circle-fill';

            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi ${icon} fs-5 me-2"></i>
                        <div>${message}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            $('#ajax-alert-container').html(alertHtml);

            // Auto-hide after 5 seconds for success, keep errors visible
            if (type === 'success') {
                setTimeout(() => {
                    const alertElement = document.querySelector('#ajax-alert-container .alert');
                    if (alertElement) {
                        const bsAlert = bootstrap.Alert.getOrCreateInstance(alertElement);
                        if (bsAlert) bsAlert.close();
                    }
                }, 5000);
            }
        }
    </script>


</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">

        <!--begin::Header (Navbar)-->
        @include('layouts.partials.navbar')
        <!--end::Header-->

        <!--begin::Sidebar-->
        @include('layouts.partials.sidebar')
        <!--end::Sidebar-->

        <!--begin::App Main-->
        <main class="app-main pt-3">
            <div class="container-fluid">
                @include('layouts.partials.alerts')
                <div id="ajax-alert-container"></div>
            </div>

            <!--begin::App Content-->
            @yield('content')
            <!--end::App Content-->
        </main>
        <!--end::App Main-->

        <!--begin::Footer-->
        <footer class="app-footer">
            <div class="float-end d-none d-sm-inline">{{ config('adminlte.site_version', 'v1.0.0') }}</div>
            <strong>
                Copyright &copy; {{ date('Y') }}
                <a href="#" class="text-decoration-none">{{ config('adminlte.site_name', 'DRMS') }}</a>.
            </strong>
            All rights reserved.
        </footer>
        <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->

    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js">
    </script>
    <!--end::Third Party Plugin(OverlayScrollbars)-->

    <!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)-->

    <!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <!--end::Required Plugin(Bootstrap 5)-->

    <!--begin::Required Plugin(AdminLTE)-->
    <script src="{{ asset('adminlte/js/adminlte.js') }}"></script>
    <!--end::Required Plugin(AdminLTE)-->

    <!--begin::OverlayScrollbars Configuration-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };

        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined") {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
    <!--end::OverlayScrollbars Configuration-->

    <!--begin::Custom Scripts-->
    @stack('scripts')
    <!--end::Custom Scripts-->
</body>

</html>
