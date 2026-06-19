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
        Schema::table('invoices', function (Blueprint $table) {
            $table->text('alamat_pengiriman')->nullable()->after('catatan');
            $table->string('ekspedisi')->nullable()->after('alamat_pengiriman');
            $table->text('catatan_pengiriman')->nullable()->after('ekspedisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['alamat_pengiriman', 'ekspedisi', 'catatan_pengiriman']);
        });
    }
};
