<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Camp;

class StoreUrgentNeedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Camp::where('id', $this->camp_id)
            ->where('manager_id', auth()->id())
            ->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'camp_id'     => 'required|exists:camps,id',
            'category'    => 'required|string|max:100',
            'quantity'    => 'nullable|integer|min:1',
            'priority'    => 'required|in:low,medium,high',
            'description' => 'nullable|string',
        ];
    }
}
