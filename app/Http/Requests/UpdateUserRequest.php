<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            // Ignore current user ID during unique check to allow updating own profile
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user)],
            'phone'    => ['nullable', 'string', 'max:20'],
            'role'     => ['required', Rule::in(['admin', 'camp_manager', 'field_staff', 'supporter'])],
            'status'   => ['required', 'string', 'in:active,inactive,banned'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'], // Nullable for updates
        ];
    }
}
