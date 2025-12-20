@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="m-0 text-dark fw-bold">Edit User Context</h3>
                    <p class="text-muted small mb-0">Modifying profile for: <span
                            class="text-primary fw-bold">{{ $user->name }}</span></p>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
                        <i class="bi bi-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.users.partials._form')
            </form>
        </div>
    </div>
@endsection
