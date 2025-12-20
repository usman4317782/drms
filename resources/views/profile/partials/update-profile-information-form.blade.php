<section>
    <header class="mb-3">
        <h2 class="h5 text-primary">
            {{ __('Profile Information') }}
        </h2>
        <p class="text-muted small">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>


    <!-- Verification Form (Hidden) -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Main Profile Update Form -->
    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <!-- Success Message Area (Placed below button for visibility) -->
        @if (session('status') === 'profile-updated')
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>Success!</strong> Your profile information has been updated.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Name Field -->
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', Auth::user()->name) }}" {{-- FIXED: Used Auth::user() --}} required autofocus
                autocomplete="name">

            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Field -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="email" id="email" name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', Auth::user()->email) }}" {{-- FIXED: Used Auth::user() --}} required autocomplete="username">

            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            {{-- Email Verification Logic --}}
            @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !Auth::user()->hasVerifiedEmail())
                <div class="alert alert-warning mt-2">
                    <p class="mb-1">
                        {{ __('Your email address is unverified.') }}
                    </p>
                    <button form="send-verification" class="btn btn-link p-0 align-baseline">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <div class="text-success mt-1 small">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Footer / Buttons -->
        <div class="d-flex align-items-center gap-3 mt-3">
            <button type="submit" class="btn btn-primary">
                {{ __('Save Changes') }}
            </button>
        </div>


    </form>
</section>
