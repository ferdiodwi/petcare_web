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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('category')->nullable();
            $table->decimal('price', 12, 2);
            $table->integer('duration')->comment('Duration in minutes');
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('features')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'category']);
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
