@extends('layouts.app')

@section('title', 'Profile Settings | ' . config('adminlte.site_name', 'DRMS'))

@section('content')
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Profile Settings</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content Header-->

    <!--begin::App Content-->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">

                <!-- Left Column: Profile Info & Password -->
                <div class="col-lg-8">

                    <!-- 1. Update Profile Information -->
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Profile Information</h3>
                        </div>
                        <div class="card-body">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <!-- 2. Update Password -->
                    <div class="card card-warning card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Update Password</h3>
                        </div>
                        <div class="card-body">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                <!-- Right Column: Delete Account -->
                <div class="col-lg-4">
                    <div class="card card-danger card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Danger Zone</h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Once your account is deleted, all of its resources and data will be
                                permanently deleted.</p>
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--end::App Content-->
@endsection
