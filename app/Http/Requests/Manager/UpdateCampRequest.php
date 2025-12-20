<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCampRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->camp->manager_id === auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'location'           => 'required|string|max:255',
            'capacity'           => 'required|integer|min:1',
            'current_occupancy'  => 'required|integer|min:0|max:' . $this->capacity,
            'status'             => 'required|in:active,full,closed',
            'facilities'         => 'nullable|array',
        ];
    }
}
