<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Foto KTP (base64 atau path ke storage)
            $table->text('foto_ktp')->nullable()->after('nomor_hp');
            // Metode OTP yang dipilih saat registrasi: 'email' atau 'whatsapp'
            $table->string('otp_method', 20)->default('email')->after('foto_ktp');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['foto_ktp', 'otp_method']);
        });
    }
};
