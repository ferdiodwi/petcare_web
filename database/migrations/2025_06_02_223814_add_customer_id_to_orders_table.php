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
        Schema::table('orders', function (Blueprint $table) {
            // Tambahkan kolom customer_id setelah id
            $table->unsignedBigInteger('customer_id')->nullable()->after('id');

            // Tambahkan foreign key constraint
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');

            // Index untuk performa
            $table->index('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu
            $table->dropForeign(['customer_id']);

            // Hapus index
            $table->dropIndex(['customer_id']);

            // Hapus kolom
            $table->dropColumn('customer_id');
        });
    }
};
