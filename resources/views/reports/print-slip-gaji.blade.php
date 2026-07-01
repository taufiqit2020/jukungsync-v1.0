<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Gaji Karyawan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap');
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
            border: 1px solid #1e293b;
        }
        .table-border th {
            font-weight: 800;
        }
        .watermark-bg {
            position: absolute;
            top: 55%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: -10;
            pointer-events: none;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body class="max-w-7xl mx-auto p-4 md:p-8 relative min-h-screen flex flex-col z-0">

    <!-- Tombol Print -->
    <div class="no-print mb-6 flex justify-end">
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-xs font-bold flex items-center shadow-md transition-all">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Laporan (Ctrl+P)
        </button>
    </div>

    @php
        $isFarma = ($perusahaan === 'PT. NUR MADANI FARMA');
    @endphp

    <!-- Watermark Background -->
    @if($isFarma)
        <div class="watermark-bg">
            <img src="{{ asset('img/logo-farma.png') }}" alt="Watermark" style="opacity: 0.035; width: 450px;">
        </div>
    @else
        <div class="watermark-bg">
            <img src="{{ asset('img/watermark-tengah.png') }}" alt="Watermark" style="opacity: 0.06; width: 450px;">
        </div>
    @endif

    <!-- Kop Surat (Logo Perusahaan) -->
    <div class="w-full mb-6">
        @if($isFarma)
            <div class="flex items-center justify-between pb-3 border-b-2 border-emerald-800" style="min-height: 60px; box-sizing: border-box;">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('img/logo-farma.png') }}" alt="Logo PT Nur Madani Farma" class="h-14 w-auto object-contain">
                    <div>
                        <h1 class="text-xl font-black tracking-wider uppercase m-0 leading-tight" style="color: #064e3b;">PT. NUR MADANI FARMA</h1>
                        <p class="text-[9px] font-bold tracking-wide m-0 text-emerald-800 leading-tight">Distributor &amp; Mitra Pengadaan Alat Kesehatan &amp; Farmasi</p>
                        <p class="text-[8px] font-medium m-0 text-gray-500 mt-1">Jl. Panglima Batur No. 16, Kel. Komet, Kec. Banjarbaru Utara, Kota Banjarbaru, Kalsel 70714</p>
                    </div>
                </div>
                <div class="text-right text-[9px] leading-relaxed text-gray-600 font-semibold">
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
        <h2 class="text-sm font-black uppercase tracking-widest text-gray-900">LAPORAN GAJI KARYAWAN</h2>
        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mt-1">
            Perusahaan: {{ $perusahaan ?? 'Semua Perusahaan' }} &bull; Periode: {{ $periode ?? 'Semua Periode' }}
        </p>
    </div>

    <!-- Table -->
    <table class="w-full text-left text-[10px] table-border">
        <thead>
            <tr class="text-center font-bold text-[9px] uppercase tracking-wider" style="background-color: {{ $isFarma ? '#ecfdf5' : '#f8fafc' }}; color: {{ $isFarma ? '#064e3b' : '#1e293b' }};">
                <th class="px-3 py-2.5 w-10 text-center">No</th>
                <th class="px-3 py-2.5 w-36">Nomor Slip</th>
                <th class="px-3 py-2.5 w-44">Perusahaan</th>
                <th class="px-3 py-2.5">Nama Karyawan</th>
                <th class="px-3 py-2.5">Jabatan</th>
                <th class="px-3 py-2.5 w-24 text-center">Periode</th>
                <th class="px-3 py-2.5 text-right w-28">Pendapatan (A)</th>
                <th class="px-3 py-2.5 text-right w-28">Potongan (B)</th>
                <th class="px-3 py-2.5 text-right w-32">Gaji Bersih</th>
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
            <tr class="hover:bg-slate-50/30">
                <td class="px-3 py-2 text-center font-bold text-gray-400">{{ $idx + 1 }}</td>
                <td class="px-3 py-2 font-mono font-bold text-gray-900">{{ $slip->nomor_slip }}</td>
                <td class="px-3 py-2 font-medium text-gray-800">{{ $slip->perusahaan ?? 'PT. UTAMA MADANI RAYA' }}</td>
                <td class="px-3 py-2 font-bold text-gray-900">{{ $slip->nama_karyawan }}</td>
                <td class="px-3 py-2 text-gray-600 font-medium">{{ $slip->jabatan ?? '-' }}</td>
                <td class="px-3 py-2 text-center font-semibold text-gray-700">{{ $slip->periode }}</td>
                <td class="px-3 py-2 text-right font-medium text-gray-900">Rp {{ number_format($pendapatan, 0, ',', '.') }}</td>
                <td class="px-3 py-2 text-right font-medium text-rose-600">Rp {{ number_format($potongan, 0, ',', '.') }}</td>
                <td class="px-3 py-2 text-right font-black text-emerald-700">Rp {{ number_format($slip->total_gaji, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="px-3 py-12 text-center text-gray-500 font-bold">Belum ada data slip gaji pada periode ini.</td>
            </tr>
            @endforelse
            
            @if($slipGajis->count() > 0)
            <tr class="font-bold bg-slate-50/50">
                <td colspan="6" class="px-3 py-3 text-right uppercase tracking-wider text-gray-900">TOTAL KESELURUHAN</td>
                <td class="px-3 py-3 text-right text-gray-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                <td class="px-3 py-3 text-right text-rose-600">Rp {{ number_format($totalPotongan, 0, ',', '.') }}</td>
                <td class="px-3 py-3 text-right text-emerald-700 text-xs">Rp {{ number_format($totalGaji, 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <!-- Tanda Tangan Laporan -->
    <div class="mt-12 w-full flex justify-end mb-6">
        <div class="text-center w-64 mr-8 text-xs font-semibold">
            <p class="text-gray-700">Banjarbaru, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p class="uppercase font-bold mt-1 mb-16 text-gray-800">DIREKTUR</p>
            <p class="font-extrabold uppercase text-gray-900 border-b border-gray-900 pb-0.5 inline-block w-full">HJ. NORMAULIDA, S.H.</p>
        </div>
    </div>

    <!-- Official Report Footer -->
    <div class="mt-auto pt-4 border-t border-gray-300 text-center text-[8px] font-semibold text-gray-500 w-full">
        @if($isFarma)
            <p class="uppercase tracking-wider font-extrabold text-emerald-800">PT. NUR MADANI FARMA</p>
            <p class="mt-0.5 text-gray-400 font-medium">Jl. Panglima Batur No. 16, Kel. Komet, Kec. Banjarbaru Utara, Kota Banjarbaru, Kalsel 70714 &bull; WhatsApp: 0851-6665-7070 &bull; Email: ptnurmadanifarma@gmail.com</p>
        @else
            <p class="uppercase tracking-wider font-extrabold text-slate-800">PT. UTAMA MADANI RAYA</p>
            <p class="mt-0.5 text-gray-400 font-medium">Jl. Panglima Batur Banjarbaru Utara, Banjarbaru Kalimantan Selatan &bull; WhatsApp: 0851-6665-7171 &bull; Email: ptutamamadaniraya@gmail.com</p>
        @endif
    </div>

</body>
</html>
