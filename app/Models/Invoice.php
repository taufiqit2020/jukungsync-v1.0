<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'nomor_invoice',
        'klien_id',
        'nama_klien',
        'tanggal_invoice',
        'tanggal_jatuh_tempo',
        'sub_total',
        'pajak_ppn',
        'total_tagihan',
        'status_pembayaran',
        'jenis_transaksi',
        'status_pesanan',
        'catatan',
        'bukti_file',
        'bukti_keterangan',
        'alamat_pengiriman',
        'ekspedisi',
        'catatan_pengiriman',
        'ongkir',
        'metode_pembayaran',
        'diskon_persen',
        'total_diskon',
    ];

    protected $casts = [
        'tanggal_invoice' => 'date',
        'tanggal_jatuh_tempo' => 'date',
    ];

    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Scope a query to only include completed invoices.
     * Manual invoices are considered completed immediately.
     * Online invoices are considered completed only if status_pesanan is 'selesai'.
     */
    public function scopeCompleted($query)
    {
        return $query->where(function($q) {
            $q->whereNull('jenis_transaksi')
              ->orWhere('jenis_transaksi', '!=', 'online')
              ->orWhere(function($subQ) {
                  $subQ->where('jenis_transaksi', 'online')
                       ->where('status_pesanan', 'selesai');
              });
        });
    }
}
