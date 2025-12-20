<?php

namespace Tests\Feature\Supporter;

use App\Models\Camp;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupporterTaskTest extends TestCase
{
    use RefreshDatabase;

    protected $volunteer;
    protected $manager;
    protected $camp;

    protected function setUp(): void
    {
        parent::setUp();

        // Use existing roles from migration
        $volunteerRole = Role::where('slug', 'volunteer')->first();
        $managerRole = Role::where('slug', 'camp_manager')->first();

        $this->volunteer = User::factory()->create();
        $this->volunteer->roles()->attach($volunteerRole->id, ['starts_at' => now()]);

        $this->manager = User::factory()->create();
        $this->manager->roles()->attach($managerRole->id, ['starts_at' => now()]);

        $this->camp = Camp::factory()->create([
            'manager_id' => $this->manager->id,
            'district' => 'Lahore'
        ]);
    }

    public function test_supporter_can_view_marketplace()
    {
        $response = $this->actingAs($this->volunteer)
            ->get(route('supporter.tasks.index'));

        $response->assertStatus(200);
        $response->assertSee('Volunteer Marketplace');
    }

    public function test_supporter_can_accept_task_from_marketplace()
    {
        $task = Task::create([
            'camp_id' => $this->camp->id,
            'manager_id' => $this->manager->id,
            'title' => 'Test Marketplace Task',
            'status' => 'pending',
            'priority' => 'medium'
        ]);

        $response = $this->actingAs($this->volunteer)
            ->post(route('supporter.tasks.accept', $task));

        $response->assertStatus(200);
        $this->assertEquals($this->volunteer->id, $task->fresh()->assigned_to);
        $this->assertEquals('in_progress', $task->fresh()->status);
    }

    public function test_supporter_can_complete_accepted_task()
    {
        $task = Task::create([
            'camp_id' => $this->camp->id,
            'manager_id' => $this->manager->id,
            'assigned_to' => $this->volunteer->id,
            'title' => 'Assigned Task',
            'status' => 'in_progress',
            'priority' => 'high'
        ]);

        $response = $this->actingAs($this->volunteer)
            ->post(route('supporter.tasks.complete', $task));

        $response->assertStatus(200);
        $this->assertEquals('completed', $task->fresh()->status);
        $this->assertNotNull($task->fresh()->completed_at);
    }
}
