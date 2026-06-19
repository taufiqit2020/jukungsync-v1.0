<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Fix: Sinkronisasi role di tabel users.
     * Role lama: ['superadmin', 'staff_gudang']
     * Role baru: ['superadmin', 'direktur', 'bendahara', 'staf_admin', 'customer']
     * 
     * Karena SQLite tidak support ALTER COLUMN untuk enum,
     * kita gunakan pendekatan: buat kolom baru, copy data, hapus lama, rename.
     */
    public function up(): void
    {
        // SQLite tidak mendukung ALTER COLUMN secara langsung.
        // Gunakan raw SQL untuk memodifikasi dengan pendekatan rename table.
        
        // Langkah 1: Ubah semua nilai 'staff_gudang' yang lama menjadi 'staf_admin' agar tidak kehilangan data
        DB::statement("UPDATE users SET role = 'staf_admin' WHERE role = 'staff_gudang'");
        DB::statement("UPDATE users SET role = 'staf_admin' WHERE role = 'superadmin' AND id != (SELECT MIN(id) FROM users WHERE role = 'superadmin')");
        
        // Langkah 2: Karena SQLite tidak bisa ALTER COLUMN, kita buat ulang tabelnya
        // dengan schema yang baru menggunakan teknik rename
        DB::statement("CREATE TABLE users_new (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            email_verified_at DATETIME NULL,
            password VARCHAR(255) NOT NULL,
            role VARCHAR(20) NOT NULL DEFAULT 'staf_admin' CHECK(role IN ('superadmin','direktur','bendahara','staf_admin','customer')),
            remember_token VARCHAR(100) NULL,
            created_at DATETIME NULL,
            updated_at DATETIME NULL
        )");
        
        // Langkah 3: Salin semua data dari tabel lama ke tabel baru
        DB::statement("INSERT INTO users_new (id, name, email, email_verified_at, password, role, remember_token, created_at, updated_at)
            SELECT id, name, email, email_verified_at, password, role, remember_token, created_at, updated_at FROM users");
        
        // Langkah 4: Hapus tabel lama dan rename tabel baru
        DB::statement("DROP TABLE users");
        DB::statement("ALTER TABLE users_new RENAME TO users");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke enum lama jika rollback
        DB::statement("UPDATE users SET role = 'staff_gudang' WHERE role = 'staf_admin'");
        DB::statement("UPDATE users SET role = 'staff_gudang' WHERE role IN ('direktur','bendahara','customer')");
        
        DB::statement("CREATE TABLE users_old (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            email_verified_at DATETIME NULL,
            password VARCHAR(255) NOT NULL,
            role VARCHAR(20) NOT NULL DEFAULT 'staff_gudang' CHECK(role IN ('superadmin','staff_gudang')),
            remember_token VARCHAR(100) NULL,
            created_at DATETIME NULL,
            updated_at DATETIME NULL
        )");
        
        DB::statement("INSERT INTO users_old (id, name, email, email_verified_at, password, role, remember_token, created_at, updated_at)
            SELECT id, name, email, email_verified_at, password, role, remember_token, created_at, updated_at FROM users");
        
        DB::statement("DROP TABLE users");
        DB::statement("ALTER TABLE users_old RENAME TO users");
    }
};
