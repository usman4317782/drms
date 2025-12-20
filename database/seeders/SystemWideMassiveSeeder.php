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
    public function run(): void
    {
        $faker = app(\Faker\Generator::class);

        $totalRecords = 5500;
        $chunkSize = 500;

        $this->command->info("Seeding {$totalRecords} users across all roles...");

        $allRoles = Role::all();
        $roleIds = $allRoles->pluck('id', 'slug')->toArray();

        $hashedPassword = Hash::make('password');

        for ($i = 0; $i < $totalRecords; $i += $chunkSize) {
            DB::transaction(function () use (
                $chunkSize,
                $roleIds,
                $hashedPassword,
                $faker
            ) {
                $users = [];

                for ($j = 0; $j < $chunkSize; $j++) {
                    $users[] = [
                        'name' => $faker->name(),
                        'email' => Str::random(6) . '_' . $faker->unique()->safeEmail(),
                        'phone' => $faker->phoneNumber(),
                        'status' => $faker->randomElement(['active', 'active', 'active', 'inactive']),
                        'password' => $hashedPassword,
                        'email_verified_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                DB::table('users')->insert($users);

                $batchUsers = User::latest()->take($chunkSize)->get();

                $roleUser = [];
                $profiles = [];

                foreach ($batchUsers as $user) {
                    $rand = rand(1, 100);
                    $roles = [];

                    if ($rand <= 10) {
                        $roles[] = 'admin';
                    } elseif ($rand <= 30) {
                        $roles[] = 'camp_manager';
                    } elseif ($rand <= 50) {
                        $roles[] = 'field_staff';
                    } else {
                        $roles = $faker->randomElements(
                            ['supporter', 'donor', 'volunteer'],
                            rand(1, 3)
                        );
                    }

                    foreach ($roles as $slug) {
                        if (isset($roleIds[$slug])) {
                            $roleUser[] = [
                                'user_id' => $user->id,
                                'role_id' => $roleIds[$slug],
                                'starts_at' => now(),
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        }
                    }

                    if (array_intersect($roles, ['supporter', 'donor', 'volunteer'])) {
                        $profiles[] = [
                            'user_id' => $user->id,
                            'skills' => $faker->sentence(4),
                            'availability' => $faker->randomElement(['Full-time', 'Part-time', 'Weekends']),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }

                DB::table('role_user')->insert($roleUser);

                if ($profiles) {
                    DB::table('supporter_profiles')->insert($profiles);
                }
            });

            $this->command->info("Chunk " . ($i / $chunkSize + 1) . " processed.");
        }

        $this->command->info("Users seeding complete.");
    }
}
