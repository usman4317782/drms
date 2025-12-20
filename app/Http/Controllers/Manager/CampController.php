<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\Manager\UpdateCampRequest;
use App\Actions\Manager\UpdateCampAction;

class CampController extends Controller
{
    /**
     * Show only camps assigned to the logged-in manager
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Camp::query()
                ->where('manager_id', auth()->id())
                ->select([
                    'id',
                    'name',
                    'location',
                    'capacity',
                    'current_occupancy',
                    'status',
                    'facilities',
                ]);

            return DataTables::of($query)
                ->addIndexColumn()

                ->editColumn('status', fn($c) => ucfirst($c->status))

                ->editColumn('facilities', function ($c) {
                    if (!$c->facilities) {
                        return '-';
                    }

                    return collect($c->facilities)
                        ->filter()
                        ->map(
                            fn($v, $k) =>
                            '<span class="badge bg-success me-1">'
                                . ucwords(str_replace('_', ' ', $k)) .
                                '</span>'
                        )
                        ->implode('');
                })

                ->addColumn('actions', fn($c) => '
                <a href="' . route('manager.camps.edit', $c) . '"
                   class="btn btn-sm btn-primary">
                    <i class="bi bi-pencil"></i>
                </a>
            ')

                /*
            |--------------------------------------------------------------------------
            | 🔥 SEARCH FIX (INCLUDING FACILITIES)
            |--------------------------------------------------------------------------
            */
                ->filterColumn(
                    'name',
                    fn($q, $k) =>
                    $q->where('name', 'like', "%{$k}%")
                )

                ->filterColumn(
                    'location',
                    fn($q, $k) =>
                    $q->where('location', 'like', "%{$k}%")
                )

                ->filterColumn(
                    'capacity',
                    fn($q, $k) =>
                    $q->where('capacity', 'like', "%{$k}%")
                )

                ->filterColumn(
                    'status',
                    fn($q, $k) =>
                    $q->where('status', 'like', "%{$k}%")
                )

                ->filterColumn('facilities', function ($q, $k) {
                    $q->whereJsonContains('facilities', [$k => true]);
                })

                ->filterColumn(
                    'current_occupancy',
                    fn($q, $k) =>
                    $q->where('current_occupancy', 'like', "%{$k}%")
                )


                ->rawColumns(['actions', 'facilities'])
                ->make(true);
        }

        return view('manager.camps.index');
    }



    /**
     * Show form to edit assigned camp
     */
    public function edit(Camp $camp)
    {
        return view('manager.camps.edit', compact('camp'));
    }

    /**
     * Update camp details
     */
    public function update(UpdateCampRequest $request, Camp $camp, UpdateCampAction $action)
    {
        $action->execute($camp, $request->validated());

        return redirect()
            ->route('manager.camps.index')
            ->with('success', 'Camp updated successfully.');
    }
}
