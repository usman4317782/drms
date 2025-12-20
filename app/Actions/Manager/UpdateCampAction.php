<?php

namespace App\Actions\Manager;

use App\Models\Camp;

class UpdateCampAction
{
    /**
     * Execute the action to update a camp.
     */
    public function execute(Camp $camp, array $data): void
    {
        // Auto-sync status based on occupancy
        $status = $data['status'];
        if ($data['current_occupancy'] >= $data['capacity']) {
            $status = 'full';
        }

        $camp->update([
            'location'          => $data['location'],
            'capacity'          => $data['capacity'],
            'current_occupancy' => $data['current_occupancy'],
            'status'            => $status,
            'facilities'        => $data['facilities'] ?? [],
        ]);
    }
}
