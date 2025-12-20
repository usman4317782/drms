<div class="row g-4">
    <div class="col-md-8">
        <x-ui.card :outline="true" class="h-100">
            <div class="row g-3">
                <div class="col-md-6">
                    <x-form.input name="name" label="Camp Name" placeholder="e.g. Hope Relief Camp A" :value="old('name', $camp->name ?? '')"
                        required />
                </div>
                <div class="col-md-6">
                    <x-form.input name="district" label="District" placeholder="e.g. Larkana" :value="old('district', $camp->district ?? '')"
                        required />
                </div>
                <div class="col-12">
                    <x-form.input name="location" label="Specific Location/Address"
                        placeholder="Detailed address or coordinates" :value="old('location', $camp->location ?? '')" required />
                </div>
                <div class="col-md-6">
                    <x-form.input type="number" name="capacity" label="Capacity (Persons)" :value="old('capacity', $camp->capacity ?? '')"
                        required />
                </div>
                <div class="col-md-6">
                    <x-form.select name="status" label="Current Status" :options="[
                        'active' => 'Active',
                        'full' => 'Full',
                        'closed' => 'Closed',
                    ]" :selected="old('status', $camp->status ?? 'active')" required />
                </div>
                <div class="col-12">
                    <x-form.select name="manager_id" label="Assign Camp Manager" :options="$managers->pluck('name', 'id')->toArray()" :selected="old('manager_id', $camp->manager_id ?? '')"
                        placeholder="Select a manager..." />
                </div>
            </div>
        </x-ui.card>
    </div>

    <div class="col-md-4">
        <x-ui.card type="info" :outline="true" title="Facilities Available">
            <div class="row g-2">
                @foreach ($facilityOptions as $key => $label)
                    <div class="col-12">
                        <div class="form-check form-switch p-3 border rounded shadow-sm hover-bg-light transition-all">
                            <input class="form-check-input ms-0" type="checkbox" name="facilities[{{ $key }}]"
                                value="1" id="facility_{{ $key }}"
                                {{ old("facilities.{$key}", isset($camp->facilities[$key]) && $camp->facilities[$key]) ? 'checked' : '' }}>
                            <label class="form-check-label ms-3 fw-medium cursor-pointer"
                                for="facility_{{ $key }}">
                                {{ $label }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 p-3 bg-light rounded border border-info small text-info">
                <i class="bi bi-info-circle me-1"></i> These facilities will be visible to supporters and staff.
            </div>
        </x-ui.card>
    </div>
</div>

<style>
    .hover-bg-light:hover {
        background-color: #f8f9fa;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .transition-all {
        transition: all 0.2s ease;
    }
</style>
