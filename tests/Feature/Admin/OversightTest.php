<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Role;
use App\Models\Camp;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OversightTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $manager;
    protected User $volunteer;

    protected function setUp(): void
    {
        parent::setUp();

        // Initialize Roles explicitly for isolation
        collect(['admin', 'camp_manager', 'volunteer'])->each(function ($slug) {
            Role::firstOrCreate(['slug' => $slug], ['name' => ucfirst($slug)]);
        });

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        $this->manager = User::factory()->create();
        $this->manager->assignRole('camp_manager');

        $this->volunteer = User::factory()->create();
        $this->volunteer->assignRole('volunteer');
    }

    #[Test]
    public function admin_can_view_all_tasks_in_oversight_monitoring(): void
    {
        $camp = Camp::factory()->create(['manager_id' => $this->manager->id]);

        Task::factory()->count(3)->create([
            'camp_id' => $camp->id,
            'manager_id' => $this->manager->id,
        ]);

        $this->actingAs($this->admin)
            ->get(route('admin.oversight.tasks'))
            ->assertOk();

        // Verify DataTables JSON structure
        $this->actingAs($this->admin)
            ->get(route('admin.oversight.tasks'), ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJsonStructure(['data', 'recordsTotal', 'recordsFiltered'])
            ->assertJsonPath('data.0.assigned_name', function ($value) {
                return str_contains($value, 'Unassigned') || str_contains($value, 'class="');
            });
    }

    #[Test]
    public function admin_is_forbidden_from_manager_operational_routes(): void
    {
        $camp = Camp::factory()->create(['manager_id' => $this->manager->id]);
        $task = Task::factory()->create(['camp_id' => $camp->id, 'manager_id' => $this->manager->id]);

        $this->actingAs($this->admin)
            ->get(route('manager.tasks.edit', $task))
            ->assertStatus(403);
    }

    #[Test]
    public function admin_can_view_specific_task_details(): void
    {
        $camp = Camp::factory()->create(['manager_id' => $this->manager->id]);
        $task = Task::factory()->create([
            'camp_id' => $camp->id,
            'manager_id' => $this->manager->id,
            'title' => 'Specific Audit Task'
        ]);

        $this->actingAs($this->admin)
            ->get(route('admin.oversight.show', $task))
            ->assertOk()
            ->assertJson([
                'id' => $task->id,
                'title' => 'Specific Audit Task',
                'camp' => $camp->name
            ]);
    }

    #[Test]
    public function manager_cannot_access_oversight_task_details(): void
    {
        $task = Task::factory()->create();

        $this->actingAs($this->manager)
            ->get(route('admin.oversight.show', $task))
            ->assertStatus(403);
    }
}
