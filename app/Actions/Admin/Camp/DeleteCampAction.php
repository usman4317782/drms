<?php

namespace App\Actions\Admin\Camp;

use App\Models\Camp;
use Illuminate\Support\Facades\DB;

class DeleteCampAction
{
    /**
     * Execute the action to delete a camp.
     */
    public function execute(Camp $camp): bool
    {
        return DB::transaction(function () use ($camp) {
            // Additional safety checks can be added here
            return $camp->delete();
        });
    }
}
