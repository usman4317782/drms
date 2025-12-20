<?php

namespace App\Policies;

use App\Models\Camp;
use App\Models\User;

class CampPolicy
{
    public function manage(User $user, Camp $camp): bool
    {
        return $user->role === 'camp_manager'
            && $camp->manager_id === $user->id;
    }
}
