<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $slipGaji->nomor_slip }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: white;
            color: black;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            font-size: 11px;
        }
        @media print {
            .no-print { display: none !important; }
            @page { 
                size: A4 portrait; 
                margin-top: 8mm;
                margin-bottom: 22mm;
                margin-left: 10mm; 
                margin-right: 10mm; 
            }
            body { 
                margin: 0 !important; 
                padding: 0 !important;
                background-color: transparent !important;
            }
            .print-footer {
                position: fixed !important;
                bottom: 3mm !important;
                left: 0 !important;
                right: 0 !important;
                width: 100% !important;
                z-index: 50 !important;
            }
            .watermark { z-index: -1 !important; opacity: 0.08 !important; }
            .page-break-avoid { page-break-inside: avoid !important; }
        }
        @media screen {
            .print-footer {
                margin-top: 3rem;
                width: 100%;
            }
        }
        .my-table {
            border-collapse: collapse;
            width: 100%;
        }
        .my-table th, .my-table td {
            border: 1px solid #000000;
            padding: 8px 10px;
        }
        .my-table th {
            background-color: #f3f4f6;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.05em;
        }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.06;
            z-index: 0;
            width: 65%;
            max-width: 500px;
            pointer-events: none;
        }
    </style>
</head>
<body class="max-w-4xl mx-auto p-4 md:p-8 relative">

    <!-- Top Action Buttons (Hidden on print) -->
    <div class="no-print mb-6 flex justify-between items-center bg-slate-900 text-white p-4 rounded-xl shadow-md">
        <div>
            <h2 class="text-sm font-bold">Cetak Slip Gaji (A4 Epson L310)</h2>
            <p class="text-xs text-gray-400">Nomor: {{ $slipGaji->nomor_slip }} &bull; Periode: {{ $slipGaji->periode }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('slip-gaji.excel', $slipGaji->id) }}" class="bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5">
                📊 Download Excel
            </a>
            <a href="{{ route('slip-gaji.index') }}" class="bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded-lg text-xs font-bold transition-all">
                ← Kembali
            </a>
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5">
                🖨️ Cetak (Ctrl+P)
            </button>
        </div>
    </div>

    <!-- Watermark Background -->
    <img src="{{ asset('img/watermark-tengah.png') }}" alt="Watermark" class="watermark">

    <!-- Kop Surat Resmi -->
    <div class="w-full mb-6">
        <img src="{{ asset('img/invoice-header.png') }}" alt="Kop Surat PT UMAR" class="w-full h-auto object-contain">
    </div>

    <!-- Judul Dokumen -->
    <div class="text-center mb-6">
        <h2 class="text-lg font-black uppercase tracking-widest border-b border-black pb-1 inline-block">SLIP GAJI KARYAWAN</h2>
    </div>

    <!-- Informasi Detail Karyawan -->
    <div class="grid grid-cols-2 gap-8 mb-6 text-xs text-black border border-black p-4 rounded-lg bg-transparent relative z-10">
        <table class="w-full" style="border: none;">
            <tr class="align-top">
                <td class="w-24 font-bold py-1">No. Slip</td>
                <td class="w-4 py-1">:</td>
                <td class="font-semibold py-1">{{ $slipGaji->nomor_slip }}</td>
            </tr>
            <tr class="align-top">
                <td class="font-bold py-1">Periode</td>
                <td class="py-1">:</td>
                <td class="py-1">{{ $slipGaji->periode }}</td>
            </tr>
        </table>
        <table class="w-full" style="border: none;">
            <tr class="align-top">
                <td class="w-32 font-bold py-1">Nama Karyawan</td>
                <td class="w-4 py-1">:</td>
                <td class="font-semibold py-1">{{ $slipGaji->nama_karyawan }}</td>
            </tr>
            <tr class="align-top">
                <td class="font-bold py-1">Jabatan</td>
                <td class="py-1">:</td>
                <td class="py-1">{{ $slipGaji->jabatan ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- Side-by-Side Earnings and Deductions Tables -->
    <div class="flex justify-between items-start gap-4 mb-6 relative z-10">
        <!-- Pendapatan Table -->
        <div class="w-[49%]">
            <table class="my-table text-xs">
                <thead>
                    <tr>
                        <th class="text-left" style="width: 60%;">I. Pendapatan (Earnings)</th>
                        <th class="text-right" style="width: 40%;">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Gaji Pokok</td>
                        <td class="text-right font-semibold">{{ number_format($slipGaji->gaji_pokok, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Lembur</td>
                        <td class="text-right font-semibold">{{ number_format($slipGaji->lembur, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Tunjangan / Bonus</td>
                        <td class="text-right font-semibold">{{ number_format($slipGaji->tunjangan_bonus, 0, ',', '.') }}</td>
                    </tr>
                    @php
                        $totalPendapatan = $slipGaji->gaji_pokok + $slipGaji->lembur + $slipGaji->tunjangan_bonus;
                    @endphp
                    <tr class="font-bold bg-gray-55 bg-gray-50">
                        <td>Total Pendapatan (A)</td>
                        <td class="text-right" style="border-top: 1.5px solid #000000;">{{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Potongan Table -->
        <div class="w-[49%]">
            <table class="my-table text-xs">
                <thead>
                    <tr>
                        <th class="text-left" style="width: 60%;">II. Potongan (Deductions)</th>
                        <th class="text-right" style="width: 40%;">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>BPJS Kesehatan</td>
                        <td class="text-right font-semibold">{{ number_format($slipGaji->bpjs_kesehatan, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>BPJS Ketenagakerjaan</td>
                        <td class="text-right font-semibold">{{ number_format($slipGaji->bpjs_ketenagakerjaan, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="color: transparent;">-</td>
                        <td class="text-right font-semibold" style="color: transparent;">0</td>
                    </tr>
                    @php
                        $totalPotongan = $slipGaji->bpjs_kesehatan + $slipGaji->bpjs_ketenagakerjaan;
                    @endphp
                    <tr class="font-bold bg-gray-55 bg-gray-50">
                        <td>Total Potongan (B)</td>
                        <td class="text-right" style="border-top: 1.5px solid #000000;">{{ number_format($totalPotongan, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Gaji Bersih Display Banner -->
    <div class="mb-2 p-4 flex justify-between items-center bg-slate-900 text-white rounded-lg text-sm font-black uppercase tracking-wide relative z-10" style="background-color: #111827;">
        <span>Gaji Bersih Diterima (Net Salary) = A - B</span>
        <span class="text-base">Rp {{ number_format($slipGaji->total_gaji, 0, ',', '.') }}</span>
    </div>

    <!-- Terbilang -->
    <div class="text-xs italic font-bold border-b border-dashed border-black pb-2 mb-4 relative z-10">
        Terbilang: {{ \App\Helpers\TerbilangHelper::terbilang($slipGaji->total_gaji) }} Rupiah
    </div>

    <!-- Catatan -->
    @if($slipGaji->catatan)
    <div class="text-xs border border-dashed border-gray-400 p-2.5 rounded mb-6 relative z-10">
        <span class="font-bold">Catatan:</span> {{ $slipGaji->catatan }}
    </div>
    @endif

    <!-- Tanda Tangan (Direktur di kiri, Karyawan di kanan) -->
    <div class="mt-8 page-break-avoid relative z-10" style="margin-bottom: 20mm;">
        <div class="flex justify-between text-xs font-bold text-center">
            <div class="w-64">
                <p class="uppercase mb-20">DIREKTUR</p>
                <p class="border-b border-black font-bold uppercase pb-1 inline-block w-full">HJ. NORMAULIDA, S.H.</p>
            </div>
            <div class="w-64">
                <p class="uppercase mb-20">PENERIMA / KARYAWAN</p>
                <p class="border-b border-black font-bold uppercase pb-1 inline-block w-full">{{ $slipGaji->nama_karyawan }}</p>
            </div>
        </div>
    </div>

    <!-- Official Company Footer -->
    <div class="print-footer p-2 text-center text-xs font-semibold tracking-wide" style="border-radius: 4px; background-color: #111827; color: white; line-height: 1.5;">
        <div>Alamat Kantor : Jl. Panglima Batur Banjarbaru Utara, Banjarbaru Kalimantan Selatan</div>
        <div class="mt-0.5 text-gray-300 text-[10px]">
            <span>WhatsApp: 0851-6665-7171</span> &nbsp;|&nbsp;
            <span>Instagram: @pt_umar</span> &nbsp;|&nbsp;
            <span>Website: www.ptutamamadaniraya.com</span>
        </div>
    </div>

</body>
</html>
