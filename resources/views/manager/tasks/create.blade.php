@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Create Task</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('manager.tasks.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Task Configuration</h3>
                        </div>
                        <form method="POST" action="{{ route('manager.tasks.store') }}">
                            @csrf
                            <div class="card-body">
                                @include('manager.tasks.partials.form')
                            </div>
                            <div class="card-footer bg-light text-end">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-save me-1"></i> Create Task
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
