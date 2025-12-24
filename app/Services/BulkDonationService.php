<?php

namespace App\Services;

use App\DTOs\DonationData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BulkDonationService
{
    public function __construct(
        private DonationService $donationService
    ) {}

    /**
     * Create multiple donations atomically.
     * 
     * @param Collection<int, DonationData> $donations
     * @return Collection
     */
    public function createBulk(Collection $donations): Collection
    {
        return DB::transaction(function () use ($donations) {
            return $donations->map(function (DonationData $data) {
                return $this->donationService->createDonation($data);
            });
        });
    }
}
