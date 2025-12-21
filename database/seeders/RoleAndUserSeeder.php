<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure Default Roles Exist
        $roles = [
            ['slug' => 'admin', 'name' => 'System Administrator'],
            ['slug' => 'camp_manager', 'name' => 'Camp Manager'],
            ['slug' => 'supporter', 'name' => 'Supporter'],
            ['slug' => 'volunteer', 'name' => 'Volunteer'],
            ['slug' => 'donor', 'name' => 'Donor'],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(['slug' => $roleData['slug']], $roleData);
        }

        // 2. Create Default Users with Specified Credentials
        $users = [
            [
                'name' => 'System Admin',
                'email' => 'admin@drms.pk',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active'
            ],
            [
                'name' => 'Usman Supporter',
                'email' => 'usman@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'supporter',
                'status' => 'active'
            ],
            [
                'name' => 'Kamran Manager',
                'email' => 'kamran@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'camp_manager',
                'status' => 'active'
            ],
        ];

        foreach ($users as $userData) {
            $roleSlug = $userData['role'];
            unset($userData['role']);

            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );

            // Assign role if not already assigned
            if (!$user->hasRole($roleSlug)) {
                $user->assignRole($roleSlug);
            }
        }
    }
}
