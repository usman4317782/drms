@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="m-0 text-dark fw-bold">Create New Supporter</h3>
                    <p class="text-muted small mb-0">Onboard a new donor or volunteer to the system.</p>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.supporters.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
                        <i class="bi bi-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <form action="{{ route('admin.supporters.store') }}" method="POST">
                @csrf
                @include('admin.supporters.partials._form')
            </form>
        </div>
    </div>
@endsection
