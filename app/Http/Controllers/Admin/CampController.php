<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\DTOs\CampData;
use App\Models\User;
use App\Actions\Admin\Camp\GetCampDataTableAction;
use App\Actions\Admin\Camp\CreateCampAction;
use App\Actions\Admin\Camp\UpdateCampAction;
use App\Actions\Admin\Camp\DeleteCampAction;
use App\Http\Requests\StoreCampRequest;
use App\Http\Requests\UpdateCampRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CampController extends Controller
{
    /**
     * Display a listing of the camps.
     */
    public function index(Request $request, GetCampDataTableAction $getDataTableAction)
    {
        if ($request->ajax()) {
            return $getDataTableAction->execute($request);
        }

        return view('admin.camps.index');
    }

    /**
     * Show the form for creating a new camp.
     */
    public function create(): View
    {
        return view('admin.camps.create', [
            'managers'        => User::whereHas('roles', fn($q) => $q->where('slug', 'camp_manager'))
                ->where('status', 'active')
                ->get(['users.id', 'users.name']),
            'facilityOptions' => config('camp.facilities'),
        ]);
    }

    /**
     * Store a newly created camp in storage.
     */
    public function store(StoreCampRequest $request, CreateCampAction $createAction): RedirectResponse
    {
        $createAction->execute(CampData::fromArray($request->validated()));

        return redirect()
            ->route('admin.camps.index')
            ->with('success', 'Camp created successfully.');
    }

    /**
     * Show the form for editing the specified camp.
     */
    public function edit(Camp $camp): View
    {
        return view('admin.camps.edit', [
            'camp'            => $camp,
            'managers'        => User::whereHas('roles', fn($q) => $q->where('slug', 'camp_manager'))
                ->where('status', 'active')
                ->get(['users.id', 'users.name']),
            'facilityOptions' => config('camp.facilities'),
        ]);
    }

    /**
     * Update the specified camp in storage.
     */
    public function update(UpdateCampRequest $request, Camp $camp, UpdateCampAction $updateAction): RedirectResponse
    {
        $updateAction->execute($camp, CampData::fromArray($request->validated()));

        return redirect()
            ->route('admin.camps.index')
            ->with('success', 'Camp updated successfully.');
    }

    /**
     * Remove the specified camp from storage.
     */
    public function destroy(Camp $camp, DeleteCampAction $deleteAction): RedirectResponse
    {
        $deleteAction->execute($camp);

        return redirect()
            ->route('admin.camps.index')
            ->with('success', 'Camp deleted successfully.');
    }
}
