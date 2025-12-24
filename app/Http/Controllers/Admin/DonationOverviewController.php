<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationOverviewController extends Controller
{
    /**
     * Display a listing of all donations (Read-only for Admin).
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Donation::with(['supporter', 'camp']);

            return \Yajra\DataTables\Facades\DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('supporter_name', fn($donation) => $donation->supporter->name)
                ->addColumn('camp_name', fn($donation) => $donation->camp->name ?? 'N/A')
                ->editColumn('type', fn($donation) => $donation->type->label())
                ->editColumn('status', fn($donation) => '<span class="badge bg-' . $donation->status->color() . '">' . $donation->status->label() . '</span>')
                ->addColumn('details', function ($donation) {
                    if ($donation->type->value === 'cash') {
                        return 'Amount: ' . number_format($donation->amount, 2);
                    }
                    return $donation->quantity . ' ' . $donation->unit;
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        return view('admin.donations.index');
    }

    /**
     * Display the specified donation details.
     */
    public function show(Donation $donation)
    {
        return view('admin.donations.show', compact('donation'));
    }
}
