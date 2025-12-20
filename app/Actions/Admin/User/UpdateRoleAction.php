<?php

namespace App\Actions\Admin\User;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class UpdateRoleAction
{
    /**
     * Update user roles with historical tracking.
     * @param string[] $newRoleSlugs
     * @param string[] $pool If provided, only roles within this pool will be managed (revoked/added).
     */
    public function execute(User $user, array $newRoleSlugs, array $pool = []): void
    {
        DB::transaction(function () use ($user, $newRoleSlugs, $pool) {
            $currentActiveRoles = $user->activeRoles;
            $currentSlugs = $currentActiveRoles->pluck('slug')->toArray();

            // 1. Roles to revoke 
            // If pool is provided, we only revoke roles that are IN the pool but NOT in newRoleSlugs.
            // This prevents revoking roles like 'supporter' if they aren't in the management pool.
            $toRevoke = !empty($pool)
                ? array_intersect($currentSlugs, array_diff($pool, $newRoleSlugs))
                : array_diff($currentSlugs, $newRoleSlugs);

            foreach ($toRevoke as $slug) {
                $user->revokeRole($slug);
            }

            // 2. Roles to add (in new, not in current active)
            $toAdd = array_diff($newRoleSlugs, $currentSlugs);
            foreach ($toAdd as $slug) {
                $user->assignRole($slug);
            }
        });
    }
}
