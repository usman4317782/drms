<section>
    <!-- Header: Clean and professional description -->
    <header class="mb-4">
        <h2 class="h5 text-dark fw-bold">
            {{ __('Secure Your Account') }}
        </h2>
        <p class="text-muted small">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <!-- Success Message Area -->
        @if (session('status') === 'password-updated')
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <i class="bi bi-shield-check me-2"></i>
                <strong>Success!</strong> Your password has been changed securely.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- Current Password -->
        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">
                {{ __('Current Password') }}
            </label>
            <input type="password" id="update_password_current_password" name="current_password"
                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                autocomplete="current-password">

            <!-- Error Message -->
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- New Password -->
        <div class="mb-3">
            <label for="update_password_password" class="form-label">
                {{ __('New Password') }}
            </label>
            <input type="password" id="update_password_password" name="password"
                class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                autocomplete="new-password">

            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">
                {{ __('Confirm Password') }}
            </label>
            <input type="password" id="update_password_password_confirmation" name="password_confirmation"
                class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                autocomplete="new-password">

            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Save Button -->
        <div class="mt-4">
            <button type="submit" class="btn btn-warning px-4 text-dark fw-bold">
                {{ __('Update Password') }}
            </button>
        </div>


    </form>
</section>
