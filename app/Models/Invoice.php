<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

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
     * Relasi ke User (Klien) melalui klien_id
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'klien_id');
    }

    /**
     * Alias klien -> customer
     */
    public function klien(): BelongsTo
    {
        return $this->belongsTo(User::class, 'klien_id');
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

    /**
     * Generate nomor invoice otomatis berdasarkan Nama Klien / Instansi
     * 1. Rumah Sakit / RSU / RS: RS-[SINGKATAN]-[NNN]/UMAR/[BULAN]/[TAHUN]
     * 2. Café: CF-[SINGKATAN/KODE]-[NNN]/UMAR/[BULAN]/[TAHUN]
     * 3. Rumah Makan: RM-[NAMA KLIEN]-[NNN]/UMAR/[BULAN]/[TAHUN]
     */
    public static function generateDynamicNumber($customerName, $nextId = null)
    {
        if (!$nextId) {
            $lastInvoice = self::latest('id')->first();
            $nextId = $lastInvoice ? $lastInvoice->id + 1 : 1;
        }

        $romanMap = [1=>'I', 2=>'II', 3=>'III', 4=>'IV', 5=>'V', 6=>'VI', 7=>'VII', 8=>'VIII', 9=>'IX', 10=>'X', 11=>'XI', 12=>'XII'];
        $monthRoman = $romanMap[(int)date('n')];
        $year = date('Y');
        $numStr = sprintf('%03d', $nextId);

        $name = strtoupper(trim($customerName ?? ''));
        if (empty($name)) {
            return "{$numStr}/UMAR/{$monthRoman}/{$year}";
        }

        $cleanName = preg_replace('/\b(PT|CV|UD|TB)\b/i', '', $name);
        $cleanName = trim($cleanName);

        // 1. RUMAH SAKIT / RSU / RS
        if (preg_match('/\b(RUMAH\s*SAKIT|RSU|RS)\b/i', $cleanName)) {
            $core = preg_replace('/\b(RUMAH\s*SAKIT|RSU|RS)\b/i', '', $cleanName);
            $core = trim(preg_replace('/[^A-Z0-9\s]/i', '', $core));
            $words = array_values(array_filter(explode(' ', $core)));
            $code = !empty($words) ? $words[0] : 'RS';
            return "RS-{$code}-{$numStr}/UMAR/{$monthRoman}/{$year}";
        }

        // 2. CAFÉ / CAFE / KAFE
        if (preg_match('/\b(CAFÉ|CAFE|KAFE)\b/i', $cleanName)) {
            $core = preg_replace('/\b(CAFÉ|CAFE|KAFE)\b/i', '', $cleanName);
            $core = trim(preg_replace('/[^A-Z0-9\s]/i', '', $core));
            $words = array_values(array_filter(explode(' ', $core)));
            $code = 'CF';
            if (!empty($words)) {
                $w = $words[0];
                if ($w === 'MARINA') $code = 'MRN';
                else $code = strlen($w) > 3 ? substr($w, 0, 3) : $w;
            }
            return "CF-{$code}-{$numStr}/UMAR/{$monthRoman}/{$year}";
        }

        // 3. RUMAH MAKAN / RM
        if (preg_match('/\b(RUMAH\s*MAKAN|RM|RESTO|RESTORAN)\b/i', $cleanName)) {
            $core = preg_replace('/\b(RUMAH\s*MAKAN|RM|RESTO|RESTORAN)\b/i', '', $cleanName);
            $core = trim(preg_replace('/[^A-Z0-9\s\-]/i', '', $core));
            $code = !empty($core) ? $core : 'RM';
            return "RM-{$code}-{$numStr}/UMAR/{$monthRoman}/{$year}";
        }

        // Default untuk customer lain
        return "{$numStr}/UMAR/{$monthRoman}/{$year}";
    }
}

