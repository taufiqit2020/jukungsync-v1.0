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
        // 1. Tambah kolom status di tabel invoices
        Schema::table('invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('invoices', 'status')) {
                $table->string('status')->default('selesai')->after('tanggal_invoice');
                // status: 'draft', 'selesai'
            }
        });

        // 2. Modifikasi kolom role di tabel users
        // Karena memodifikasi ENUM kadang bermasalah, kita pakai raw DB statement untuk MySQL
        // atau kita ubah saja jadi string biasa agar fleksibel
        Schema::table('users', function (Blueprint $table) {
            $table->string('role_baru')->default('staf_admin')->after('password');
        });

        DB::table('users')->update(['role_baru' => DB::raw('role')]);

        // Hapus kolom role lama dan rename role_baru
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('role_baru', 'role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'status')) {
                $table->dropColumn('status');
            }
        });

        // Revert role to basic
        Schema::table('users', function (Blueprint $table) {
            $table->string('role_baru')->default('staff_gudang');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('role_baru', 'role');
        });
    }
};
