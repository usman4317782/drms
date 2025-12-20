@extends('layouts.app')

@section('content')
    <div class="app-content">
        <div class="container-fluid text-end mt-3 mb-3">
            <a href="{{ route('admin.camps.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="container-fluid">
            <form action="{{ route('admin.camps.update', $camp) }}" method="POST">
                @csrf
                @method('PUT')

                @include('admin.camps.partials._form')

                <x-ui.card class="mt-4 bg-light border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="small text-muted">
                            <i class="bi bi-clock-history me-1"></i> Last updated: {{ $camp->updated_at->diffForHumans() }}
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success px-5 shadow-sm">
                                <i class="bi bi-save me-1"></i> Update Camp
                            </button>
                        </div>
                    </div>
                </x-ui.card>
            </form>
        </div>
    </div>
@endsection
