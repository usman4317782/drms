<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class CampFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Camp',
            'district' => fake()->city(),
            'location' => fake()->address(),
            'capacity' => fake()->numberBetween(50, 1000),
            'status' => fake()->randomElement([
                'active',
                'closed',
                'full',
            ]),
            'manager_id' => User::where('role', 'camp_manager')
                ->inRandomOrder()
                ->value('id'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
