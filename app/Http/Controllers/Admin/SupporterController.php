<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\DTOs\SupporterData;
use App\Actions\Admin\Supporter\GetSupporterDataTableAction;
use App\Actions\Admin\Supporter\CreateSupporterAction;
use App\Actions\Admin\Supporter\UpdateSupporterAction;
use App\Actions\Admin\User\DeleteUserAction;
use App\Http\Requests\StoreSupporterRequest;
use App\Http\Requests\UpdateSupporterRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SupporterController extends Controller
{
    /**
     * Display a listing of the supporters.
     */
    public function index(Request $request, GetSupporterDataTableAction $getDataTableAction)
    {
        if ($request->ajax()) {
            return $getDataTableAction->execute($request);
        }

        return view('admin.supporters.index');
    }

    /**
     * Show the form for creating a new supporter.
     */
    public function create(): View
    {
        $roles = Role::whereIn('slug', ['supporter', 'donor', 'volunteer'])->get();
        return view('admin.supporters.create', compact('roles'));
    }

    /**
     * Store a newly created supporter in storage.
     */
    public function store(StoreSupporterRequest $request, CreateSupporterAction $createSupporterAction): RedirectResponse
    {
        $data = SupporterData::fromArray($request->validated());
        $createSupporterAction->execute($data);

        return redirect()->route('admin.supporters.index')
            ->with('success', 'Supporter has been created successfully.');
    }

    /**
     * Show the form for editing the specified supporter.
     */
    public function edit(User $supporter): View
    {
        $roles = Role::whereIn('slug', ['supporter', 'donor', 'volunteer'])->get();
        // Ensure supporter has profile
        $supporter->load(['activeRoles', 'supporterProfile']);

        return view('admin.supporters.edit', compact('supporter', 'roles'));
    }

    /**
     * Update the specified supporter in storage.
     */
    public function update(UpdateSupporterRequest $request, User $supporter, UpdateSupporterAction $updateSupporterAction): RedirectResponse
    {
        $data = SupporterData::fromArray($request->validated());
        $updateSupporterAction->execute($supporter, $data);

        return redirect()->route('admin.supporters.index')
            ->with('success', 'Supporter has been updated successfully.');
    }

    /**
     * Remove the specified supporter from storage.
     */
    public function destroy(User $supporter, DeleteUserAction $deleteUserAction): RedirectResponse
    {
        try {
            $deleteUserAction->execute($supporter);
            return redirect()->route('admin.supporters.index')
                ->with('success', 'Supporter has been deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
