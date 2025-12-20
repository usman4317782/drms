<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'name'       => 'required|string|max:255',
            'district'   => 'required|string|max:255',
            'location'   => 'required|string',
            'capacity'   => 'required|integer|min:1',
            'status'     => 'required|in:active,full,closed',
            'manager_id' => 'nullable|exists:users,id',
            'facilities' => 'nullable|array',
        ];
    }
}
