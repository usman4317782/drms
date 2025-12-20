<?php

namespace App\Http\Controllers\Supporter;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\DTOs\SupporterData;
use App\Actions\Admin\Supporter\UpdateSupporterAction;
use App\Http\Requests\SupporterProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the supporter profile edit form.
     */
    public function edit(): View
    {
        $user = Auth::user();
        $user->load(['activeRoles', 'supporterProfile']);
        $roles = Role::whereIn('slug', ['donor', 'volunteer'])->get();

        return view('supporter.profile.edit', compact('user', 'roles'));
    }

    /**
     * Update the supporter profile.
     */
    public function update(SupporterProfileUpdateRequest $request, UpdateSupporterAction $updateAction): RedirectResponse
    {
        $user = Auth::user();

        // Prepare DTO (preserving fixed fields like status/email/phone for self-update)
        $data = new SupporterData(
            name: $user->name,
            email: $user->email,
            roles: $request->validated()['roles'],
            status: $user->status,
            phone: $user->phone,
            skills: $request->validated()['skills'],
            availability: $request->validated()['availability']
        );

        $updateAction->execute($user, $data, ['donor', 'volunteer']);

        return redirect()->route('supporter.profile.edit')
            ->with('success', 'Your profile has been updated successfully.');
    }
}
