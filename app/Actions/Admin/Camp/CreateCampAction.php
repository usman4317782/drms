<?php

namespace App\Actions\Admin\Camp;

use App\DTOs\CampData;
use App\Models\Camp;
use Illuminate\Support\Facades\DB;

class CreateCampAction
{
    /**
     * Execute the action to create a new camp.
     */
    public function execute(CampData $campData): Camp
    {
        return DB::transaction(function () use ($campData) {
            return Camp::create($campData->toArray());
        });
    }
}
