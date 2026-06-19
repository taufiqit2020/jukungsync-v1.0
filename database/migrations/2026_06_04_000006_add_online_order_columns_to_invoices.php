<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->enum('jenis_transaksi', ['offline', 'online'])->default('offline')->after('total_tagihan');
            $table->enum('status_pesanan', ['menunggu_konfirmasi', 'diproses', 'selesai', 'dibatalkan'])->default('selesai')->after('jenis_transaksi');
            $table->text('catatan')->nullable()->after('status_pesanan');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['jenis_transaksi', 'status_pesanan', 'catatan']);
        });
    }
};
