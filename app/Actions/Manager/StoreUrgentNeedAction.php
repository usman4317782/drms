<?php

namespace App\Actions\Manager;

use App\Models\UrgentNeed;

class StoreUrgentNeedAction
{
    /**
     * Execute the action to store a new urgent need.
     */
    public function execute(array $data): UrgentNeed
    {
        return UrgentNeed::create([
            'camp_id'     => $data['camp_id'],
            'category'    => $data['category'],
            'quantity'    => $data['quantity'],
            'priority'    => $data['priority'],
            'description' => $data['description'] ?? null,
            'status'      => 'pending',
        ]);
    }
}
