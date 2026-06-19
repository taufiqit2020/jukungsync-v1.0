<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryMovement extends Model
{
    protected $fillable = [
        'product_id',
        'tipe_pergerakan',
        'jumlah',
        'tanggal',
        'keterangan',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
