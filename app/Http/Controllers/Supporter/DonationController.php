<?php

namespace App\Http\Controllers\Supporter;

use App\DTOs\DonationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Supporter\BulkStoreDonationRequest;
use App\Http\Requests\Supporter\StoreDonationRequest;
use App\Http\Requests\Supporter\UpdateDonationRequest;
use App\Models\Donation;
use App\Services\BulkDonationService;
use App\Services\DonationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DonationController extends Controller
{
    use AuthorizesRequests;
    public function __construct(
        private DonationService $donationService,
        private BulkDonationService $bulkDonationService
    ) {}

    /**
     * Display a listing of the supporter's donations.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Donation::where('supporter_id', $request->user()->id)
                ->with('camp');

            return \Yajra\DataTables\Facades\DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('type', fn($donation) => $donation->type->label())
                ->editColumn('status', fn($donation) => '<span class="badge bg-' . $donation->status->color() . '">' . $donation->status->label() . '</span>')
                ->addColumn('camp_name', fn($donation) => $donation->camp->name ?? 'N/A')
                ->addColumn('details', function ($donation) {
                    if ($donation->type->value === 'cash') {
                        return 'Amount: ' . number_format($donation->amount, 2);
                    }
                    return $donation->quantity . ' ' . $donation->unit;
                })
                ->addColumn('actions', function ($donation) {
                    $actions = '';
                    if (in_array($donation->status->value, ['submitted', 'stored'])) {
                        $actions .= '<button onclick="deleteDonation(' . $donation->id . ')" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>';
                    }
                    return $actions;
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }

        $camps = \App\Models\Camp::select('id', 'name')->orderBy('name')->get();
        $totalDonations = Donation::where('supporter_id', $request->user()->id)->count();

        return view('supporter.donations.index', compact('camps', 'totalDonations'));
    }

    /**
     * Show the bulk donation creation page.
     */
    public function bulkCreate()
    {
        $camps = \App\Models\Camp::select('id', 'name')->orderBy('name')->get();
        return view('supporter.donations.bulk', compact('camps'));
    }

    /**
     * Store a newly created donation.
     */
    public function store(StoreDonationRequest $request): JsonResponse
    {
        $dto = DonationData::fromArray($request->validated(), $request->user()->id);
        $donation = $this->donationService->createDonation($dto);

        return response()->json([
            'message' => 'Donation submitted successfully.',
            'donation' => $donation
        ], 201);
    }

    /**
     * Store multiple donations at once.
     */
    public function bulkStore(BulkStoreDonationRequest $request): JsonResponse
    {
        $donations = collect($request->validated()['donations'])
            ->map(fn($data) => DonationData::fromArray($data, $request->user()->id));

        $created = $this->bulkDonationService->createBulk($donations);

        return response()->json([
            'message' => 'Bulk donations submitted successfully.',
            'count' => $created->count()
        ], 201);
    }

    /**
     * Update the specified donation.
     */
    public function update(UpdateDonationRequest $request, Donation $donation): JsonResponse
    {
        $dto = DonationData::fromArray($request->validated(), $request->user()->id);
        $updated = $this->donationService->updateDonation($donation, $dto);

        return response()->json([
            'message' => 'Donation updated successfully.',
            'donation' => $updated
        ]);
    }

    /**
     * Remove the specified donation.
     */
    public function destroy(Request $request, Donation $donation): JsonResponse
    {
        $this->authorize('delete', $donation);

        $this->donationService->deleteDonation($donation);

        return response()->json([
            'message' => 'Donation deleted successfully.'
        ]);
    }
}
