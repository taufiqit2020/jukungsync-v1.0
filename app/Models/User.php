<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'perusahaan', 'alamat', 'nomor_hp', 'tipe_pelanggan', 'foto_ktp', 'otp_method'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ============================================================
    // TIER PRICING HELPERS
    // Tipe: reguler | member | premium
    // ============================================================

    /**
     * Persentase diskon tambahan di atas harga grosir.
     * Reguler: 0%  | Member: 0.2%  | Premium: 0.3%
     */
    public function getDiskonRate(): float
    {
        return match($this->tipe_pelanggan) {
            'member'  => 0.002,  // 0.2%
            'premium' => 0.003,  // 0.3%
            default   => 0.0,
        };
    }

    /**
     * Apakah pelanggan berhak mendapat harga grosir?
     * - Member: hanya jika qty >= 12 pcs
     * - Premium: selalu berhak (tanpa syarat qty)
     * - Reguler: tidak pernah
     */
    public function isEligibleGrosir(int $qty = 0): bool
    {
        return match($this->tipe_pelanggan) {
            'member'  => $qty >= 12,
            'premium' => true,
            default   => false,
        };
    }

    /**
     * Apakah pelanggan bisa menggunakan metode Invoice 30 Hari?
     * Hanya Premium yang diperbolehkan.
     */
    public function canUseInvoice30(): bool
    {
        return $this->tipe_pelanggan === 'premium';
    }

    /**
     * Apakah pelanggan DIBLOKIR dari metode Invoice 30 Hari?
     * Blokir terjadi jika ada invoice online dengan metode 'invoice_30_hari'
     * yang status_pembayaran = 'belum_lunas' DAN sudah melewati
     * tanggal_jatuh_tempo + 3 hari masa tenggang.
     *
     * Jika diblokir, customer hanya bisa memilih Tunai atau Transfer.
     */
    public function hasBlockedInvoice(): bool
    {
        $grace = now()->subDays(0); // hari ini
        $blocked = \App\Models\Invoice::where('klien_id', $this->id)
            ->where('jenis_transaksi', 'online')
            ->where('metode_pembayaran', 'invoice_30_hari')
            ->where('status_pembayaran', 'belum_lunas')
            ->whereNotNull('tanggal_jatuh_tempo')
            ->whereRaw('DATE(tanggal_jatuh_tempo, "+3 days") < DATE("now")')
            ->exists();
        return $blocked;
    }

    /**
     * Hitung harga akhir per item berdasarkan tier pelanggan.
     * Harga grosir (jika eligible) dikurangi diskon tier.
     */
    public function getFinalPrice(float $hargaJual, float $hargaGrosir, int $qty): float
    {
        if ($this->isEligibleGrosir($qty) && $hargaGrosir > 0) {
            // Terapkan diskon tier di atas harga grosir
            return $hargaGrosir * (1 - $this->getDiskonRate());
        }
        return $hargaJual;
    }

    /**
     * Label tier untuk ditampilkan di UI.
     */
    public function getTierLabel(): string
    {
        return match($this->tipe_pelanggan) {
            'member'  => 'Member',
            'premium' => 'Premium',
            default   => 'Reguler',
        };
    }

    /**
     * Warna badge tier untuk UI.
     */
    public function getTierBadgeClass(): string
    {
        return match($this->tipe_pelanggan) {
            'member'  => 'bg-blue-100 text-blue-800 border-blue-200',
            'premium' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            default   => 'bg-gray-100 text-gray-700 border-gray-200',
        };
    }
    /**
     * Hitung total nominal pembelian dari semua pesanan online customer ini.
     * Menggunakan total_tagihan dari semua invoice online (semua status pesanan).
     */
    public function getTotalPembelian(): float
    {
        return (float) \App\Models\Invoice::where('klien_id', $this->id)
            ->where('jenis_transaksi', 'online')
            ->sum('total_tagihan');
    }

    /**
     * Cek total pembelian dan upgrade tier otomatis jika threshold terpenuhi.
     *
     * Aturan:
     * - Reguler → Member  : total pembelian >= Rp 500.000
     * - Member  → Premium : total pembelian >= Rp 2.300.000
     *
     * Tier hanya naik, tidak turun.
     * Mengembalikan label tier baru jika terjadi upgrade, atau null jika tidak ada perubahan.
     */
    public function checkAndUpgradeTier(): ?string
    {
        $tierSaatIni = $this->tipe_pelanggan ?? 'reguler';

        // Sudah Premium — tidak perlu dicek lagi
        if ($tierSaatIni === 'premium') {
            return null;
        }

        $total = $this->getTotalPembelian();

        // Tentukan tier baru berdasarkan total pembelian
        $tierBaru = null;
        if ($total >= 2_300_000) {
            $tierBaru = 'premium';
        } elseif ($total >= 500_000) {
            $tierBaru = 'member';
        }

        // Upgrade hanya jika tier baru lebih tinggi dari tier sekarang
        $urutanTier = ['reguler' => 0, 'member' => 1, 'premium' => 2];
        if ($tierBaru && ($urutanTier[$tierBaru] ?? 0) > ($urutanTier[$tierSaatIni] ?? 0)) {
            $this->tipe_pelanggan = $tierBaru;
            $this->save();
            return $this->getTierLabel();
        }

        return null;
    }
}
