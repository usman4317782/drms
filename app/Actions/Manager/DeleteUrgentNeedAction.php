<?php

namespace App\Actions\Manager;

use App\Models\UrgentNeed;
use Illuminate\Validation\ValidationException;

class DeleteUrgentNeedAction
{
    /**
     * Execute the action to delete an urgent need.
     */
    public function execute(UrgentNeed $urgentNeed): void
    {
        if ($urgentNeed->status === 'fulfilled') {
            throw ValidationException::withMessages([
                'status' => 'Fulfilled urgent needs cannot be deleted.',
            ]);
        }

        $urgentNeed->delete();
    }
}
