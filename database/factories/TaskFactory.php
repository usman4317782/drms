<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Camp;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'camp_id' => Camp::factory(),
            'manager_id' => User::factory(),
            'assigned_to' => null,
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'required_skills' => $this->faker->words(3, true),
            'status' => 'pending',
            'priority' => $this->faker->randomElement(['low', 'medium', 'high', 'urgent']),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'completed_at' => null,
        ];
    }

    public function completed(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }
}
