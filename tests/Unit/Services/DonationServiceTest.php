<?php

namespace Tests\Unit\Services;

use App\DTOs\DonationData;
use App\Enums\DonationStatus;
use App\Enums\DonationType;
use App\Models\Donation;
use App\Models\User;
use App\Services\DonationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use InvalidArgumentException;

class DonationServiceTest extends TestCase
{
    use RefreshDatabase;

    private DonationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DonationService();
    }

    public function test_can_create_donation()
    {
        $user = User::factory()->create();
        $dto = new DonationData(
            supporter_id: $user->id,
            type: DonationType::CASH,
            description: 'Test cash donation',
            amount: 100.00
        );

        $donation = $this->service->createDonation($dto);

        $this->assertInstanceOf(Donation::class, $donation);
        $this->assertEquals(100.00, $donation->amount);
        $this->assertEquals(DonationStatus::SUBMITTED, $donation->status);
    }

    public function test_cannot_transition_to_illegal_status()
    {
        $donation = Donation::factory()->create([
            'status' => DonationStatus::SUBMITTED
        ]);

        $this->expectException(InvalidArgumentException::class);
        $this->service->transitionStatus($donation, DonationStatus::DISTRIBUTED);
    }

    public function test_can_transition_to_allowed_status()
    {
        $donation = Donation::factory()->create([
            'status' => DonationStatus::SUBMITTED
        ]);

        $updated = $this->service->transitionStatus($donation, DonationStatus::STORED);

        $this->assertEquals(DonationStatus::STORED, $updated->status);
    }

    public function test_cannot_delete_stored_donation()
    {
        $donation = Donation::factory()->create([
            'status' => DonationStatus::STORED
        ]);

        $this->expectException(InvalidArgumentException::class);
        $this->service->deleteDonation($donation);
    }
}
