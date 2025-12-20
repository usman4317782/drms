@extends('layouts.app')

@section('title', 'Edit Urgent Need')

@section('content')
    <x-ui.page-header title="Edit Urgent Need"
        description="Review and update the priority or fulfillment status of a camp request." icon="bi bi-pencil-square">
        <x-slot:actions>
            <x-ui.button variant="secondary" size="sm" icon="bi bi-arrow-left"
                onclick="window.location.href='{{ route('admin.urgent-needs.index') }}'">
                Back to List
            </x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <x-ui.card title="Request Details" type="primary" :outline="true">
                        <form method="POST" action="{{ route('admin.urgent-needs.update', $urgentNeed) }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <x-form.input label="Camp Location" :value="$urgentNeed->camp->name" disabled />
                                </div>
                                <div class="col-md-6">
                                    <x-form.input label="Category" :value="ucfirst($urgentNeed->category)" disabled />
                                </div>
                            </div>

                            <x-form.textarea label="Description" :value="$urgentNeed->description" disabled />

                            <hr class="my-4">

                            <div class="row">
                                <div class="col-md-6">
                                    <x-form.select label="Urgency Priority" name="priority" :selected="$urgentNeed->priority"
                                        :options="[
                                            'low' => 'Low',
                                            'medium' => 'Medium',
                                            'high' => 'High',
                                        ]" required />
                                </div>
                                <div class="col-md-6">
                                    <x-form.select label="Request Status" name="status" :selected="$urgentNeed->status" :options="[
                                        'pending' => 'Pending',
                                        'fulfilled' => 'Fulfilled',
                                    ]"
                                        required />
                                </div>
                            </div>

                            <div class="mt-4 text-end">
                                <x-ui.button type="submit" variant="primary" icon="bi bi-check-lg" class="px-4">
                                    Update Request
                                </x-ui.button>
                            </div>
                        </form>
                    </x-ui.card>
                </div>
            </div>
        </div>
    </div>
@endsection
