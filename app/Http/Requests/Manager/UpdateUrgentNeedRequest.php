<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUrgentNeedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->urgent_need->camp->manager_id === auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'category'    => 'required|string|max:100',
            'quantity'    => 'required|integer|min:1',
            'priority'    => 'required|in:low,medium,high',
            'description' => 'nullable|string',
        ];
    }
}
