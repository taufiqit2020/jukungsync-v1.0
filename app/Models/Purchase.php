<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_faktur',
        'nama_supplier',
        'tanggal_pembelian',
        'total_biaya',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pembelian' => 'date',
    ];

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
