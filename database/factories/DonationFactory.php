<?php

namespace Database\Factories;

use App\Enums\DonationStatus;
use App\Enums\DonationType;
use App\Models\Camp;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donation>
 */
class DonationFactory extends Factory
{
    protected $model = Donation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(DonationType::cases());

        return [
            'supporter_id' => User::factory(),
            'camp_id' => $this->faker->boolean(70) ? Camp::factory() : null,
            'type' => $type,
            'status' => $this->faker->randomElement(DonationStatus::cases()),
            'amount' => $type === DonationType::CASH ? $this->faker->randomFloat(2, 10, 1000) : null,
            'quantity' => $type === DonationType::IN_KIND ? $this->faker->numberBetween(1, 100) : null,
            'unit' => $type === DonationType::IN_KIND ? $this->faker->randomElement(['kg', 'pieces', 'boxes']) : null,
            'description' => $this->faker->sentence(),
        ];
    }

    /**
     * Indicate that the donation is cash.
     */
    public function cash(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => DonationType::CASH,
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'quantity' => null,
            'unit' => null,
        ]);
    }

    /**
     * Indicate that the donation is in-kind.
     */
    public function inKind(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => DonationType::IN_KIND,
            'amount' => null,
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit' => $this->faker->randomElement(['kg', 'pieces', 'boxes']),
        ]);
    }

    /**
     * Set the status.
     */
    public function status(DonationStatus $status): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => $status,
        ]);
    }
}
