<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kasbon extends Model
{
    protected $fillable = [
        'invoice_id',
        'klien_id',
        'nama_klien',
        'nomor_invoice',
        'total_tagihan',
        'jumlah_dibayar',
        'sisa_tagihan',
        'status',
        'tanggal_kasbon',
        'tanggal_lunas',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_kasbon' => 'date',
        'tanggal_lunas'  => 'date',
        'total_tagihan'  => 'decimal:2',
        'jumlah_dibayar' => 'decimal:2',
        'sisa_tagihan'   => 'decimal:2',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function klien(): BelongsTo
    {
        return $this->belongsTo(User::class, 'klien_id');
    }

    /**
     * Otomatis sinkronisasi data Kasbon dari Invoice
     */
    public static function syncFromInvoice(Invoice $invoice)
    {
        if (!$invoice || !$invoice->id) return;

        if ($invoice->status_pembayaran === 'lunas') {
            $kasbon = self::where('invoice_id', $invoice->id)->first();
            if ($kasbon) {
                $kasbon->update([
                    'status'         => 'lunas',
                    'jumlah_dibayar' => $invoice->total_tagihan,
                    'sisa_tagihan'   => 0,
                    'tanggal_lunas'  => $kasbon->tanggal_lunas ?? now()->toDateString(),
                ]);
            }
        } else {
            // status_pembayaran === 'belum_lunas'
            $kasbon = self::where('invoice_id', $invoice->id)->first();
            if ($kasbon) {
                $sisa = max(0, $invoice->total_tagihan - $kasbon->jumlah_dibayar);
                $kasbon->update([
                    'klien_id'       => $invoice->klien_id,
                    'nama_klien'     => $invoice->nama_klien,
                    'nomor_invoice'  => $invoice->nomor_invoice,
                    'total_tagihan'  => $invoice->total_tagihan,
                    'sisa_tagihan'   => $sisa,
                    'status'         => $sisa <= 0 ? 'lunas' : 'belum_lunas',
                    'tanggal_kasbon' => $invoice->tanggal_invoice ? $invoice->tanggal_invoice->toDateString() : now()->toDateString(),
                ]);
            } else {
                self::create([
                    'invoice_id'     => $invoice->id,
                    'klien_id'       => $invoice->klien_id,
                    'nama_klien'     => $invoice->nama_klien,
                    'nomor_invoice'  => $invoice->nomor_invoice,
                    'total_tagihan'  => $invoice->total_tagihan,
                    'jumlah_dibayar' => 0,
                    'sisa_tagihan'   => $invoice->total_tagihan,
                    'status'         => 'belum_lunas',
                    'tanggal_kasbon' => $invoice->tanggal_invoice ? $invoice->tanggal_invoice->toDateString() : now()->toDateString(),
                    'keterangan'     => $invoice->catatan ?? ('Piutang Kasbon dari invoice ' . $invoice->nomor_invoice),
                ]);
            }
        }
    }
}

