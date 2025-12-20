<?php

namespace App\Actions\Admin\Supporter;

use App\Models\User;
use App\DTOs\SupporterData;
use App\Actions\Admin\User\UpdateRoleAction;
use Illuminate\Support\Facades\DB;

class UpdateSupporterAction
{
    public function __construct(
        protected UpdateRoleAction $updateRoleAction
    ) {}

    /**
     * Update supporter account, roles, and profile.
     * @param string[] $rolePool If provided, only roles in this pool will be managed.
     */
    public function execute(User $user, SupporterData $data, array $rolePool = []): User
    {
        return DB::transaction(function () use ($user, $data, $rolePool) {
            // 1. Update User account
            $user->update($data->toUserArray());

            // 2. Update Roles with history tracking
            $this->updateRoleAction->execute($user, $data->roles, $rolePool);

            // 3. Update or Create Supporter Profile
            $user->supporterProfile()->updateOrCreate(
                ['user_id' => $user->id],
                $data->toProfileArray()
            );

            return $user->fresh();
        });
    }
}
