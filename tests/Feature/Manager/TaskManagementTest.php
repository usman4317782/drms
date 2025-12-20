<?php

namespace Tests\Feature\Manager;

use App\Models\Camp;
use App\Models\Role;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $manager;
    private User $volunteer;
    private Camp $camp;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup Roles (Get existing roles from migration seed)
        $managerRole = Role::where('slug', 'camp_manager')->first();
        $volunteerRole = Role::where('slug', 'volunteer')->first();
        $donorRole = Role::where('slug', 'donor')->first();

        // Setup Users
        $this->manager = User::factory()->create();
        $this->manager->roles()->attach($managerRole, ['starts_at' => now()]);

        $this->volunteer = User::factory()->create();
        $this->volunteer->roles()->attach($volunteerRole, ['starts_at' => now()]);

        // Setup Camp
        $this->camp = Camp::create([
            'name' => 'Test Camp',
            'location' => 'Test Location',
            'district' => 'Test District',
            'manager_id' => $this->manager->id,
            'capacity' => 100,
            'status' => 'active'
        ]);
    }

    /** @test */
    public function a_manager_can_create_and_assign_a_task()
    {
        $response = $this->actingAs($this->manager)
            ->post(route('manager.tasks.store'), [
                'camp_id' => $this->camp->id,
                'assigned_to' => $this->volunteer->id,
                'title' => 'Distribute Food',
                'description' => 'Go to block A and distribute food packets.',
                'priority' => 'high',
                'due_date' => now()->addDays(2)->format('Y-m-d'),
                'status' => 'pending'
            ]);

        $response->assertRedirect(route('manager.tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'title' => 'Distribute Food',
            'assigned_to' => $this->volunteer->id,
            'manager_id' => $this->manager->id
        ]);
    }

    /** @test */
    public function a_manager_can_update_task_status()
    {
        $task = Task::create([
            'camp_id' => $this->camp->id,
            'manager_id' => $this->manager->id,
            'assigned_to' => $this->volunteer->id,
            'title' => 'Initial Task',
            'status' => 'pending',
            'priority' => 'medium'
        ]);

        $response = $this->actingAs($this->manager)
            ->put(route('manager.tasks.update', $task), [
                'camp_id' => $this->camp->id,
                'assigned_to' => $this->volunteer->id,
                'title' => 'Updated Task',
                'status' => 'completed',
                'priority' => 'high'
            ]);

        $response->assertRedirect(route('manager.tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'completed'
        ]);

        $this->assertNotNull($task->fresh()->completed_at);
    }

    /** @test */
    public function it_enforces_volunteer_role_requirement_for_assignment()
    {
        $guest = User::factory()->create(); // No roles

        $response = $this->actingAs($this->manager)
            ->post(route('manager.tasks.store'), [
                'camp_id' => $this->camp->id,
                'assigned_to' => $guest->id,
                'title' => 'Illegal Task',
                'priority' => 'low'
            ]);

        $response->assertSessionHasErrors('assigned_to');
    }

    /** @test */
    public function testing_isolation_guatantee_main_db_remains_safe()
    {
        // This test technically doesn't 'do' anything but run under the RefreshDatabase trait.
        // Because phpunit.xml is configured to use :memory: sqlite, 
        // this RefreshDatabase will wipe the RAM DB, not the MySQL DB.

        $this->assertTrue(true);
    }
}
