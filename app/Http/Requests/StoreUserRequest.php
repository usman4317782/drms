<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only Admins can perform this action
        return $this->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'role'     => ['required', Rule::in(['admin', 'camp_manager', 'field_staff', 'supporter'])],
            'status'   => ['required', 'string', 'in:active,inactive,banned'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
