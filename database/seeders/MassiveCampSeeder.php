<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MassiveCampSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $totalRecords = 5200;
        $chunkSize = 500;

        $this->command->info("Seeding {$totalRecords} camps assigned to existing managers...");

        // Get all camp manager IDs
        $managerIds = User::whereHas('roles', fn($q) => $q->where('slug', 'camp_manager'))
            ->pluck('id')
            ->toArray();

        if (empty($managerIds)) {
            $this->command->error("No camp managers found! Please run the SystemWideMassiveSeeder first.");
            return;
        }

        // Get facility slugs from config
        $facilitySlugs = array_keys(config('camp.facilities', []));
        $districts = ['Karachi', 'Hyderabad', 'Sukkur', 'Larkana', 'Mirpur Khas', 'Shaheed Benazirabad', 'Jacobabad', 'Shikarpur', 'Dadu'];

        for ($i = 0; $i < $totalRecords; $i += $chunkSize) {
            DB::transaction(function () use ($chunkSize, $managerIds, $facilitySlugs, $districts) {
                $camps = [];
                for ($j = 0; $j < $chunkSize; $j++) {
                    // Randomize facilities (associative array: slug => 1)
                    $selectedFacilities = [];
                    foreach (array_intersect($facilitySlugs, fake()->randomElements($facilitySlugs, rand(2, 5))) as $slug) {
                        $selectedFacilities[$slug] = 1;
                    }

                    $capacity = (int) fake()->numberBetween(100, 5000);
                    $camps[] = [
                        'name' => fake()->company() . ' Relief Camp ' . fake()->numerify('#####'),
                        'district' => fake()->randomElement($districts),
                        'location' => fake()->address(),
                        'capacity' => $capacity,
                        'current_occupancy' => (int) ($capacity * fake()->randomFloat(2, 0.1, 0.9)),
                        'status' => fake()->randomElement(['active', 'active', 'active', 'full', 'closed']),
                        'manager_id' => fake()->randomElement($managerIds),
                        'facilities' => json_encode($selectedFacilities),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Insert camps in bulk
                DB::table('camps')->insert($camps);
            });

            $this->command->info("Batch " . ($i / $chunkSize + 1) . " processed.");
        }

        $this->command->info("Massive camp seeding complete.");
    }
}
