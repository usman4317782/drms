<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\SupporterProfile;
use App\Actions\Admin\Supporter\CreateSupporterAction;
use App\Actions\Admin\Supporter\UpdateSupporterAction;
use App\DTOs\SupporterData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupporterRoleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure roles exist (using firstOrCreate to avoid duplicates from migration)
        collect(['admin', 'camp_manager', 'field_staff', 'supporter', 'donor', 'volunteer'])->each(function ($slug) {
            Role::firstOrCreate(['slug' => $slug], ['name' => ucfirst($slug)]);
        });
    }

    /** @test */
    public function it_can_create_a_supporter_with_multiple_roles_and_profile()
    {
        $dto = new SupporterData(
            name: 'Test Supporter',
            email: 'test@example.com',
            roles: ['donor', 'volunteer'],
            status: 'active',
            password: 'password123',
            skills: 'Medical',
            availability: 'Weekends'
        );

        $action = app(CreateSupporterAction::class);
        $user = $action->execute($dto);

        $this->assertEquals('Test Supporter', $user->name);
        $this->assertTrue($user->hasRole('donor'));
        $this->assertTrue($user->hasRole('volunteer'));
        $this->assertCount(2, $user->activeRoles);

        $this->assertDatabaseHas('supporter_profiles', [
            'user_id' => $user->id,
            'skills' => 'Medical',
            'availability' => 'Weekends'
        ]);
    }

    /** @test */
    public function it_tracks_role_history_when_roles_change()
    {
        $user = User::factory()->create();
        $user->assignRole('donor');

        $this->assertTrue($user->hasRole('donor'));
        $this->assertFalse($user->hasRole('volunteer'));

        $dto = new SupporterData(
            name: $user->name,
            email: $user->email,
            roles: ['volunteer'], // Switching from Donor to Volunteer
            status: 'active',
            skills: 'Logistics'
        );

        $action = app(UpdateSupporterAction::class);
        $action->execute($user, $dto);

        $user = $user->fresh();

        // New role should be active
        $this->assertTrue($user->hasRole('volunteer'));
        // Old role should be inactive (ends_at set)
        $this->assertFalse($user->hasRole('donor'));

        // Verify history in pivot table
        $this->assertDatabaseHas('role_user', [
            'user_id' => $user->id,
            'role_id' => Role::where('slug', 'donor')->first()->id,
        ]);

        $donorRole = $user->roles()->where('slug', 'donor')->first();
        $this->assertNotNull($donorRole->pivot->ends_at);
        $this->assertTrue($donorRole->pivot->ends_at <= now());
    }

    /** @test */
    public function middleware_permits_users_with_any_of_the_specified_roles()
    {
        $volunteer = User::factory()->create();
        $volunteer->assignRole('volunteer');

        $this->actingAs($volunteer)
            ->get(route('supporter.profile.edit'))
            ->assertOk();

        $donor = User::factory()->create();
        $donor->assignRole('donor');

        $this->actingAs($donor)
            ->get(route('supporter.profile.edit'))
            ->assertOk();

        $guest = User::factory()->create();
        // No role
        $this->actingAs($guest)
            ->get(route('supporter.profile.edit'))
            ->assertStatus(403);
    }
    /** @test */
    public function it_can_update_intent_and_multiple_roles_simultaneously_without_revoking_base_supporter_role()
    {
        // 1. Setup user with base 'supporter' role and 'donor' role
        $user = User::factory()->create();
        $user->assignRole('supporter');
        $user->assignRole('donor');

        $this->assertCount(2, $user->activeRoles);
        $this->assertTrue($user->hasRole('supporter'));
        $this->assertTrue($user->hasRole('donor'));
        $this->assertFalse($user->hasRole('volunteer'));

        // 2. Prepare payload to keep 'donor', add 'volunteer', and update skills/availability
        $payload = [
            'roles' => ['donor', 'volunteer'],
            'skills' => 'New Skills',
            'availability' => 'New Availability',
        ];

        // 3. Act
        $this->actingAs($user)
            ->patch(route('supporter.profile.update'), $payload)
            ->assertRedirect();

        $user = $user->fresh();
        $user->load(['activeRoles', 'supporterProfile']);

        // 4. Assert
        // Roles should be: supporter (preserved), donor (kept), volunteer (added)
        $this->assertCount(3, $user->activeRoles);
        $this->assertTrue($user->hasRole('supporter'), 'Base supporter role should be preserved');
        $this->assertTrue($user->hasRole('donor'), 'Donor role should be kept');
        $this->assertTrue($user->hasRole('volunteer'), 'Volunteer role should be added');

        // Intensity (Intent) fields should be updated
        $this->assertEquals('New Skills', $user->supporterProfile->skills);
        $this->assertEquals('New Availability', $user->supporterProfile->availability);
    }
}
