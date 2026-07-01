<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Gaji Karyawan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;750;900&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: white;
            color: black;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        @media print {
            .no-print { display: none !important; }
            @page { 
                size: A4 landscape; 
                margin: 10mm 15mm; 
            }
            body { 
                margin: 0 !important; 
                padding: 0 !important;
                min-height: auto !important;
            }
            table, tr, td, th, tbody {
                page-break-inside: avoid;
            }
        }
        .table-border, .table-border th, .table-border td {
            border: 1px solid #000000;
        }
        .table-border th {
            background-color: #f3f4f6;
            font-weight: 800;
            text-transform: uppercase;
        }
    </style>
</head>
<body class="max-w-7xl mx-auto p-4 md:p-8 relative min-h-screen flex flex-col z-0">

    <!-- Tombol Print -->
    <div class="no-print mb-6 flex justify-end">
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold flex items-center shadow-md">
            🖨️ Cetak (Ctrl+P)
        </button>
    </div>

    @php
        $isFarma = ($perusahaan === 'PT. NUR MADANI FARMA');
    @endphp

    <!-- Kop Surat (Logo Perusahaan) -->
    <div class="w-full mb-6">
        @if($isFarma)
            <div class="flex items-center justify-between p-3 rounded" style="background-color: white; border-bottom: 3px double #064e3b; min-height: 60px; box-sizing: border-box;">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('img/logo-farma.png') }}" alt="Logo PT Nur Madani Farma" class="h-12 w-auto object-contain">
                    <div>
                        <h1 class="text-lg font-black tracking-wider uppercase m-0 leading-tight" style="color: #064e3b;">PT. NUR MADANI FARMA</h1>
                        <p class="text-[9px] font-semibold tracking-wide m-0 text-gray-500 leading-tight">Distributor &amp; Mitra Pengadaan Alat Kesehatan &amp; Farmasi</p>
                    </div>
                </div>
                <div class="text-right text-[9px] leading-relaxed text-gray-600 font-medium">
                    <div>WhatsApp: 0851-6665-7070</div>
                    <div>Email: ptnurmadanifarma@gmail.com</div>
                </div>
            </div>
        @else
            <img src="{{ asset('img/invoice-header.png') }}" alt="Kop Surat PT UMAR" class="w-full h-auto object-contain">
        @endif
    </div>

    <!-- Judul Laporan -->
    <div class="text-center mb-6">
        <h2 class="text-base font-black uppercase tracking-wider">LAPORAN GAJI KARYAWAN</h2>
        <p class="text-xs text-gray-600 font-medium mt-1">
            Perusahaan: {{ $perusahaan ?? 'Semua Perusahaan' }} &bull; Periode: {{ $periode ?? 'Semua Periode' }}
        </p>
    </div>

    <!-- Table -->
    <table class="w-full text-left text-[10px] table-border">
        <thead>
            <tr class="text-center font-bold">
                <th class="px-3 py-2.5 w-10">No</th>
                <th class="px-3 py-2.5 w-32">Nomor Slip</th>
                <th class="px-3 py-2.5 w-40">Perusahaan</th>
                <th class="px-3 py-2.5">Nama Karyawan</th>
                <th class="px-3 py-2.5">Jabatan</th>
                <th class="px-3 py-2.5 w-20">Periode</th>
                <th class="px-3 py-2.5 text-right w-24">Pendapatan (A)</th>
                <th class="px-3 py-2.5 text-right w-24">Potongan (B)</th>
                <th class="px-3 py-2.5 text-right w-28">Gaji Bersih</th>
            </tr>
        </thead>
        <tbody>
            @forelse($slipGajis as $idx => $slip)
            @php
                $gapok = $slip->gaji_pokok;
                $lembur = $slip->lembur;
                $tunjangan = $slip->tunjangan_bonus;
                $bpjsKes = $slip->bpjs_kesehatan;
                $bpjsKet = $slip->bpjs_ketenagakerjaan;
                
                $pendapatan = $gapok + $lembur + $tunjangan;
                $potongan = $bpjsKes + $bpjsKet;
            @endphp
            <tr>
                <td class="px-3 py-2 text-center font-bold text-gray-500">{{ $idx + 1 }}</td>
                <td class="px-3 py-2 font-mono font-bold">{{ $slip->nomor_slip }}</td>
                <td class="px-3 py-2 font-medium">{{ $slip->perusahaan ?? 'PT. UTAMA MADANI RAYA' }}</td>
                <td class="px-3 py-2 font-bold">{{ $slip->nama_karyawan }}</td>
                <td class="px-3 py-2 text-gray-600">{{ $slip->jabatan ?? '-' }}</td>
                <td class="px-3 py-2 text-center">{{ $slip->periode }}</td>
                <td class="px-3 py-2 text-right">Rp {{ number_format($pendapatan, 0, ',', '.') }}</td>
                <td class="px-3 py-2 text-right text-red-600">Rp {{ number_format($potongan, 0, ',', '.') }}</td>
                <td class="px-3 py-2 text-right font-bold text-emerald-700">Rp {{ number_format($slip->total_gaji, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="px-3 py-8 text-center text-gray-500 font-medium">Belum ada data slip gaji pada periode ini.</td>
            </tr>
            @endforelse
            
            @if($slipGajis->count() > 0)
            <tr class="font-bold bg-gray-50">
                <td colspan="6" class="px-3 py-3 text-right uppercase tracking-wider">TOTAL KESELURUHAN</td>
                <td class="px-3 py-3 text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                <td class="px-3 py-3 text-right text-red-600">Rp {{ number_format($totalPotongan, 0, ',', '.') }}</td>
                <td class="px-3 py-3 text-right text-emerald-700 text-xs">Rp {{ number_format($totalGaji, 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <!-- Tanda Tangan Laporan -->
    <div class="mt-8 mb-4 relative z-10 w-full">
        <div class="flex justify-between text-[10px] font-bold text-center">
            <div class="w-48">
                <!-- Spacer for layout -->
            </div>
            <div class="w-64">
                <p class="uppercase mb-16">DIREKTUR</p>
                <p class="font-bold uppercase pb-0.5 border-b border-black inline-block w-full">HJ. NORMAULIDA, S.H.</p>
            </div>
        </div>
    </div>

</body>
</html>
