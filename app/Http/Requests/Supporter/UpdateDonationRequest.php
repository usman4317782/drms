<?php

namespace App\Http\Requests\Supporter;

use App\Enums\DonationType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDonationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('donation'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['sometimes', 'required', Rule::enum(DonationType::class)],
            'description' => ['sometimes', 'required', 'string', 'max:1000'],
            'camp_id' => ['nullable', 'exists:camps,id'],
            'amount' => [
                'required_if:type,' . DonationType::CASH->value,
                'nullable',
                'numeric',
                'min:0.01'
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
}
