<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class SystemWideMassiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $totalRecords = 5500;
        $chunkSize = 500;

        $this->command->info("Seeding {$totalRecords} users across all roles...");

        // Get all role IDs
        $allRoles = Role::all();
        $roleIds = $allRoles->pluck('id', 'slug')->toArray();
        $roleSlugs = $allRoles->pluck('slug')->toArray();

        // Hash password once for performance
        $hashedPassword = Hash::make('password');

        for ($i = 0; $i < $totalRecords; $i += $chunkSize) {
            DB::transaction(function () use (
                $chunkSize,
                $roleIds,
                $roleSlugs,
                $hashedPassword,
                $faker
            ) {
                $userData = [];

                for ($j = 0; $j < $chunkSize; $j++) {
                    $userData[] = [
                        'name' => $faker->name(),
                        'email' => Str::random(8) . '_' . $faker->unique()->safeEmail(),
                        'phone' => $faker->phoneNumber(),
                        'status' => $faker->randomElement(['active', 'active', 'active', 'inactive']),
                        'password' => $hashedPassword,
                        'email_verified_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Insert users
                DB::table('users')->insert($userData);

                // Fetch inserted users
                $batchUsers = User::orderBy('id', 'desc')
                    ->take($chunkSize)
                    ->get();

                $roleUserPivots = [];
                $profiles = [];

                foreach ($batchUsers as $user) {
                    // Role distribution
                    $rand = rand(1, 100);
                    $selectedRoleSlugs = [];

                    if ($rand <= 10) {
                        $selectedRoleSlugs[] = 'admin';
                    } elseif ($rand <= 30) {
                        $selectedRoleSlugs[] = 'camp_manager';
                    } elseif ($rand <= 50) {
                        $selectedRoleSlugs[] = 'field_staff';
                    } else {
                        $selectedRoleSlugs = $faker->randomElements(
                            ['supporter', 'donor', 'volunteer'],
                            rand(1, 3)
                        );
                    }

                    foreach ($selectedRoleSlugs as $slug) {
                        if (isset($roleIds[$slug])) {
                            $roleUserPivots[] = [
                                'user_id' => $user->id,
                                'role_id' => $roleIds[$slug],
                                'starts_at' => now(),
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        }
                    }

                    // Create supporter profile if applicable
                    if (array_intersect($selectedRoleSlugs, ['supporter', 'donor', 'volunteer'])) {
                        $profiles[] = [
                            'user_id' => $user->id,
                            'skills' => $faker->sentence(4),
                            'availability' => $faker->randomElement(['Full-time', 'Part-time', 'Weekends']),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }

                DB::table('role_user')->insert($roleUserPivots);

                if (!empty($profiles)) {
                    DB::table('supporter_profiles')->insert($profiles);
                }
            });

            $this->command->info("Chunk " . ($i / $chunkSize + 1) . " processed.");
        }

        $this->command->info("Seeding complete. All passwords are 'password'.");
    }
}
