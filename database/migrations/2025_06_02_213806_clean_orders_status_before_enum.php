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
        // Pertama, bersihkan dan standardisasi data status
        DB::statement("UPDATE orders SET status = 'pending' WHERE status = '' OR status IS NULL");
        DB::statement("UPDATE orders SET status = 'pending' WHERE LOWER(TRIM(status)) = 'pending'");
        DB::statement("UPDATE orders SET status = 'paid' WHERE LOWER(TRIM(status)) = 'paid'");
        DB::statement("UPDATE orders SET status = 'processing' WHERE LOWER(TRIM(status)) = 'processing'");
        DB::statement("UPDATE orders SET status = 'shipped' WHERE LOWER(TRIM(status)) = 'shipped'");
        DB::statement("UPDATE orders SET status = 'completed' WHERE LOWER(TRIM(status)) = 'completed'");
        DB::statement("UPDATE orders SET status = 'canceled' WHERE LOWER(TRIM(status)) IN ('canceled', 'cancelled')");

        // Update status yang tidak dikenali menjadi pending
        DB::statement("UPDATE orders SET status = 'pending' WHERE status NOT IN ('pending', 'paid', 'processing', 'shipped', 'completed', 'canceled')");

        // Sekarang ubah kolom ke enum
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['pending', 'paid', 'processing', 'shipped', 'completed', 'canceled'])
                  ->default('pending')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });
    }
};
