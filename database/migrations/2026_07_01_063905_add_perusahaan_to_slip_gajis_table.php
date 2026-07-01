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
        Schema::table('slip_gajis', function (Blueprint $table) {
            $table->string('perusahaan')->default('PT. UTAMA MADANI RAYA')->after('nomor_slip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('slip_gajis', function (Blueprint $table) {
            $table->dropColumn('perusahaan');
        });
    }
};
