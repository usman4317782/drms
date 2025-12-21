<?php

namespace Database\Factories;

use App\Models\Camp;
use App\Models\UrgentNeed;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UrgentNeed>
 */
class UrgentNeedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'camp_id' => Camp::factory(),
            'category' => $this->faker->randomElement(['Food', 'Medicine', 'Water', 'Shelter']),
            'description' => $this->faker->sentence(),
            'quantity' => $this->faker->numberBetween(1, 100) . ' units',
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'status' => 'pending',
        ];
    }
}
