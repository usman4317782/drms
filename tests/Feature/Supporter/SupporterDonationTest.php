<?php

namespace Tests\Feature\Supporter;

use App\Enums\DonationStatus;
use App\Enums\DonationType;
use App\Models\Donation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupporterDonationTest extends TestCase
{
    use RefreshDatabase;

    private User $supporter;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure roles exist
        $supporterRole = Role::firstOrCreate(['slug' => 'supporter'], [
            'name' => 'Supporter',
            'description' => 'Supporter Role'
        ]);

        $this->supporter = User::factory()->create();
        $this->supporter->roles()->attach($supporterRole->id, ['starts_at' => now()]);
    }

    public function test_supporter_can_view_donations_list()
    {
        $this->withoutExceptionHandling();
        Donation::factory()->count(3)->create([
            'supporter_id' => $this->supporter->id
        ]);

        $response = $this->actingAs($this->supporter)
            ->get(route('supporter.donations.index'));

        $response->assertStatus(200);
    }

    public function test_supporter_can_create_cash_donation()
    {
        $payload = [
            'type' => DonationType::CASH->value,
            'description' => 'Monthly supporting donation',
            'amount' => 150.50
        ];

        $response = $this->actingAs($this->supporter)
            ->post(route('supporter.donations.store'), $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('donations', [
            'supporter_id' => $this->supporter->id,
            'amount' => 150.50,
            'type' => DonationType::CASH->value
        ]);
    }

    public function test_supporter_can_create_bulk_donations()
    {
        $payload = [
            'donations' => [
                [
                    'type' => DonationType::CASH->value,
                    'description' => 'Cash part',
                    'amount' => 100
                ],
                [
                    'type' => DonationType::IN_KIND->value,
                    'description' => 'Blankets',
                    'quantity' => 10,
                    'unit' => 'pieces'
                ]
            ]
        ];

        $response = $this->actingAs($this->supporter)
            ->post(route('supporter.donations.bulk_store'), $payload);

        $response->assertStatus(201);
        $this->assertCount(2, Donation::where('supporter_id', $this->supporter->id)->get());
    }

    public function test_supporter_cannot_delete_distributed_donation()
    {
        $donation = Donation::factory()->create([
            'supporter_id' => $this->supporter->id,
            'status' => DonationStatus::DISTRIBUTED
        ]);

        $response = $this->actingAs($this->supporter)
            ->delete(route('supporter.donations.destroy', $donation));

        $response->assertStatus(403);
    }
}
