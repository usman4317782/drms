<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\DTOs\UserData;
use App\Actions\Admin\User\GetUserDataTableAction;
use App\Actions\Admin\User\CreateUserAction;
use App\Actions\Admin\User\UpdateUserAction;
use App\Actions\Admin\User\DeleteUserAction;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request, GetUserDataTableAction $getDataTableAction)
    {
        if ($request->ajax()) {
            return $getDataTableAction->execute($request);
        }

        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(StoreUserRequest $request, CreateUserAction $createUserAction): RedirectResponse
    {
        $userData = UserData::fromArray($request->validated());
        $createUserAction->execute($userData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User account has been created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, User $user, UpdateUserAction $updateUserAction): RedirectResponse
    {
        $userData = UserData::fromArray($request->validated());
        $updateUserAction->execute($user, $userData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User account has been updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user, DeleteUserAction $deleteUserAction): RedirectResponse
    {
        try {
            $deleteUserAction->execute($user);
            return redirect()->route('admin.users.index')
                ->with('success', 'User account has been deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
