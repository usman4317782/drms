<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Camp;
use App\Models\Task;
use App\Models\UrgentNeed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $manager;
    protected User $supporter;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup Roles
        collect(['admin', 'camp_manager', 'supporter'])->each(function ($slug) {
            Role::firstOrCreate(['slug' => $slug], ['name' => ucfirst($slug)]);
        });

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        $this->manager = User::factory()->create();
        $this->manager->assignRole('camp_manager');

        $this->supporter = User::factory()->create();
        $this->supporter->assignRole('supporter');
    }

    #[Test]
    public function admin_can_access_dashboard_with_admin_data(): void
    {
        $this->actingAs($this->admin)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertViewHas('role', 'admin')
            ->assertViewHas('data');
    }

    #[Test]
    public function manager_can_access_dashboard_with_manager_data(): void
    {
        $this->actingAs($this->manager)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertViewHas('role', 'manager')
            ->assertViewHas('data');
    }

    #[Test]
    public function supporter_can_access_dashboard_with_supporter_data(): void
    {
        $this->actingAs($this->supporter)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertViewHas('role', 'supporter')
            ->assertViewHas('data');
    }

    #[Test]
    public function dashboard_data_aggregation_works_for_admin(): void
    {
        Camp::factory()->count(2)->create();
        UrgentNeed::factory()->create(['status' => UrgentNeed::STATUS_PENDING]);
        Task::factory()->create(['status' => Task::STATUS_COMPLETED]);

        $this->actingAs($this->admin)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertViewHas('data', function ($data) {
                return $data->stats['total_camps'] >= 2 &&
                    isset($data->resourceChart) &&
                    isset($data->donationChart);
            });
    }

    #[Test]
    public function dashboard_data_aggregation_works_for_manager(): void
    {
        $camp = Camp::factory()->create(['manager_id' => $this->manager->id]);
        Task::factory()->create([
            'camp_id' => $camp->id,
            'manager_id' => $this->manager->id,
            'status' => Task::STATUS_PENDING
        ]);

        $this->actingAs($this->manager)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertViewHas('data', function ($data) {
                return $data->stats['managed_camps'] === 1 &&
                    $data->stats['pending_tasks'] >= 1;
            });
    }
}
