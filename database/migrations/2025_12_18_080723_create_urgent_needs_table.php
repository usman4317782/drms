<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('urgent_needs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('camp_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('category'); // food, water, medicine, shelter, etc.
            $table->text('description')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('priority')->default('medium'); // low, medium, high
            $table->string('status')->default('pending');  // pending, fulfilled

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('urgent_needs');
    }
};
