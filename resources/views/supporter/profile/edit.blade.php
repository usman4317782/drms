@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="m-0 text-dark fw-bold">My Supporter Profile</h3>
                    <p class="text-muted small mb-0">Manage your skills, availability, and intended role (Donor/Volunteer).
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <form action="{{ route('supporter.profile.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="row">
                    <div class="col-md-8">
                        <x-ui.card title="Supporter Profile Details" type="primary" :outline="true">
                            <div class="row">
                                <div class="col-md-12">
                                    <x-form.textarea label="My Skills" name="skills" :value="$user->supporterProfile->skills ?? ''"
                                        placeholder="What skills can you offer? (e.g. First Aid, Teaching, Logistics)"
                                        rows="4" />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <x-form.textarea label="My Availability" name="availability" :value="$user->supporterProfile->availability ?? ''"
                                        placeholder="When are you available? (e.g. Weekends, Weekdays after 5pm)"
                                        rows="4" />
                                </div>
                            </div>
                        </x-ui.card>
                    </div>

                    <div class="col-md-4">
                        <x-ui.card title="Intent & Roles" type="warning" :outline="true">
                            <p class="text-muted small mb-3">
                                Select how you intend to support the mission. You can be both a Donor and a Volunteer
                                simultaneously.
                            </p>

                            <div class="mb-3">
                                @php
                                    $activeSlugs = $user->activeRoles->pluck('slug')->toArray();
                                @endphp
                                @foreach ($roles as $role)
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="roles[]"
                                            value="{{ $role->slug }}" id="role_{{ $role->slug }}"
                                            {{ in_array($role->slug, $activeSlugs) ? 'checked' : '' }}>
                                        <label class="form-check-label h6 mb-0" for="role_{{ $role->slug }}">
                                            I want to be a <strong>{{ $role->name }}</strong>
                                        </label>
                                        <p class="text-muted smaller mb-0 ms-4 mt-1">
                                            {{ $role->description ?? 'Support our cause as a ' . strtolower($role->name) }}
                                        </p>
                                    </div>
                                @endforeach
                                @error('roles')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                    Update My Profile
                                </button>
                            </div>
                        </x-ui.card>

                        <x-ui.card title="Account Summary" type="secondary" outline class="mt-4">
                            <ul class="list-unstyled mb-0 small text-muted">
                                <li class="mb-2 d-flex justify-content-between">
                                    <span>Member Since:</span>
                                    <span class="text-dark">{{ $user->created_at->format('M Y') }}</span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    <span>Status:</span>
                                    <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'danger' }} px-2">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </li>
                            </ul>
                        </x-ui.card>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
