@extends('layouts.app')

@section('title', 'Blank Page | ' . config('adminlte.site_name', 'DRMS'))

@section('content')
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Blank Page</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Blank Page</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content Header-->

    <!--begin::App Content-->
    <div class="app-content">
        <div class="container-fluid">

            <!--begin::Row-->
            <div class="row">
                <div class="col-md-12">

                    <!--begin::Card-->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Blank Page Template</h3>
                        </div>
                        <div class="card-body">
                            <p>This is a blank page template. You can use this as a starter for creating new pages.</p>
                            <p>Simply copy this file and modify the content section to build your own pages.</p>

                            <h5 class="mt-4">How to use this template:</h5>
                            <ol>
                                <li>Copy <code>blank.blade.php</code> to create a new page</li>
                                <li>Update the <code>
                                    @section('title')
                                    </code> directive</li>
                                <li>Modify the breadcrumb navigation</li>
                                <li>Add your content between the <code>&lt;div class="app-content"&gt;</code> tags</li>
                                <li>Optionally add custom CSS via <code>
                                        @push('styles')
                                        </code> directive</li>
                                    <li>Optionally add custom JavaScript via <code>
                                            @push('scripts')
                                            </code> directive</li>
                                    </ol>

                                    <div class="alert alert-info mt-4">
                                        <h5><i class="bi bi-info-circle"></i> Tip:</h5>
                                        All component files are located in the <code>resources/views/layouts/partials</code> folder
                                        for easy customization.
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
                                </div>
                            </div>
                            <!--end::Card-->

                        </div>
                    </div>
                    <!--end::Row-->

                </div>
            </div>
            <!--end::App Content-->
        @endsection
