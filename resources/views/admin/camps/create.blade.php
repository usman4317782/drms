@extends('layouts.app')

@section('content')
    <div class="app-content mt-3">
        <div class="container-fluid text-end mb-3">
            <a href="{{ route('admin.camps.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="container-fluid">
            <form action="{{ route('admin.camps.store') }}" method="POST">
                @csrf
                @include('admin.camps.partials._form')

                <div class="mt-4 text-end">
                    <button type="reset" class="btn btn-outline-secondary px-4 me-2">Reset</button>
                    <button type="submit" class="btn btn-primary px-5 shadow-sm">
                        <i class="bi bi-check2-circle me-1"></i> Create Camp
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
