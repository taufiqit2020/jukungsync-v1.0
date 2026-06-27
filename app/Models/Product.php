<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'merk_id',
        'sku',
        'nama_barang',
        'satuan',
        'deskripsi',
        'harga_modal',
        'harga_jual',
        'harga_grosir',
        'stok_saat_ini',
        'stok_minimum',
        'gambar',
        'gambar_tambahan',
    ];

    protected $casts = [
        'gambar_tambahan' => 'array',
    ];

    public function getAllImagesAttribute(): array
    {
        $images = [];
        if ($this->gambar) {
            $images[] = $this->gambar;
        }

        $tambahan = $this->gambar_tambahan;
        if (is_array($tambahan)) {
            foreach ($tambahan as $img) {
                if (!empty($img)) {
                    $images[] = $img;
                }
            }
        }

        return $images;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function merk(): BelongsTo
    {
        return $this->belongsTo(Merk::class);
    }

    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
