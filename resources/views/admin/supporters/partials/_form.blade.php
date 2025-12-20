<div class="row">
    <!-- Left Column: Primary Information -->
    <div class="col-md-8">
        <x-ui.card title="Personal Information" type="primary" :outline="true">
            <div class="row">
                <div class="col-md-6">
                    <x-form.input label="Full Name" name="name" :value="$supporter->name ?? ''" required placeholder="John Doe" />
                </div>
                <div class="col-md-6">
                    <x-form.input label="Email Address" name="email" type="email" :value="$supporter->email ?? ''" required
                        placeholder="john@example.com" />
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <x-form.input label="Phone Number" name="phone" :value="$supporter->phone ?? ''" placeholder="03xx-xxxxxxx" />
                </div>
            </div>
        </x-ui.card>

        <x-ui.card title="Supporter Profile" type="info" :outline="true" class="mt-4">
            <div class="row">
                <div class="col-md-12">
                    <x-form.textarea label="Skills" name="skills" :value="$supporter->supporterProfile->skills ?? ''"
                        placeholder="e.g. First Aid, Logistics, Medical Nursing..." rows="3" />
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <x-form.textarea label="Availability" name="availability" :value="$supporter->supporterProfile->availability ?? ''"
                        placeholder="e.g. Weekends only, 24/7, After 6 PM..." rows="3" />
                </div>
            </div>
        </x-ui.card>

        <x-ui.card title="Security" type="danger" :outline="true" class="mt-4">
            @if (isset($supporter))
                <div class="alert alert-info py-2 small mb-3">
                    <i class="bi bi-info-circle me-1"></i> Leave password fields empty to keep the current password.
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <x-form.input label="{{ isset($supporter) ? 'New Password' : 'Password' }}" name="password"
                        type="password" :required="!isset($supporter)" />
                </div>
                <div class="col-md-6">
                    <x-form.input label="Confirm Password" name="password_confirmation" type="password"
                        :required="!isset($supporter)" />
                </div>
            </div>
        </x-ui.card>
    </div>

    <!-- Right Column: Settings & Actions -->
    <div class="col-md-4">
        <x-ui.card title="Role Assignments" type="warning" :outline="true">
            <div class="mb-3">
                <label class="form-label d-block fw-bold mb-2">Select Active Roles</label>
                @php
                    $activeSlugs = isset($supporter)
                        ? $supporter->activeRoles->pluck('slug')->toArray()
                        : ['supporter'];
                @endphp
                @foreach ($roles as $role)
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->slug }}"
                            id="role_{{ $role->slug }}" {{ in_array($role->slug, $activeSlugs) ? 'checked' : '' }}>
                        <label class="form-check-label" for="role_{{ $role->slug }}">
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
                @error('roles')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <x-form.select label="Account Status" name="status" :selected="$supporter->status ?? 'active'" required :options="[
                'active' => 'Active',
                'inactive' => 'Inactive',
                'banned' => 'Banned',
            ]" />

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary shadow-sm fw-bold">
                    <i class="bi bi-check2-circle me-1"></i>
                    {{ isset($supporter) ? 'Update Supporter' : 'Create Supporter' }}
                </button>
                <a href="{{ route('admin.supporters.index') }}" class="btn btn-light shadow-sm">
                    Cancel
                </a>
            </div>
        </x-ui.card>

        @if (isset($supporter))
            <x-ui.card title="System Metadata" type="secondary" outline class="mt-4">
                <ul class="list-unstyled mb-0 small text-muted">
                    <li class="mb-2 d-flex justify-content-between">
                        <span>Created:</span>
                        <span class="text-dark">{{ $supporter->created_at->format('M d, Y') }}</span>
                    </li>
                    <li class="mb-2 d-flex justify-content-between">
                        <span>Last Updated:</span>
                        <span class="text-dark">{{ $supporter->updated_at->diffForHumans() }}</span>
                    </li>
                </ul>
            </x-ui.card>
        @endif
    </div>
</div>
