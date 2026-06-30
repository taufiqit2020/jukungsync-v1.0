<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlipGaji extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_slip',
        'nama_karyawan',
        'jabatan',
        'periode',
        'gaji_pokok',
        'lembur',
        'tunjangan_bonus',
        'bpjs_kesehatan',
        'bpjs_ketenagakerjaan',
        'total_gaji',
        'catatan',
    ];

    /**
     * Boot model to automatically generate slip number and calculate total salary
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // total_gaji = (gaji_pokok + lembur + tunjangan_bonus) - (bpjs_kesehatan + bpjs_ketenagakerjaan)
            $pendapatan = (float) $model->gaji_pokok + (float) $model->lembur + (float) $model->tunjangan_bonus;
            $potongan = (float) $model->bpjs_kesehatan + (float) $model->bpjs_ketenagakerjaan;
            $model->total_gaji = max(0, $pendapatan - $potongan);
        });
    }

    /**
     * Generate dynamic slip number
     */
    public static function generateSlipNumber()
    {
        $year = date('Y');
        $month = date('m');
        
        $latest = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();
            
        $nextNum = 1;
        if ($latest) {
            $parts = explode('/', $latest->nomor_slip);
            $lastSeq = end($parts);
            if (is_numeric($lastSeq)) {
                $nextNum = (int)$lastSeq + 1;
            }
        }
        
        return "SG/{$year}/{$month}/" . sprintf('%04d', $nextNum);
    }
}
