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
    Schema::create('camps', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('district'); // Important for sorting
        $table->string('location'); // Specific address/coords
        $table->integer('capacity')->default(0);
        $table->enum('status', ['active', 'closed', 'full'])->default('active');

        // Link to a User (Camp Manager)
        // If manager is deleted, set this column to null (don't delete the camp history)
        $table->foreignId('manager_id')
              ->nullable()
              ->constrained('users')
              ->nullOnDelete();

        $table->timestamps();
        $table->softDeletes();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camps');
    }
};
