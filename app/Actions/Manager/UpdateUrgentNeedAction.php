<?php

namespace App\Actions\Manager;

use App\Models\UrgentNeed;
use Illuminate\Validation\ValidationException;

class UpdateUrgentNeedAction
{
    /**
     * Execute the action to update an urgent need.
     */
    public function execute(UrgentNeed $urgentNeed, array $data): void
    {
        if ($urgentNeed->status === 'fulfilled') {
            throw ValidationException::withMessages([
                'status' => 'This urgent need is already fulfilled and cannot be updated.',
            ]);
        }

        $urgentNeed->update([
            'category'    => $data['category'],
            'quantity'    => $data['quantity'],
            'priority'    => $data['priority'],
            'description' => $data['description'] ?? $urgentNeed->description,
        ]);
    }
}
