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
        Schema::create('boardings', function (Blueprint $table) {
            $table->id();
            $table->string('pet_name');
            $table->enum('species', ['Anjing', 'Kucing', 'Kelinci', 'Burung']);
            $table->string('owner_name');
            $table->string('owner_phone', 20);
            $table->string('owner_email')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->text('special_instructions')->nullable();
            $table->enum('status', ['pending', 'active', 'completed', 'cancelled'])->default('pending');
            $table->decimal('daily_rate', 10, 2);
            $table->decimal('total_cost', 10, 2)->nullable();
            $table->json('services')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index('status');
            $table->index('start_date');
            $table->index('end_date');
            $table->index(['owner_name', 'pet_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boardings');
    }
};
