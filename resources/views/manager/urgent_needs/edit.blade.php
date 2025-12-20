@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Urgent Need</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('manager.urgent-needs.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    @if ($urgentNeed->status === 'fulfilled')
                        <div class="alert alert-success shadow-sm border-0 d-flex align-items-center mb-4">
                            <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                            <div>
                                <strong>Fulfilled!</strong> This urgent need has been fulfilled and is now read-only.
                            </div>
                        </div>
                    @endif

                    <div
                        class="card card-outline {{ $urgentNeed->status === 'fulfilled' ? 'card-success' : 'card-danger' }} shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Urgent Need Details</h3>
                        </div>
                        <form method="POST" action="{{ route('manager.urgent-needs.update', $urgentNeed) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                @include('manager.urgent_needs.partials.form')
                            </div>
                            <div class="card-footer bg-light text-end">
                                @if ($urgentNeed->status !== 'fulfilled')
                                    <button type="submit" class="btn btn-danger px-4">
                                        <i class="bi bi-save me-1"></i> Update Need
                                    </button>
                                @else
                                    <span class="text-muted italic">ReadOnly - Fulfilled</span>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
