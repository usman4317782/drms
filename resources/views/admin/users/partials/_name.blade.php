<div class="d-flex align-items-center">
    <div>
        <div class="fw-bold">{{ $user->name }}</div>
        <div class="small text-muted">{{ $user->email }}</div>
    </div>
    @if ($isAdmin)
        <span class="badge bg-danger ms-2" title="System Administrator">
            <i class="bi bi-shield-lock"></i>
        </span>
    @endif
</div>
