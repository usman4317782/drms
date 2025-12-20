<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupporterProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole(['supporter', 'donor', 'volunteer']);
    }

    public function rules(): array
    {
        return [
            'skills'       => ['nullable', 'string'],
            'availability' => ['nullable', 'string'],
            'roles'        => ['required', 'array', 'min:1'],
            'roles.*'      => [Rule::in(['donor', 'volunteer'])],
        ];
    }
}
