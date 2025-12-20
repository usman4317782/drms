<div class="d-flex">
    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-icon btn-light-primary me-2" title="Edit User">
        <i class="bi bi-pencil"></i>
    </a>

    @if ($user->email !== 'admin@drms.pk' && $user->id !== auth()->id())
        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
            onsubmit="return confirm('Security Check: Are you sure you want to delete this user? This action is irreversible.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-icon btn-light-danger" title="Delete User">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    @endif
</div>

<style>
    .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }

    .btn-light-primary {
        background-color: #e7f1ff;
        color: #0d6efd;
        border: none;
    }

    .btn-light-primary:hover {
        background-color: #0d6efd;
        color: white;
    }

    .btn-light-danger {
        background-color: #fceaea;
        color: #dc3545;
        border: none;
    }

    .btn-light-danger:hover {
        background-color: #dc3545;
        color: white;
    }
</style>
