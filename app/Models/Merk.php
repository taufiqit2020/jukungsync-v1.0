<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merk extends Model
{
    protected $fillable = [
        'nama_merk',
        'slug',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
