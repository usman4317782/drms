<?php

namespace App\Http\Requests\Supporter;

use App\Enums\DonationType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreDonationRequest extends FormRequest
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
            'donations' => ['required', 'array', 'min:1'],
            'donations.*.type' => ['required', Rule::enum(DonationType::class)],
            'donations.*.description' => ['required', 'string', 'max:1000'],
            'donations.*.camp_id' => ['nullable', 'exists:camps,id'],
            'donations.*.amount' => [
                'required_if:donations.*.type,' . DonationType::CASH->value,
                'nullable',
                'numeric',
                'min:0.01'
            ],
            'donations.*.quantity' => [
                'required_if:donations.*.type,' . DonationType::IN_KIND->value,
                'nullable',
                'integer',
                'min:1'
            ],
            'donations.*.unit' => [
                'required_if:donations.*.type,' . DonationType::IN_KIND->value,
                'nullable',
                'string',
                'max:50'
            ],
        ];
    }
}
