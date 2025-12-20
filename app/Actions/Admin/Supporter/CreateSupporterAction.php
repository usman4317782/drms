<?php

namespace App\Actions\Admin\Supporter;

use App\Models\User;
use App\DTOs\SupporterData;
use Illuminate\Support\Facades\DB;

class CreateSupporterAction
{
    /**
     * Create a new supporter and their profile.
     */
    public function execute(SupporterData $data): User
    {
        return DB::transaction(function () use ($data) {
            // 1. Create User account
            $user = User::create($data->toUserArray());

            // 2. Assign Roles (Many-to-Many)
            foreach ($data->roles as $roleSlug) {
                $user->assignRole($roleSlug);
            }

            // 3. Create Supporter Profile
            $user->supporterProfile()->create($data->toProfileArray());

            return $user;
        });
    }
}
