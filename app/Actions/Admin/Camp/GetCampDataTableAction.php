<?php

namespace App\Actions\Admin\Camp;

use App\Models\Camp;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GetCampDataTableAction
{
    /**
     * Execute the action to get the DataTable response for camps.
     */
    public function execute(Request $request)
    {
        $query = Camp::with('manager')->select('camps.*');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('name', function ($camp) {
                return view('admin.camps.partials._name', compact('camp'))->render();
            })
            ->editColumn('location', function ($camp) {
                return '<div class="small fw-bold">' . e($camp->district) . '</div>' .
                    '<div class="text-muted small">' . e($camp->location) . '</div>';
            })
            ->editColumn('manager', function ($camp) {
                return $camp->manager
                    ? '<div class="fw-bold">' . e($camp->manager->name) . '</div>'
                    : '<x-ui.badge context="danger">Unassigned</x-ui.badge>';
            })
            ->editColumn('facilities', function ($camp) {
                return view('admin.camps.partials._facilities', compact('camp'))->render();
            })
            ->editColumn('status', function ($camp) {
                return view('admin.camps.partials._status', compact('camp'))->render();
            })
            ->addColumn('actions', function ($camp) {
                return view('admin.camps.partials._actions', compact('camp'))->render();
            })
            ->filterColumn('manager', function ($query, $keyword) {
                $query->whereHas('manager', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->rawColumns(['name', 'location', 'manager', 'facilities', 'status', 'actions'])
            ->make(true);
    }
}
