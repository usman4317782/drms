<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Camp;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        // 1️⃣ Create 200 users
        User::factory()->count(100)->create();

        // 2️⃣ Ensure camp managers exist
        User::factory()
            ->count(20)
            ->campManager()
            ->create();

        // 3️⃣ Create camps
        Camp::factory()->count(100)->create();
    }
}
