<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('camp_manager');
    }

    public function rules(): array
    {
        return [
            'camp_id' => ['required', 'exists:camps,id'],
            'assigned_to' => [
                'nullable',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $user = \App\Models\User::find($value);
                        if ($user && !$user->hasRole(['supporter', 'volunteer', 'donor'])) {
                            $fail('The selected user must be a Supporter, Volunteer or Donor.');
                        }
                    }
                },
            ],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'required_skills' => ['nullable', 'string'],
            'priority' => ['required', Rule::in(['low', 'medium', 'high', 'urgent'])],
            'due_date' => ['nullable', 'date', 'after_or_equal:today'],
            'status' => ['required', Rule::in(['pending', 'in_progress', 'completed', 'cancelled'])],
        ];
    }
}
