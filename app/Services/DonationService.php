<?php

namespace App\Services;

use App\DTOs\DonationData;
use App\Enums\DonationStatus;
use App\Models\Donation;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class DonationService
{
    /**
     * Create a new donation.
     */
    public function createDonation(DonationData $data): Donation
    {
        return Donation::create($data->toArray());
    }

    /**
     * Update an existing donation.
     */
    public function updateDonation(Donation $donation, DonationData $data): Donation
    {
        // Check if status allows update (business rule)
        if (!in_array($donation->status, [DonationStatus::SUBMITTED, DonationStatus::STORED])) {
            throw new InvalidArgumentException("Cannot update a donation that is already {$donation->status->value}.");
        }

        $donation->update($data->toArray());

        return $donation;
    }

    /**
     * Delete a donation.
     */
    public function deleteDonation(Donation $donation): bool
    {
        if ($donation->status !== DonationStatus::SUBMITTED) {
            throw new InvalidArgumentException("Only submitted donations can be deleted.");
        }

        return $donation->delete();
    }

    /**
     * Transition the status of a donation.
     */
    public function transitionStatus(Donation $donation, DonationStatus $newStatus): Donation
    {
        $this->validateTransition($donation->status, $newStatus);

        $donation->update(['status' => $newStatus]);

        return $donation;
    }

    /**
     * Validate status transition logic.
     */
    private function validateTransition(DonationStatus $current, DonationStatus $next): void
    {
        $allowed = match ($current) {
            DonationStatus::SUBMITTED => [DonationStatus::STORED, DonationStatus::ALLOCATED],
            DonationStatus::STORED => [DonationStatus::ALLOCATED],
            DonationStatus::ALLOCATED => [DonationStatus::DISTRIBUTED],
            DonationStatus::DISTRIBUTED => [], // Terminal state
        };

        if (!in_array($next, $allowed)) {
            throw new InvalidArgumentException("Illegal status transition from {$current->value} to {$next->value}.");
        }
    }
}
