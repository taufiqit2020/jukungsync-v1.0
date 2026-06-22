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
}
