<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SystemWideMassiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $totalRecords = 5500;
        $chunkSize = 500;

        $this->command->info("Seeding {$totalRecords} users across all roles...");

        // Get all role IDs
        $allRoles = Role::all();
        $roleIds = $allRoles->pluck('id', 'slug')->toArray();
        $roleSlugs = $allRoles->pluck('slug')->toArray();

        // High performance hashing (hash once)
        $hashedPassword = Hash::make('password');

        for ($i = 0; $i < $totalRecords; $i += $chunkSize) {
            DB::transaction(function () use ($chunkSize, $roleIds, $roleSlugs, $hashedPassword) {
                $userData = [];
                for ($j = 0; $j < $chunkSize; $j++) {
                    $userData[] = [
                        'name' => fake()->name(),
                        'email' => Str::random(8) . '_' . fake()->unique()->safeEmail(),
                        'phone' => fake()->phoneNumber(),
                        'status' => fake()->randomElement(['active', 'active', 'active', 'inactive']), // predominantly active
                        'password' => $hashedPassword,
                        'email_verified_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Insert users
                DB::table('users')->insert($userData);

                // Get last inserted batch
                $batchUsers = User::orderBy('id', 'desc')->take($chunkSize)->get();

                $profiles = [];
                $roleUserPivots = [];

                foreach ($batchUsers as $user) {
                    // Random Role Selection
                    // 10% Admin, 20% Manager, 20% Staff, 50% Supporters (which can be multiple)
                    $rand = rand(1, 100);
                    $selectedRoleSlugs = [];

                    if ($rand <= 10) {
                        $selectedRoleSlugs[] = 'admin';
                    } elseif ($rand <= 30) {
                        $selectedRoleSlugs[] = 'camp_manager';
                    } elseif ($rand <= 50) {
                        $selectedRoleSlugs[] = 'field_staff';
                    } else {
                        // Supporter group (can have multiple)
                        $selectedRoleSlugs = fake()->randomElements(['supporter', 'donor', 'volunteer'], rand(1, 3));
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

                    // Create Profile if user has any supporter-related roles
                    $supporterSlugs = ['supporter', 'donor', 'volunteer'];
                    if (array_intersect($selectedRoleSlugs, $supporterSlugs)) {
                        $profiles[] = [
                            'user_id' => $user->id,
                            'skills' => fake()->sentence(4),
                            'availability' => fake()->randomElement(['Full-time', 'Part-time', 'Weekends']),
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
