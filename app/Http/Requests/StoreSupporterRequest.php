<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSupporterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone'        => ['nullable', 'string', 'max:20'],
            'status'       => ['required', 'string', 'in:active,inactive,banned'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
            'roles'        => ['required', 'array'],
            'roles.*'      => [Rule::in(['supporter', 'donor', 'volunteer'])],
            'skills'       => ['nullable', 'string'],
            'availability' => ['nullable', 'string'],
        ];
    }
}
