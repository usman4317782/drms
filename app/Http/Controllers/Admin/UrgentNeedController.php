<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\UrgentNeed\DeleteUrgentNeedAction;
use App\Actions\Admin\UrgentNeed\UpdateUrgentNeedAction;
use App\DTOs\UrgentNeedData;
use App\Http\Controllers\Controller;
use App\Models\UrgentNeed;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UrgentNeedController extends Controller
{
    public function __construct(
        protected UpdateUrgentNeedAction $updateAction,
        protected DeleteUrgentNeedAction $deleteAction
    ) {}

    /**
     * List all urgent needs
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = UrgentNeed::with(['camp.manager']);

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('camp', fn($n) => e($n->camp->name))
                ->addColumn(
                    'manager',
                    fn($n) =>
                    $n->camp->manager
                        ? e($n->camp->manager->name)
                        : '<span class="text-danger">Unassigned</span>'
                )
                ->editColumn(
                    'priority',
                    fn($n) =>
                    view('components.ui.badge', [
                        'context' => $n->priority_color,
                        'slot' => ucfirst($n->priority)
                    ])->render()
                )
                ->editColumn(
                    'status',
                    fn($n) =>
                    view('components.ui.badge', [
                        'context' => $n->status_color,
                        'slot' => ucfirst($n->status)
                    ])->render()
                )
                ->addColumn('actions', function ($n) {
                    $editUrl = route('admin.urgent-needs.edit', $n);
                    $deleteUrl = route('admin.urgent-needs.destroy', $n);
                    $csrf = csrf_token();
                    $method = method_field('DELETE');

                    return "
                        <div class='btn-group'>
                            <a href='{$editUrl}' class='btn btn-sm btn-primary'>
                                <i class='bi bi-pencil'></i>
                            </a>
                            <form action='{$deleteUrl}' method='POST' class='d-inline' 
                                  onsubmit='return confirm(\"Are you sure you want to delete this record?\")'>
                                <input type='hidden' name='_token' value='{$csrf}'>
                                {$method}
                                <button type='submit' class='btn btn-sm btn-danger'>
                                    <i class='bi bi-trash'></i>
                                </button>
                            </form>
                        </div>
                    ";
                })
                ->rawColumns(['priority', 'status', 'manager', 'actions'])
                ->make(true);
        }

        return view('admin.urgent_needs.index');
    }

    /**
     * Edit urgent need (status/priority)
     */
    public function edit(UrgentNeed $urgentNeed)
    {
        return view('admin.urgent_needs.edit', compact('urgentNeed'));
    }

    /**
     * Update urgent need
     */
    public function update(Request $request, UrgentNeed $urgentNeed)
    {
        $validated = $request->validate([
            'priority' => 'required|in:low,medium,high',
            'status'   => 'required|in:pending,fulfilled',
        ]);

        $this->updateAction->execute($urgentNeed, UrgentNeedData::fromArray($validated));

        return redirect()
            ->route('admin.urgent-needs.index')
            ->with('success', 'Urgent need updated successfully.');
    }

    /**
     * Delete
     */
    public function destroy(UrgentNeed $urgentNeed)
    {
        $this->deleteAction->execute($urgentNeed);

        return back()->with('success', 'Urgent need deleted successfully.');
    }
}
