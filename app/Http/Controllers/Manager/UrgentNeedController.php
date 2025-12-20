<?php


namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\UrgentNeed;
use App\Models\Camp;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\Manager\StoreUrgentNeedRequest;
use App\Http\Requests\Manager\UpdateUrgentNeedRequest;
use App\Actions\Manager\StoreUrgentNeedAction;
use App\Actions\Manager\UpdateUrgentNeedAction;
use App\Actions\Manager\DeleteUrgentNeedAction;

class UrgentNeedController extends Controller
{
    /**
     * List urgent needs (DataTable)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = UrgentNeed::with('camp')
                ->whereHas(
                    'camp',
                    fn($q) =>
                    $q->where('manager_id', auth()->id())
                );

            return DataTables::of($query)
                ->addIndexColumn()

                ->addColumn('camp', fn($n) => e($n->camp->name))

                ->editColumn(
                    'priority',
                    fn($n) =>
                    '<span class="badge bg-' . $n->priority_color . '">' . ucfirst($n->priority) . '</span>'
                )

                ->editColumn(
                    'status',
                    fn($n) =>
                    '<span class="badge bg-' . $n->status_color . '">' . ucfirst($n->status) . '</span>'
                )

                ->addColumn('actions', function ($n) {

                    if ($n->status === 'fulfilled') {
                        return '<span class="badge bg-success">Fulfilled</span>';
                    }

                    return '
                        <a href="' . route('manager.urgent-needs.edit', $n) . '"
                        class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <form action="' . route('manager.urgent-needs.destroy', $n) . '"
                            method="POST" class="d-inline"
                            onsubmit="return confirm(\'Delete this urgent need?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    ';
                })

                ->rawColumns(['priority', 'status', 'actions'])
                ->make(true);
        }

        return view('manager.urgent_needs.index');
    }

    /**
     * Create form
     */
    public function create()
    {
        $camps = Camp::where('manager_id', auth()->id())->get();

        return view('manager.urgent_needs.create', compact('camps'));
    }

    /**
     * Store
     */
    public function store(StoreUrgentNeedRequest $request, StoreUrgentNeedAction $action)
    {
        $action->execute($request->validated());

        return redirect()->route('manager.urgent-needs.index')
            ->with('success', 'Urgent need recorded successfully.');
    }

    /**
     * Edit
     */
    public function edit(UrgentNeed $urgentNeed)
    {
        $camps = Camp::where('manager_id', auth()->id())->get();

        return view('manager.urgent_needs.edit', compact('urgentNeed', 'camps'));
    }

    /**
     * Update
     */
    public function update(UpdateUrgentNeedRequest $request, UrgentNeed $urgentNeed, UpdateUrgentNeedAction $action)
    {
        $action->execute($urgentNeed, $request->validated());

        return redirect()
            ->route('manager.urgent-needs.index')
            ->with('success', 'Urgent need updated successfully.');
    }

    /**
     * Delete
     */
    public function destroy(UrgentNeed $urgentNeed, DeleteUrgentNeedAction $action)
    {
        $action->execute($urgentNeed);

        return back()->with('success', 'Urgent need deleted successfully.');
    }
}
