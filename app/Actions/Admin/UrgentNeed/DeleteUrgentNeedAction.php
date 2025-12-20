<?php

namespace App\Actions\Admin\UrgentNeed;

use App\Models\UrgentNeed;
use Illuminate\Support\Facades\DB;

class DeleteUrgentNeedAction
{
    /**
     * Execute the action to delete an existing urgent need.
     */
    public function execute(UrgentNeed $urgentNeed): bool
    {
        return DB::transaction(function () use ($urgentNeed) {
            return $urgentNeed->delete();
        });
    }
}
