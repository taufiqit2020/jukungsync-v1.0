<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_klien',
        'no_telp',
        'alamat',
        'email',
        'npwp',
        'tipe_customer',
        'keterangan',
    ];
}
