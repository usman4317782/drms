@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Camp: {{ $camp->name }}</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('manager.camps.index') }}" class="btn btn-outline-secondary">
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
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Camp Details</h3>
                        </div>
                        <form method="POST" action="{{ route('manager.camps.update', $camp) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <!-- Location -->
                                <x-form.input name="location" label="Location" :value="$camp->location"
                                    placeholder="Enter location" required />

                                <div class="row">
                                    <!-- Capacity -->
                                    <div class="col-md-6">
                                        <x-form.input type="number" name="capacity" label="Capacity" :value="$camp->capacity"
                                            min="1" required />
                                    </div>

                                    <!-- Current Occupancy -->
                                    <div class="col-md-6">
                                        <x-form.input type="number" name="current_occupancy" label="Current Occupancy"
                                            :value="$camp->current_occupancy" min="0" :max="$camp->capacity" :disabled="$camp->status === 'closed'"
                                            :helperText="$camp->status === 'closed' ? 'Locked while closed.' : null" />
                                    </div>
                                </div>

                                <!-- Status -->
                                <x-form.select name="status" label="Status" :options="['active' => 'Active', 'full' => 'Full', 'closed' => 'Closed']" :selected="$camp->status" required />

                                <!-- Facilities -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold d-block">Available Facilities</label>
                                    <div class="row">
                                        @foreach (config('camp.facilities', []) as $facility)
                                            <div class="col-md-4">
                                                <x-form.checkbox name="facilities[{{ $facility }}]" :label="ucwords(str_replace('_', ' ', $facility))"
                                                    :checked="$camp->facilities[$facility] ?? false" value="1" />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light text-end">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-save me-1"></i> Update Camp
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
