<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MassiveCampSeeder extends Seeder
{
    public function run(): void
    {
        $faker = app(\Faker\Generator::class);

        $totalRecords = 5200;
        $chunkSize = 500;

        $this->command->info("Seeding {$totalRecords} camps...");

        $managerIds = User::whereHas(
            'roles',
            fn($q) =>
            $q->where('slug', 'camp_manager')
        )->pluck('id')->toArray();

        if (!$managerIds) {
            $this->command->error("No camp managers found. Run SystemWideMassiveSeeder first.");
            return;
        }

        $facilitySlugs = array_keys(config('camp.facilities', []));
        $districts = [
            'Karachi',
            'Hyderabad',
            'Sukkur',
            'Larkana',
            'Mirpur Khas',
            'Shaheed Benazirabad',
            'Jacobabad',
            'Shikarpur',
            'Dadu',
        ];

        for ($i = 0; $i < $totalRecords; $i += $chunkSize) {
            DB::transaction(function () use (
                $chunkSize,
                $managerIds,
                $facilitySlugs,
                $districts,
                $faker
            ) {
                $camps = [];

                for ($j = 0; $j < $chunkSize; $j++) {
                    $facilities = [];

                    foreach ($faker->randomElements($facilitySlugs, rand(2, 5)) as $slug) {
                        $facilities[$slug] = 1;
                    }

                    $capacity = $faker->numberBetween(100, 5000);

                    $camps[] = [
                        'name' => $faker->company() . ' Relief Camp ' . $faker->numerify('#####'),
                        'district' => $faker->randomElement($districts),
                        'location' => $faker->address(),
                        'capacity' => $capacity,
                        'current_occupancy' => (int) ($capacity * $faker->randomFloat(2, 0.1, 0.9)),
                        'status' => $faker->randomElement(['active', 'active', 'full', 'closed']),
                        'manager_id' => $faker->randomElement($managerIds),
                        'facilities' => json_encode($facilities),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                DB::table('camps')->insert($camps);
            });

            $this->command->info("Batch " . ($i / $chunkSize + 1) . " done.");
        }

        $this->command->info("Camp seeding complete.");
    }
}
