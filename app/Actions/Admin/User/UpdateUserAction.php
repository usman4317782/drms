<?php

namespace App\Actions\Admin\User;

use App\DTOs\UserData;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateUserAction
{
    /**
     * @param UpdateRoleAction $updateRoleAction
     */
    public function __construct(
        protected UpdateRoleAction $updateRoleAction
    ) {}

    /**
     * Execute the action to update an existing user.
     */
    public function execute(User $user, UserData $userData): bool
    {
        return DB::transaction(function () use ($user, $userData) {
            $this->updateRoleAction->execute($user, [$userData->role]);
            return $user->update($userData->toArray());
        });
    }
}
