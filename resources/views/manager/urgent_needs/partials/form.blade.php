@php
    $readOnly = isset($urgentNeed) && $urgentNeed->status === 'fulfilled';
@endphp

<div class="row">
    <!-- Camp -->
    <div class="col-md-6">
        <x-form.select name="camp_id" label="Camp" :options="$camps->pluck('name', 'id')->toArray()" :selected="$urgentNeed->camp_id ?? null" required :disabled="$readOnly" />
        @if ($readOnly)
            <input type="hidden" name="camp_id" value="{{ $urgentNeed->camp_id }}">
        @endif
    </div>

    <!-- Category -->
    <div class="col-md-6">
        <x-form.select name="category" label="Category" :options="[
            'food' => 'Food',
            'water' => 'Water',
            'medicine' => 'Medicine',
            'shelter' => 'Shelter',
            'other' => 'Other',
        ]" :selected="$urgentNeed->category ?? null" required :disabled="$readOnly" />
        @if ($readOnly)
            <input type="hidden" name="category" value="{{ $urgentNeed->category }}">
        @endif
    </div>
</div>

<div class="row">
    <!-- Quantity -->
    <div class="col-md-6">
        <x-form.input type="number" name="quantity" label="Quantity" :value="$urgentNeed->quantity ?? null" min="1"
            placeholder="e.g. 100" required :disabled="$readOnly" />
        @if ($readOnly)
            <input type="hidden" name="quantity" value="{{ $urgentNeed->quantity }}">
        @endif
    </div>

    <!-- Priority -->
    <div class="col-md-6">
        <x-form.select name="priority" label="Priority" :options="['low' => 'Low', 'medium' => 'Medium', 'high' => 'High']" :selected="$urgentNeed->priority ?? 'medium'" required
            :disabled="$readOnly" />
        @if ($readOnly)
            <input type="hidden" name="priority" value="{{ $urgentNeed->priority }}">
        @endif
    </div>
</div>

<!-- Description -->
<x-form.textarea name="description" label="Description / Notes" :value="$urgentNeed->description ?? null" rows="3"
    placeholder="Provide details about the urgent need..." :disabled="$readOnly" />
@if ($readOnly)
    <input type="hidden" name="description" value="{{ $urgentNeed->description }}">
@endif
