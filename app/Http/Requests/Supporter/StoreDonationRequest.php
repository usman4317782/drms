<?php

namespace App\Http\Requests\Supporter;

use App\Enums\DonationType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDonationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Donation::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::enum(DonationType::class)],
            'description' => ['required', 'string', 'max:1000'],
            'camp_id' => ['nullable', 'exists:camps,id'],
            'amount' => [
                'required_if:type,' . DonationType::CASH->value,
                'nullable',
                'numeric',
                'min:0.01',
                'max:99999999.99'
            ],
            'quantity' => [
                'required_if:type,' . DonationType::IN_KIND->value,
                'nullable',
                'integer',
                'min:1'
            ],
            'unit' => [
                'required_if:type,' . DonationType::IN_KIND->value,
                'nullable',
                'string',
                'max:50'
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'amount.required_if' => 'The amount is required for cash donations.',
            'quantity.required_if' => 'The quantity is required for in-kind donations.',
            'unit.required_if' => 'The unit (e.g., kg, pieces) is required for in-kind donations.',
        ];
    }
}
