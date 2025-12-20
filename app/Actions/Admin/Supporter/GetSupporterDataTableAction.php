<?php

namespace App\Actions\Admin\Supporter;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GetSupporterDataTableAction
{
    /**
     * Get supporters for DataTables.
     */
    public function execute(Request $request)
    {
        $query = User::whereHas('roles', function ($q) {
            $q->whereIn('slug', ['supporter', 'donor', 'volunteer']);
        })->with(['activeRoles', 'supporterProfile']);

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('roles_list', function ($user) {
                return view('admin.supporters.partials._roles', compact('user'))->render();
            })
            ->editColumn('status', function ($user) {
                return view('admin.supporters.partials._status', compact('user'))->render();
            })
            ->addColumn('actions', function ($user) {
                return view('admin.supporters.partials._actions', compact('user'))->render();
            })
            ->rawColumns(['roles_list', 'status', 'actions'])
            ->make(true);
    }
}
