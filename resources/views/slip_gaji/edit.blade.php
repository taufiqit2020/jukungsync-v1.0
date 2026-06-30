@extends('layouts.admin')

@section('title', 'Edit Slip Gaji')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Slip Gaji</h1>
            <p class="text-sm text-gray-600">Perbarui rincian gaji karyawan</p>
        </div>
        <a href="{{ route('slip-gaji.index') }}" class="text-gray-600 hover:text-gray-850 hover:bg-gray-100 font-medium px-4 py-2 rounded-lg inline-flex items-center gap-2 border border-gray-200 transition-all">
            ← Kembali
        </a>
    </div>

    @if($errors->any())
    <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 p-4 mb-6 rounded shadow-sm">
        <ul class="list-disc list-inside text-sm">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('slip-gaji.update', $slipGaji->id) }}" method="POST" id="salaryForm" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-base font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2 flex items-center gap-2">
                <span class="bg-indigo-100 text-indigo-700 w-6 h-6 rounded-full inline-flex items-center justify-center text-xs font-black">1</span>
                Informasi Karyawan
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nomor Slip</label>
                    <input type="text" value="{{ $slipGaji->nomor_slip }}" disabled class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm font-mono font-bold text-gray-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Lengkap Karyawan</label>
                    <input type="text" name="nama_karyawan" value="{{ old('nama_karyawan', $slipGaji->nama_karyawan) }}" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Jabatan</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan', $slipGaji->jabatan) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Periode</label>
                    <input type="text" name="periode" value="{{ old('periode', $slipGaji->periode) }}" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pendapatan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-base font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2 flex items-center gap-2">
                    <span class="bg-emerald-100 text-emerald-700 w-6 h-6 rounded-full inline-flex items-center justify-center text-xs font-black">2</span>
                    Pendapatan (Earning)
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Gaji Pokok (Rp)</label>
                        <input type="number" name="gaji_pokok" id="gaji_pokok" value="{{ old('gaji_pokok', (int) $slipGaji->gaji_pokok) }}" required min="0" class="calc-trigger w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Lembur (Rp)</label>
                        <input type="number" name="lembur" id="lembur" value="{{ old('lembur', (int) $slipGaji->lembur) }}" min="0" class="calc-trigger w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tunjangan / Bonus (Rp)</label>
                        <input type="number" name="tunjangan_bonus" id="tunjangan_bonus" value="{{ old('tunjangan_bonus', (int) $slipGaji->tunjangan_bonus) }}" min="0" class="calc-trigger w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Potongan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-base font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2 flex items-center gap-2">
                    <span class="bg-rose-100 text-rose-700 w-6 h-6 rounded-full inline-flex items-center justify-center text-xs font-black">3</span>
                    Potongan (Deduction)
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">BPJS Kesehatan (Rp)</label>
                        <input type="number" name="bpjs_kesehatan" id="bpjs_kesehatan" value="{{ old('bpjs_kesehatan', (int) $slipGaji->bpjs_kesehatan) }}" min="0" class="calc-trigger w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">BPJS Ketenagakerjaan (Rp)</label>
                        <input type="number" name="bpjs_ketenagakerjaan" id="bpjs_ketenagakerjaan" value="{{ old('bpjs_ketenagakerjaan', (int) $slipGaji->bpjs_ketenagakerjaan) }}" min="0" class="calc-trigger w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                </div>
            </div>
        </div>

        <!-- Kalkulator Instan -->
        <div class="bg-gradient-to-r from-indigo-900 to-slate-900 rounded-xl p-6 text-white flex flex-col md:flex-row items-center justify-between gap-4 shadow-md">
            <div>
                <p class="text-xs font-bold text-indigo-300 uppercase tracking-wider">Total Pendapatan Bersih</p>
                <h3 class="text-2xl font-black mt-1" id="gaji_bersih_display">Rp 0</h3>
            </div>
            <div class="flex flex-col text-right text-xs opacity-75 border-l border-white border-opacity-20 pl-4">
                <span id="calc_pendapatan">Total Pendapatan: Rp 0</span>
                <span id="calc_potongan" class="mt-1">Total Potongan: Rp 0</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Catatan Keterangan (Opsional)</label>
            <textarea name="catatan" rows="3" placeholder="Tambahkan catatan jika diperlukan..." class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('catatan', $slipGaji->catatan) }}</textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('slip-gaji.index') }}" class="bg-gray-150 hover:bg-gray-200 text-gray-700 font-medium px-6 py-2.5 rounded-lg text-sm transition-all border border-gray-200">
                Batal
            </a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-8 py-2.5 rounded-lg text-sm shadow-sm transition-all">
                Perbarui Slip Gaji
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
