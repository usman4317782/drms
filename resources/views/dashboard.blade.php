@extends('layouts.app')

@section('title', 'Dashboard | ' . config('adminlte.site_name', 'DRMS'))

@section('content')
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content Header-->

    <!--begin::App Content-->
    <div class="app-content">
        <div class="container-fluid">

            <!--begin::Welcome Card-->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show">
                        <h5><i class="bi bi-check-circle-fill me-2"></i>Welcome Back, {{ Auth::user()->name }}!</h5>
                        <p class="mb-0">You're successfully logged in to the Disaster Relief Resource Management System.
                        </p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <!--end::Welcome Card-->

            <!--begin::Statistics Cards Row-->
            <div class="row">
                <!-- Card 1: Total Resources -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3>150</h3>
                            <p>Total Resources</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <a href="#" class="small-box-footer link-light">
                            More info <i class="bi bi-arrow-right-circle-fill"></i>
                        </a>
                    </div>
                </div>

                <!-- Card 2: Active Camps -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>12</h3>
                            <p>Active Camps</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-houses"></i>
                        </div>
                        <a href="#" class="small-box-footer link-light">
                            More info <i class="bi bi-arrow-right-circle-fill"></i>
                        </a>
                    </div>
                </div>

                <!-- Card 3: Total Supporters -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3>44</h3>
                            <p>Total Supporters</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <a href="#" class="small-box-footer link-dark">
                            More info <i class="bi bi-arrow-right-circle-fill"></i>
                        </a>
                    </div>
                </div>

                <!-- Card 4: Pending Requests -->
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3>8</h3>
                            <p>Pending Requests</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <a href="#" class="small-box-footer link-light">
                            More info <i class="bi bi-arrow-right-circle-fill"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!--end::Statistics Cards Row-->

            <!--begin::Charts Row-->
            <div class="row">
                <!-- Chart 1: Resource Distribution -->
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Resource Distribution</h3>
                                <a href="#">View Report</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="position-relative mb-4">
                                <!-- Chart placeholder - Add Chart.js or similar later -->
                                <div class="text-center py-5 bg-light rounded">
                                    <i class="bi bi-bar-chart text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-2">Chart: Resource distribution across camps</p>
                                    <small class="text-muted">Connect your chart library here</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart 2: Monthly Donations -->
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Monthly Donations</h3>
                                <a href="#">View Report</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="position-relative mb-4">
                                <!-- Chart placeholder - Add Chart.js or similar later -->
                                <div class="text-center py-5 bg-light rounded">
                                    <i class="bi bi-graph-up text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-2">Chart: Monthly donation trends</p>
                                    <small class="text-muted">Connect your chart library here</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Charts Row-->

            <!--begin::Recent Activity-->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recent Activity</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                    <i class="bi bi-dash-lg"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-box-seam text-primary me-2"></i>
                                            <strong>New resource added:</strong> Medical Supplies - Camp A
                                        </div>
                                        <small class="text-muted">2 hours ago</small>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-person-plus text-success me-2"></i>
                                            <strong>New supporter registered:</strong> John Doe
                                        </div>
                                        <small class="text-muted">5 hours ago</small>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                                            <strong>Request pending:</strong> Water supply needed at Camp B
                                        </div>
                                        <small class="text-muted">1 day ago</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer clearfix">
                            <a href="#" class="btn btn-sm btn-primary float-end">View All Activity</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Recent Activity-->

        </div>
    </div>
    <!--end::App Content-->
@endsection
