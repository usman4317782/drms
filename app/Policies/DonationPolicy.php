<?php

namespace App\Policies;

use App\Models\Donation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DonationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'camp_manager', 'supporter', 'donor', 'volunteer']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Donation $donation): bool
    {
        // Admins can see everything
        if ($user->hasRole('admin')) {
            return true;
        }

        // Supporters can see their own donations
        if ($user->hasRole(['supporter', 'donor', 'volunteer']) && $donation->supporter_id === $user->id) {
            return true;
        }

        // Managers can see donations allocated to their camp
        if ($user->hasRole('camp_manager') && $donation->camp_id) {
            return $user->id === $donation->camp->manager_id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only supporters can create donations
        return $user->hasRole(['supporter', 'donor', 'volunteer']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Donation $donation): bool
    {
        // Supporters can update their own donations if they aren't distributed yet
        if ($user->hasRole(['supporter', 'donor', 'volunteer']) && $donation->supporter_id === $user->id) {
            return in_array($donation->status->value, ['submitted', 'stored']);
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Donation $donation): bool
    {
        // Supporters can delete their own donations if they are still 'submitted'
        if ($user->hasRole(['supporter', 'donor', 'volunteer']) && $donation->supporter_id === $user->id) {
            return $donation->status->value === 'submitted';
        }

        return false;
    }

    /**
     * Determine whether the user can transition the status of a donation.
     */
    public function transitionStatus(User $user, Donation $donation): bool
    {
        // Admins can transition anything
        if ($user->hasRole('admin')) {
            return true;
        }

        // Managers can transition if it's allocated to their camp
        if ($user->hasRole('camp_manager') && $donation->camp_id) {
            return $user->id === $donation->camp->manager_id;
        }

        return false;
    }
}
