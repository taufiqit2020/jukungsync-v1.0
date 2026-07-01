@extends('layouts.admin')

@section('title', 'Buat Slip Gaji Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    {{-- ===== HEADER ===== --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('slip-gaji.index') }}" class="p-2 bg-white text-gray-500 hover:text-gray-900 rounded-xl shadow-sm border border-gray-200 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Buat Slip Gaji Baru</h1>
            <p class="text-sm text-gray-500">Buat rincian gaji baru untuk karyawan.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="bg-red-50 text-red-600 p-4 rounded-xl border border-red-100 mb-6">
        <ul class="list-disc pl-5 text-sm font-medium">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('slip-gaji.store') }}" method="POST" id="salaryForm" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-6">
        @csrf
        
        {{-- Section 1: Personal Info --}}
        <div>
            <h2 class="text-xs font-extrabold text-gray-400 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full" style="background:#7f1d1d;"></span>
                Informasi Karyawan
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Perusahaan</label>
                    <select name="perusahaan" required
                            class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 focus:bg-white focus:border-tema-marun focus:ring-2 focus:ring-tema-marun/20 outline-none transition-all font-semibold">
                        <option value="PT. UTAMA MADANI RAYA" {{ old('perusahaan') == 'PT. UTAMA MADANI RAYA' ? 'selected' : '' }}>PT. UTAMA MADANI RAYA</option>
                        <option value="PT. NUR MADANI FARMA" {{ old('perusahaan') == 'PT. NUR MADANI FARMA' ? 'selected' : '' }}>PT. NUR MADANI FARMA</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Slip Gaji</label>
                    <input type="text" value="{{ $nomorSlip }}" disabled
                           class="w-full border px-4 py-3 bg-gray-100 rounded-xl border-gray-200 font-mono font-bold text-gray-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap Karyawan</label>
                    <input type="text" name="nama_karyawan" value="{{ old('nama_karyawan') }}" required placeholder="Contoh: Budi Santoso"
                           class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 focus:bg-white focus:border-tema-marun focus:ring-2 focus:ring-tema-marun/20 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jabatan</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan') }}" placeholder="Contoh: Staf Administrasi"
                           class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 focus:bg-white focus:border-tema-marun focus:ring-2 focus:ring-tema-marun/20 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Periode Slip Gaji</label>
                    <input type="text" name="periode" value="{{ old('periode', \Carbon\Carbon::now()->translatedFormat('F Y')) }}" required placeholder="Contoh: Juni 2026"
                           class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 focus:bg-white focus:border-tema-marun focus:ring-2 focus:ring-tema-marun/20 outline-none transition-all">
                </div>
            </div>
        </div>

        {{-- Section 2: Earnings & Deductions --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
            <!-- Pendapatan -->
            <div class="space-y-4">
                <h2 class="text-xs font-extrabold text-emerald-600 uppercase tracking-wider pb-2 border-b border-gray-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Pendapatan (Earnings)
                </h2>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Gaji Pokok (Rp)</label>
                    <input type="number" name="gaji_pokok" id="gaji_pokok" value="{{ old('gaji_pokok', 0) }}" required min="0"
                           class="calc-trigger w-full border px-4 py-2.5 bg-gray-50 rounded-xl border-gray-300 font-semibold focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Lembur (Rp)</label>
                    <input type="number" name="lembur" id="lembur" value="{{ old('lembur', 0) }}" min="0"
                           class="calc-trigger w-full border px-4 py-2.5 bg-gray-50 rounded-xl border-gray-300 font-semibold focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Tunjangan / Bonus (Rp)</label>
                    <input type="number" name="tunjangan_bonus" id="tunjangan_bonus" value="{{ old('tunjangan_bonus', 0) }}" min="0"
                           class="calc-trigger w-full border px-4 py-2.5 bg-gray-50 rounded-xl border-gray-300 font-semibold focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all">
                </div>
            </div>

            <!-- Potongan -->
            <div class="space-y-4">
                <h2 class="text-xs font-extrabold text-rose-600 uppercase tracking-wider pb-2 border-b border-gray-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                    Potongan (Deductions)
                </h2>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">BPJS Kesehatan (Rp)</label>
                    <input type="number" name="bpjs_kesehatan" id="bpjs_kesehatan" value="{{ old('bpjs_kesehatan', 0) }}" min="0"
                           class="calc-trigger w-full border px-4 py-2.5 bg-gray-50 rounded-xl border-gray-300 font-semibold focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">BPJS Ketenagakerjaan (Rp)</label>
                    <input type="number" name="bpjs_ketenagakerjaan" id="bpjs_ketenagakerjaan" value="{{ old('bpjs_ketenagakerjaan', 0) }}" min="0"
                           class="calc-trigger w-full border px-4 py-2.5 bg-gray-50 rounded-xl border-gray-300 font-semibold focus:bg-white focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 outline-none transition-all">
                </div>
            </div>
        </div>

        {{-- Section 3: Gaji Bersih Banner --}}
        <div class="rounded-2xl p-5 flex flex-col sm:flex-row justify-between items-center gap-4 text-white shadow-md"
             style="background:linear-gradient(135deg,#7f1d1d,#1e293b);">
            <div>
                <p style="font-size:0.65rem;font-weight:800;color:#fecaca;text-transform:uppercase;letter-spacing:0.08em;">Total Gaji Bersih Diterima (Estimasi)</p>
                <h3 class="text-2xl font-black mt-1" id="gaji_bersih_display">Rp 0</h3>
            </div>
            <div class="text-right text-xs border-t sm:border-t-0 sm:border-l border-white/20 pt-3 sm:pt-0 sm:pl-5 flex flex-col gap-1 w-full sm:w-auto opacity-80">
                <span id="calc_pendapatan">Total Pendapatan: Rp 0</span>
                <span id="calc_potongan">Total Potongan: Rp 0</span>
            </div>
        </div>

        {{-- Section 4: Notes --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Tambahan (Opsional)</label>
            <textarea name="catatan" rows="3" placeholder="Tuliskan keterangan tambahan jika diperlukan..."
                      class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 focus:bg-white focus:border-tema-marun focus:ring-2 focus:ring-tema-marun/20 outline-none transition-all">{{ old('catatan') }}</textarea>
        </div>

        {{-- Section 5: Buttons --}}
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('slip-gaji.index') }}"
               class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-3 text-white font-bold rounded-xl shadow-md hover:opacity-90 transition-all flex items-center gap-2"
                    style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Simpan Slip Gaji
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const calcTriggers = document.querySelectorAll('.calc-trigger');
    const displayGajiBersih = document.getElementById('gaji_bersih_display');
    const displayPendapatan = document.getElementById('calc_pendapatan');
    const displayPotongan = document.getElementById('calc_potongan');

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(number);
    }

    function calculateSalary() {
        const gapok = parseFloat(document.getElementById('gaji_pokok').value) || 0;
        const lembur = parseFloat(document.getElementById('lembur').value) || 0;
        const tunjangan = parseFloat(document.getElementById('tunjangan_bonus').value) || 0;
        
        const bpjsKes = parseFloat(document.getElementById('bpjs_kesehatan').value) || 0;
        const bpjsKet = parseFloat(document.getElementById('bpjs_ketenagakerjaan').value) || 0;

        const totalPendapatan = gapok + lembur + tunjangan;
        const totalPotongan = bpjsKes + bpjsKet;
        const totalGajiBersih = Math.max(0, totalPendapatan - totalPotongan);

        displayGajiBersih.textContent = formatRupiah(totalGajiBersih);
        displayPendapatan.textContent = 'Total Pendapatan: ' + formatRupiah(totalPendapatan);
        displayPotongan.textContent = 'Total Potongan: ' + formatRupiah(totalPotongan);
    }

    calcTriggers.forEach(input => {
        input.addEventListener('input', calculateSalary);
    });

    calculateSalary();
});
</script>
@endsection
