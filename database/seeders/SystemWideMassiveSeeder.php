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
        $totalRecords = 5500;
        $chunkSize = 500;

        $this->command->info("Seeding {$totalRecords} users across all roles...");

        $roleIds = Role::pluck('id', 'slug')->toArray();
        $hashedPassword = Hash::make('password');

        for ($i = 0; $i < $totalRecords; $i += $chunkSize) {
            DB::transaction(function () use ($chunkSize, $roleIds, $hashedPassword) {

                $users = [];

                for ($j = 0; $j < $chunkSize; $j++) {
                    $users[] = [
                        'name' => 'User ' . Str::random(6),
                        'email' => Str::random(8) . '@example.com',
                        'phone' => '+92' . rand(3000000000, 3999999999),
                        'status' => rand(1, 4) === 4 ? 'inactive' : 'active',
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
                        $roles = array_rand(array_flip(['supporter', 'donor', 'volunteer']), rand(1, 3));
                    }

                    foreach ((array) $roles as $slug) {
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

                    if (array_intersect((array) $roles, ['supporter', 'donor', 'volunteer'])) {
                        $profiles[] = [
                            'user_id' => $user->id,
                            'skills' => 'General Support',
                            'availability' => ['Full-time', 'Part-time', 'Weekends'][rand(0, 2)],
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

        $this->command->info("User seeding complete.");
    }
}
