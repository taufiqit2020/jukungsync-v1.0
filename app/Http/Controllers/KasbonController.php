<?php

namespace App\Http\Controllers;

use App\Models\Kasbon;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasbonController extends Controller
{
    /**
     * Tampilkan list data kasbon dengan filter & ringkasan statistik
     */
    public function index(Request $request)
    {
        $query = Kasbon::with('invoice');

        // Filter: Status (lunas / belum_lunas)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter: Nama Klien / No. Invoice
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_klien', 'like', '%' . $search . '%')
                  ->orWhere('nomor_invoice', 'like', '%' . $search . '%');
            });
        }

        // Filter: Range Tanggal Kasbon
        if ($request->filled('dari')) {
            $query->whereDate('tanggal_kasbon', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_kasbon', '<=', $request->sampai);
        }

        // Hitung statistik (sebelum paginasi)
        $totalPiutangBelumLunas = (clone $query)->where('status', 'belum_lunas')->sum('sisa_tagihan');
        $totalKasbonLunas       = (clone $query)->where('status', 'lunas')->sum('total_tagihan');
        $totalSeluruhKasbon     = (clone $query)->sum('total_tagihan');

        $kasbons = $query->orderBy('status', 'asc') // Tampilkan yang belum lunas di atas
            ->orderBy('tanggal_kasbon', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Calculate running balance (Piutang Lalu & Total Akumulasi) for each kasbon
        $kasbons->getCollection()->transform(function($kasbon) {
            $piutangLalu = Kasbon::where('status', 'belum_lunas')
                ->where(function($q) use ($kasbon) {
                    if ($kasbon->klien_id) {
                        $q->where('klien_id', $kasbon->klien_id);
                    } else {
                        $q->where('nama_klien', $kasbon->nama_klien);
                    }
                })
                ->where('id', '<', $kasbon->id)
                ->sum('sisa_tagihan');

            $kasbon->piutang_lalu = (float) $piutangLalu;
            $kasbon->total_sisa_akumulasi = (float) ($kasbon->sisa_tagihan + $piutangLalu);
            return $kasbon;
        });

        return view('kasbons.index', compact(
            'kasbons',
            'totalPiutangBelumLunas',
            'totalKasbonLunas',
            'totalSeluruhKasbon'
        ));
    }

    /**
     * Proses pembayaran / pelunasan kasbon
     */
    public function bayar(Request $request, Kasbon $kasbon)
    {
        if ($kasbon->status === 'lunas') {
            return back()->with('error', 'Kasbon ini sudah lunas.');
        }

        // Hitung piutang lalu untuk validasi max nominal bayar
        $piutangLalu = Kasbon::where('status', 'belum_lunas')
            ->where(function($q) use ($kasbon) {
                if ($kasbon->klien_id) {
                    $q->where('klien_id', $kasbon->klien_id);
                } else {
                    $q->where('nama_klien', $kasbon->nama_klien);
                }
            })
            ->where('id', '<', $kasbon->id)
            ->sum('sisa_tagihan');
        
        $maxBayar = (float) ($kasbon->sisa_tagihan + $piutangLalu);

        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:1|max:' . $maxBayar,
            'tanggal_bayar' => 'required|date',
            'keterangan_pembayaran' => 'nullable|string|max:255',
        ]);

        $jumlahBayar = (float) $request->jumlah_bayar;

        try {
            DB::transaction(function () use ($kasbon, $jumlahBayar, $request) {
                $sisaBayar = $jumlahBayar;

                // Ambil semua kasbon belum lunas milik customer ini yang ID <= $kasbon->id (urut terlama lebih dulu - FIFO)
                $unpaidKasbons = Kasbon::where('status', 'belum_lunas')
                    ->where(function($q) use ($kasbon) {
                        if ($kasbon->klien_id) {
                            $q->where('klien_id', $kasbon->klien_id);
                        } else {
                            $q->where('nama_klien', $kasbon->nama_klien);
                        }
                    })
                    ->where('id', '<=', $kasbon->id)
                    ->orderBy('id', 'asc')
                    ->get();

                foreach ($unpaidKasbons as $k) {
                    if ($sisaBayar <= 0) break;

                    $alokasi = min($sisaBayar, (float)$k->sisa_tagihan);
                    $newDibayar = (float)$k->jumlah_dibayar + $alokasi;
                    $newSisa = (float)$k->sisa_tagihan - $alokasi;
                    $sisaBayar -= $alokasi;

                    $updateData = [
                        'jumlah_dibayar' => $newDibayar,
                        'sisa_tagihan'   => $newSisa,
                    ];

                    if ($newSisa <= 0) {
                        $updateData['status']        = 'lunas';
                        $updateData['tanggal_lunas'] = $request->tanggal_bayar;
                        
                        $inv = Invoice::find($k->invoice_id);
                        if ($inv) {
                            $inv->update(['status_pembayaran' => 'lunas']);
                        }
                    }

                    $catatanTambahan = "\n- Dibayar Rp " . number_format($alokasi, 0, ',', '.') . " pada " . date('d/m/Y', strtotime($request->tanggal_bayar)) . " (" . ($request->keterangan_pembayaran ?: 'Pembayaran Kasbon') . ")";
                    $updateData['keterangan'] = $k->keterangan . $catatanTambahan;

                    $k->update($updateData);
                }
            });

            return back()->with('success', 'Pembayaran kasbon sebesar Rp ' . number_format($jumlahBayar, 0, ',', '.') . ' berhasil dicatat.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus data kasbon (Superadmin only)
     */
    public function destroy(Kasbon $kasbon)
    {
        try {
            DB::transaction(function () use ($kasbon) {
                // Jika dihapus, kembalikan status_pembayaran invoice terkait menjadi belum lunas (jika lunas)
                $invoice = Invoice::find($kasbon->invoice_id);
                if ($invoice && $invoice->status_pembayaran === 'lunas') {
                    $invoice->update([
                        'status_pembayaran' => 'belum_lunas'
                    ]);
                }
                $kasbon->delete();
            });

            return back()->with('success', 'Data kasbon berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus kasbon: ' . $e->getMessage());
        }
    }
}
