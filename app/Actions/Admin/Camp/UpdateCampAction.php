<?php

namespace App\Actions\Admin\Camp;

use App\DTOs\CampData;
use App\Models\Camp;
use Illuminate\Support\Facades\DB;

class UpdateCampAction
{
    /**
     * Execute the action to update an existing camp.
     */
    public function execute(Camp $camp, CampData $campData): bool
    {
        return DB::transaction(function () use ($camp, $campData) {
            return $camp->update($campData->toArray());
        });
    }
}
