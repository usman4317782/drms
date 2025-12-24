<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('supporter_id')->constrained('users')->onDelete('cascade');
            $blueprint->foreignId('camp_id')->nullable()->constrained('camps')->onDelete('set null');
            $blueprint->string('type'); // cast to DonationType enum
            $blueprint->string('status'); // cast to DonationStatus enum
            $blueprint->decimal('amount', 15, 2)->nullable(); // for cash
            $blueprint->integer('quantity')->nullable(); // for in_kind
            $blueprint->string('unit')->nullable(); // e.g., kg, pieces
            $blueprint->text('description')->nullable();
            $blueprint->timestamps();
            $blueprint->softDeletes();

            $blueprint->index('supporter_id');
            $blueprint->index('camp_id');
            $blueprint->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
