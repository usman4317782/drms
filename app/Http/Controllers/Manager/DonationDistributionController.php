<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Camp;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DonationDistributionController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display donations allocated to the manager's camps.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $campIds = \App\Models\Camp::where('manager_id', $request->user()->id)->pluck('id');
            $query = Donation::whereIn('camp_id', $campIds)
                ->with('supporter');

            return \Yajra\DataTables\Facades\DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('supporter_name', fn($donation) => $donation->supporter->name)
                ->editColumn('type', fn($donation) => $donation->type->label())
                ->editColumn('status', fn($donation) => '<span class="badge bg-' . $donation->status->color() . '">' . $donation->status->label() . '</span>')
                ->addColumn('details', function ($donation) {
                    if ($donation->type->value === 'cash') {
                        return 'Amount: ' . number_format($donation->amount, 2);
                    }
                    return $donation->quantity . ' ' . $donation->unit;
                })
                ->addColumn('actions', function ($donation) {
                    $options = '';
                    $statuses = ['stored', 'allocated', 'distributed'];
                    foreach ($statuses as $status) {
                        $selected = $donation->status->value === $status ? 'selected' : '';
                        $options .= "<option value='{$status}' {$selected}>" . ucfirst($status) . "</option>";
                    }
                    return '<select onchange="updateStatus(' . $donation->id . ', this.value)" class="form-select form-select-sm">' . $options . '</select>';
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }

        return view('manager.donations.index');
    }

    /**
     * Update distribution status.
     */
    public function updateStatus(Request $request, Donation $donation)
    {
        $this->authorize('transitionStatus', $donation);

        $request->validate([
            'status' => 'required|string|in:stored,allocated,distributed'
        ]);

        $donation->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Status updated successfully.',
            'donation' => $donation
        ]);
    }
}
