<div class="d-flex align-items-center">
    <a href="{{ route('admin.camps.edit', $camp) }}" class="btn btn-sm btn-outline-primary me-2 shadow-sm"
        title="Edit Camp">
        <i class="bi bi-pencil-square"></i>
    </a>

    <form action="{{ route('admin.camps.destroy', $camp) }}" method="POST" class="d-inline-block delete-form"
        onsubmit="return confirm('Are you sure you want to delete this camp? This action cannot be undone.')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm" title="Delete Camp">
            <i class="bi bi-trash"></i>
        </button>
    </form>
</div>
