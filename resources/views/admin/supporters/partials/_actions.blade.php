<div class="d-flex">
    <a href="{{ route('admin.supporters.edit', $user->id) }}" class="btn btn-sm btn-icon btn-light-primary me-2"
        title="Edit Supporter">
        <i class="bi bi-pencil"></i>
    </a>

    <form action="{{ route('admin.supporters.destroy', $user->id) }}" method="POST"
        onsubmit="return confirm('Security Check: Are you sure you want to delete this supporter? This action is irreversible.')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-icon btn-light-danger" title="Delete Supporter">
            <i class="bi bi-trash"></i>
        </button>
    </form>
</div>

@once
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
            color: white !important;
        }

        .btn-light-danger {
            background-color: #fceaea;
            color: #dc3545;
            border: none;
        }

        .btn-light-danger:hover {
            background-color: #dc3545;
            color: white !important;
        }
    </style>
@endonce
