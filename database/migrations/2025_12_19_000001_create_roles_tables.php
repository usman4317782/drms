<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create 'roles' table
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // 2. Create 'role_user' pivot table with temporal fields
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->timestamp('starts_at')->useCurrent();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });

        // 3. Seed initial roles
        $roles = [
            ['name' => 'Admin', 'slug' => 'admin'],
            ['name' => 'Camp Manager', 'slug' => 'camp_manager'],
            ['name' => 'Field Staff', 'slug' => 'field_staff'],
            ['name' => 'Supporter', 'slug' => 'supporter'],
            ['name' => 'Donor', 'slug' => 'donor'],
            ['name' => 'Volunteer', 'slug' => 'volunteer'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert(array_merge($role, ['created_at' => now(), 'updated_at' => now()]));
        }

        // 4. Data Migration: Migrate existing 'role' from 'users' table to 'role_user'
        $users = DB::table('users')->select('id', 'role')->get();
        foreach ($users as $user) {
            $roleId = DB::table('roles')->where('slug', $user->role)->value('id');
            if ($roleId) {
                DB::table('role_user')->insert([
                    'user_id' => $user->id,
                    'role_id' => $roleId,
                    'starts_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
    }
};
