<div class="row g-3">
    <div class="col-md-6">
        <x-form.select label="Select Camp" name="camp_id" required>
            <option value="">-- Select Camp --</option>
            @foreach ($camps as $camp)
                <option value="{{ $camp->id }}" @selected(old('camp_id', $task->camp_id ?? '') == $camp->id)>
                    {{ $camp->name }}
                </option>
            @endforeach
        </x-form.select>
    </div>

    <div class="col-md-6">
        <x-form.select label="Assign To (Optional Marketplace Task)" name="assigned_to">
            <option value="">-- Leave Unassigned (Marketplace) --</option>
            @foreach ($volunteers as $volunteer)
                <option value="{{ $volunteer->id }}" @selected(old('assigned_to', $task->assigned_to ?? '') == $volunteer->id)>
                    {{ $volunteer->name }} ({{ $volunteer->formatted_roles }})
                </option>
            @endforeach
        </x-form.select>
    </div>

    <div class="col-12">
        <x-form.input label="Task Title" name="title" :value="old('title', $task->title ?? '')" placeholder="Enter task title" required />
    </div>

    <div class="col-12">
        <x-form.input label="Required Skills (e.g., First Aid, Cooking)" name="required_skills" :value="old('required_skills', $task->required_skills ?? '')"
            placeholder="List skills separated by commas" />
    </div>

    <div class="col-12">
        <x-form.textarea label="Description" name="description"
            placeholder="Describe the task instructions...">{{ old('description', $task->description ?? '') }}</x-form.textarea>
    </div>

    <div class="col-md-4">
        <x-form.select label="Priority" name="priority" required>
            @foreach (['low', 'medium', 'high', 'urgent'] as $p)
                <option value="{{ $p }}" @selected(old('priority', $task->priority ?? 'medium') == $p)>
                    {{ ucfirst($p) }}
                </option>
            @endforeach
        </x-form.select>
    </div>

    <div class="col-md-4">
        <x-form.select label="Status" name="status">
            @foreach (['pending', 'in_progress', 'completed', 'cancelled'] as $s)
                <option value="{{ $s }}" @selected(old('status', $task->status ?? 'pending') == $s)>
                    {{ ucfirst($s) }}
                </option>
            @endforeach
        </x-form.select>
    </div>

    <div class="col-md-4">
        <x-form.input type="date" label="Due Date" name="due_date" :value="old('due_date', isset($task->due_date) ? $task->due_date->format('Y-m-d') : '')" />
    </div>
</div>
