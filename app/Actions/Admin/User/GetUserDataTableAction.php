<?php

namespace App\Actions\Admin\User;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GetUserDataTableAction
{
    /**
     * Execute the action to get the DataTable response for users.
     * This encapsulates all the custom rendering and logic for the users list.
     */
    public function execute(Request $request)
    {
        $query = User::query()->select(['id', 'name', 'email', 'role', 'status']);

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('name', function ($user) {
                $isAdmin = $user->email === 'admin@drms.pk';
                return view('admin.users.partials._name', compact('user', 'isAdmin'))->render();
            })
            ->editColumn('role', function ($user) {
                return view('admin.users.partials._role', compact('user'))->render();
            })
            ->editColumn('status', function ($user) {
                return view('admin.users.partials._status', compact('user'))->render();
            })
            ->addColumn('actions', function ($user) {
                return view('admin.users.partials._actions', compact('user'))->render();
            })
            ->rawColumns(['name', 'role', 'status', 'actions'])
            ->make(true);
    }
}
