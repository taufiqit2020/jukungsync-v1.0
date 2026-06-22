<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel kasbon untuk mencatat piutang customer
     * yang belum lunas dari pesanan online.
     */
    public function up(): void
    {
        Schema::create('kasbons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');          // relasi ke invoices
            $table->unsignedBigInteger('klien_id')->nullable(); // relasi ke users (customer)
            $table->string('nama_klien');
            $table->string('nomor_invoice');
            $table->decimal('total_tagihan', 15, 2)->default(0);
            $table->decimal('jumlah_dibayar', 15, 2)->default(0);
            $table->decimal('sisa_tagihan', 15, 2)->default(0);
            $table->enum('status', ['belum_lunas', 'lunas'])->default('belum_lunas');
            $table->date('tanggal_kasbon');
            $table->date('tanggal_lunas')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kasbons');
    }
};
