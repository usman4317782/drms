@extends('layouts.app')

@section('title', 'Dashboard | ' . config('adminlte.site_name', 'DRMS'))

@section('content')
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ ucfirst($role) }} Dashboard</h3>
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

            <!--begin::Welcome Message-->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-check-fill fs-3 me-3"></i>
                            <div>
                                <h5 class="mb-1">Greetings, {{ Auth::user()->name }}!</h5>
                                <p class="mb-0 small opacity-75">You are logged in as
                                    <strong>{{ str_replace('_', ' ', ucfirst($role)) }}</strong>.</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <!--end::Welcome Message-->

            {{-- Role-Based Dashboard Views --}}
            @if ($role === 'admin')
                <x-dashboard.admin-view :data="$data" />
            @elseif($role === 'manager')
                <x-dashboard.manager-view :data="$data" />
            @elseif($role === 'supporter')
                <x-dashboard.supporter-view :data="$data" />
            @else
                <div class="alert alert-info">
                    You have not been assigned a specific dashboard view. Please contact the administrator.
                </div>
            @endif

        </div>
    </div>
    <!--end::App Content-->
@endsection
