<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Default is 'inactive' so new registrations are locked by default
            $table->string('status')->default('inactive')->after('role');
        });

        // SAFETY: Immediately activate existing Admins so you don't lock yourself out
        DB::table('users')->where('role', 'admin')->update(['status' => 'active']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
