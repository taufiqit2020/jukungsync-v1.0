<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Mengubah tipe_pelanggan dari [reguler, grosir] -> [reguler, member, premium]
     * Menambahkan kolom metode_pembayaran ke tabel invoices
     */
    public function up(): void
    {
        // 1. Ganti kolom tipe_pelanggan di users menjadi string agar fleksibel
        //    (SQLite tidak support ALTER ENUM, pakai string + validasi di aplikasi)
        Schema::table('users', function (Blueprint $table) {
            // Rename kolom lama ke temporary
            $table->string('tipe_pelanggan_new')->default('reguler')->after('tipe_pelanggan');
        });

        // Migrasi data lama: grosir -> member (semua data grosir lama jadi member)
        DB::table('users')->where('tipe_pelanggan', 'grosir')->update(['tipe_pelanggan_new' => 'member']);
        DB::table('users')->where('tipe_pelanggan', 'reguler')->update(['tipe_pelanggan_new' => 'reguler']);

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tipe_pelanggan');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('tipe_pelanggan_new', 'tipe_pelanggan');
        });

        // 2. Tambah kolom metode_pembayaran ke tabel invoices (untuk online order checkout)
        Schema::table('invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('invoices', 'metode_pembayaran')) {
                $table->string('metode_pembayaran')->nullable()->after('ekspedisi');
                // nilai: 'tunai', 'transfer', 'invoice_30_hari'
            }
            if (!Schema::hasColumn('invoices', 'diskon_persen')) {
                $table->decimal('diskon_persen', 5, 2)->default(0)->after('metode_pembayaran');
                // menyimpan % diskon yang diterapkan saat order dibuat
            }
            if (!Schema::hasColumn('invoices', 'total_diskon')) {
                $table->decimal('total_diskon', 15, 2)->default(0)->after('diskon_persen');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('tipe_pelanggan_old')->default('reguler')->after('tipe_pelanggan');
        });
        DB::table('users')->where('tipe_pelanggan', 'member')->update(['tipe_pelanggan_old' => 'grosir']);
        DB::table('users')->where('tipe_pelanggan', 'reguler')->update(['tipe_pelanggan_old' => 'reguler']);
        DB::table('users')->where('tipe_pelanggan', 'premium')->update(['tipe_pelanggan_old' => 'grosir']);
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tipe_pelanggan');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('tipe_pelanggan_old', 'tipe_pelanggan');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumnIfExists(['metode_pembayaran', 'diskon_persen', 'total_diskon']);
        });
    }
};
