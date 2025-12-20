<?php

namespace App\Actions\Admin\User;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class DeleteUserAction
{
    /**
     * Execute the action to delete a user.
     * Includes safety checks to prevent self-deletion.
     */
    public function execute(User $user): bool
    {
        if ($user->id === Auth::id()) {
            throw new Exception("Security Alert: You cannot delete your own account.");
        }

        // Add additional checks here (e.g., preventing deletion of super admin)
        if ($user->email === 'admin@drms.pk') {
            throw new Exception("System Error: The primary administrator account cannot be deleted.");
        }

        return $user->delete();
    }
}
