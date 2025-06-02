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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Jika ada sistem user login di Flutter
            $table->string('customer_name')->default('Guest'); // Atau ambil dari user jika login
            $table->text('address');
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->default('pending'); // pending, paid, processing, shipped, completed, cancelled
            $table->string('payment_proof_path')->nullable(); // Path ke bukti transfer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
