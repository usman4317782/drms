<?php

namespace App\Actions\Admin\User;

use App\DTOs\UserData;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateUserAction
{
    /**
     * Execute the action to create a new user.
     */
    public function execute(UserData $userData): User
    {
        return DB::transaction(function () use ($userData) {
            $user = User::create($userData->toArray());
            $user->assignRole($userData->role);
            return $user;
        });
    }
}
