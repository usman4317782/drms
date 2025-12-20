<div class="row">
    <!-- Left Column: Primary Information -->
    <div class="col-md-8">
        <x-ui.card title="Personal Information" type="primary" :outline="true">
            <div class="row">
                <div class="col-md-6">
                    <x-form.input label="Full Name" name="name" :value="$user->name ?? ''" required placeholder="John Doe" />
                </div>
                <div class="col-md-6">
                    <x-form.input label="Email Address" name="email" type="email" :value="$user->email ?? ''" required
                        placeholder="john@example.com" />
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <x-form.input label="Phone Number" name="phone" :value="$user->phone ?? ''" placeholder="03xx-xxxxxxx" />
                </div>
            </div>
        </x-ui.card>

        <x-ui.card title="Security" type="danger" :outline="true" class="mt-4">
            @if (isset($user))
                <div class="alert alert-info py-2 small mb-3">
                    <i class="bi bi-info-circle me-1"></i> Leave password fields empty to keep the current password.
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <x-form.input label="{{ isset($user) ? 'New Password' : 'Password' }}" name="password"
                        type="password" :required="!isset($user)" />
                </div>
                <div class="col-md-6">
                    <x-form.input label="Confirm Password" name="password_confirmation" type="password"
                        :required="!isset($user)" />
                </div>
            </div>
        </x-ui.card>
    </div>

    <!-- Right Column: Settings & Actions -->
    <div class="col-md-4">
        <x-ui.card title="Account Settings" type="warning" :outline="true">
            <x-form.select label="System Role" name="role" :selected="$user->role ?? ''" required :options="[
                'admin' => 'Administrator',
                'camp_manager' => 'Camp Manager',
                'field_staff' => 'Field Staff',
                'supporter' => 'Supporter',
            ]" />

            <x-form.select label="Account Status" name="status" :selected="$user->status ?? 'active'" required :options="[
                'active' => 'Active',
                'inactive' => 'Inactive',
                'banned' => 'Banned',
            ]" />

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary shadow-sm fw-bold">
                    <i class="bi bi-check2-circle me-1"></i> {{ isset($user) ? 'Update Account' : 'Create Account' }}
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-light shadow-sm">
                    Cancel
                </a>
            </div>
        </x-ui.card>

        @if (isset($user))
            <x-ui.card title="System Metadata" type="secondary" outline class="mt-4">
                <ul class="list-unstyled mb-0 small text-muted">
                    <li class="mb-2 d-flex justify-content-between">
                        <span>Created:</span>
                        <span class="text-dark">{{ $user->created_at->format('M d, Y') }}</span>
                    </li>
                    <li class="mb-2 d-flex justify-content-between">
                        <span>Last Updated:</span>
                        <span class="text-dark">{{ $user->updated_at->diffForHumans() }}</span>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span>User UUID:</span>
                        <code class="text-dark">{{ substr($user->id, 0, 8) }}...</code>
                    </li>
                </ul>
            </x-ui.card>
        @endif
    </div>
</div>
