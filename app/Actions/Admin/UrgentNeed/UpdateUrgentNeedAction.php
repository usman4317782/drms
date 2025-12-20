<?php

namespace App\Actions\Admin\UrgentNeed;

use App\DTOs\UrgentNeedData;
use App\Models\UrgentNeed;
use Illuminate\Support\Facades\DB;

class UpdateUrgentNeedAction
{
    /**
     * Execute the action to update an existing urgent need.
     */
    public function execute(UrgentNeed $urgentNeed, UrgentNeedData $urgentNeedData): bool
    {
        return DB::transaction(function () use ($urgentNeed, $urgentNeedData) {
            return $urgentNeed->update($urgentNeedData->toArray());
        });
    }
}
