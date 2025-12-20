<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MassiveCampSeeder extends Seeder
{
    public function run(): void
    {
        $totalRecords = 5200;
        $chunkSize = 500;

        $this->command->info("Seeding {$totalRecords} camps...");

        $managerIds = User::whereHas(
            'roles',
            fn($q) =>
            $q->where('slug', 'camp_manager')
        )->pluck('id')->toArray();

        if (!$managerIds) {
            $this->command->error("No camp managers found.");
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
                $districts
            ) {
                $camps = [];

                for ($j = 0; $j < $chunkSize; $j++) {
                    $facilities = [];
                    foreach (array_rand(array_flip($facilitySlugs), rand(2, 5)) as $slug) {
                        $facilities[$slug] = 1;
                    }

                    $capacity = rand(100, 5000);

                    $camps[] = [
                        'name' => 'Relief Camp ' . Str::upper(Str::random(5)),
                        'district' => $districts[array_rand($districts)],
                        'location' => 'Sector ' . rand(1, 50),
                        'capacity' => $capacity,
                        'current_occupancy' => rand((int)($capacity * 0.1), (int)($capacity * 0.9)),
                        'status' => ['active', 'active', 'full', 'closed'][rand(0, 3)],
                        'manager_id' => $managerIds[array_rand($managerIds)],
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
