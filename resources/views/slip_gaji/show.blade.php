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
            background-color: #f3f4f6;
            color: black;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        @media print {
            .no-print { display: none !important; }
            body { 
                margin: 0 !important; 
                padding: 0 !important;
                background-color: white !important;
            }
            @page { 
                size: A4 landscape; 
                margin: 0;
            }
            .payslip-page {
                width: 297mm;
                height: 210mm;
                padding: 6mm 8mm;
                box-sizing: border-box;
                position: relative;
                background-color: white !important;
            }
        }
        @media screen {
            .payslip-page {
                background-color: white;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                border-radius: 0.75rem;
                width: 297mm;
                height: 210mm;
                padding: 6mm 8mm;
                margin: 2rem auto;
                box-sizing: border-box;
                position: relative;
            }
        }
        .payslip-container {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            position: relative;
        }
        .payslip-half {
            width: 48.5%;
            height: 198mm;
            box-sizing: border-box;
            position: relative;
        }
        .payslip-spacer {
            width: 3%;
            height: 100%;
        }
        .my-table {
            border-collapse: collapse;
            width: 100%;
        }
        .my-table th, .my-table td {
            border: 1px solid #000000;
            padding: 3px 6px;
            font-size: 8.5px;
        }
        .my-table th {
            background-color: transparent;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 8px;
            letter-spacing: 0.05em;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.08;
            z-index: 0;
            width: 60%;
            pointer-events: none;
        }
    </style>
</head>
<body class="p-4 md:p-8">

    <!-- Top Action Buttons (Hidden on print) -->
    <div class="no-print max-w-4xl mx-auto mb-6 flex justify-between items-center bg-slate-900 text-white p-4 rounded-xl shadow-md">
        <div>
            <h2 class="text-sm font-bold">Cetak Slip Gaji (A4 Landscape Bagi 2)</h2>
            <p class="text-xs text-gray-400">Nomor: {{ $slipGaji->nomor_slip }} &bull; Perusahaan: {{ $slipGaji->perusahaan ?? 'PT. UTAMA MADANI RAYA' }}</p>
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

    @php
        // Helper formatting for Employee degree in signatures block
        $formattedEmployeeName = $slipGaji->nama_karyawan;
        if (strpos($formattedEmployeeName, ',') !== false) {
            $parts = explode(',', $formattedEmployeeName);
            $namePart = strtoupper(trim($parts[0]));
            $titlePart = trim($parts[1]);
            if (strcasecmp($titlePart, 'S.Pd') === 0 || strcasecmp($titlePart, 'S.Pd.') === 0) {
                $titlePart = 'S.Pd.';
            }
            $formattedEmployeeName = $namePart . ', ' . $titlePart;
        } else {
            $formattedEmployeeName = strtoupper($formattedEmployeeName);
        }

        // Determine active company style
        $isFarma = (isset($slipGaji->perusahaan) && $slipGaji->perusahaan === 'PT. NUR MADANI FARMA');
    @endphp

    <!-- The A4 printable page wrapper -->
    <div class="payslip-page">
        <div class="payslip-container">
            <!-- FIRST HALF (COPY KARYAWAN) -->
            <div class="payslip-half">
                <!-- Watermark Background -->
                @if($isFarma)
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-30deg); font-size: 32px; font-weight: 900; color: rgba(13, 148, 136, 0.05); text-transform: uppercase; letter-spacing: 0.1em; pointer-events: none; z-index: 0; white-space: nowrap; user-select: none; width: 100%; text-align: center;">
                        NUR MADANI FARMA
                    </div>
                @else
                    <img src="{{ asset('img/watermark-tengah.png') }}" alt="Watermark" class="watermark">
                @endif

                <!-- Kop Surat Resmi -->
                @if($isFarma)
                    <div class="w-full mb-1 flex items-center justify-between p-2 rounded" style="background: linear-gradient(135deg, #064e3b 0%, #0d9488 100%); color: white; min-height: 52px; box-sizing: border-box; border: 1px solid #042f1a;">
                        <div class="flex items-center gap-2">
                            <div class="flex items-center justify-center bg-white text-emerald-800 rounded-full w-8 h-8 font-black text-xs shadow border border-emerald-100">
                                NMF
                            </div>
                            <div>
                                <h1 class="text-[10px] font-black tracking-wider uppercase m-0 leading-tight" style="color: #fcd34d;">PT. NUR MADANI FARMA</h1>
                                <p class="text-[6px] font-semibold tracking-wide m-0 text-emerald-100 opacity-90 leading-tight">Distributor & Mitra Pengadaan Alat Kesehatan & Farmasi</p>
                            </div>
                        </div>
                        <div class="text-right text-[6px] leading-relaxed text-emerald-100 opacity-90 font-medium">
                            <div>Telp: 0851-6665-7171</div>
                            <div>Email: ptnurmadanifarma@gmail.com</div>
                        </div>
                    </div>
                @else
                    <div class="w-full mb-1">
                        <img src="{{ asset('img/invoice-header.png') }}" alt="Kop Surat PT UMAR" class="w-full h-auto object-contain">
                    </div>
                @endif

                <!-- Judul Dokumen -->
                <div class="flex justify-between items-center mb-1 border-b border-black pb-0.5">
                    <h2 class="text-[10px] font-black uppercase tracking-widest">SLIP GAJI KARYAWAN</h2>
                    <span class="text-[7.5px] font-bold border border-black px-1.5 py-0.2 uppercase tracking-wider rounded bg-transparent">COPY KARYAWAN</span>
                </div>

                <!-- Informasi Detail Karyawan -->
                <div class="grid grid-cols-2 gap-2 mb-1.5 text-[8px] text-black border border-black p-1.5 rounded bg-transparent relative z-10">
                    <table class="w-full" style="border: none;">
                        <tr class="align-top">
                            <td class="w-12 font-bold py-0.2">No. Slip</td>
                            <td class="w-2 py-0.2">:</td>
                            <td class="font-semibold py-0.2">{{ $slipGaji->nomor_slip }}</td>
                        </tr>
                        <tr class="align-top">
                            <td class="font-bold py-0.2">Periode</td>
                            <td class="py-0.2">:</td>
                            <td class="py-0.2">{{ $slipGaji->periode }}</td>
                        </tr>
                    </table>
                    <table class="w-full" style="border: none;">
                        <tr class="align-top">
                            <td class="w-18 font-bold py-0.2">Nama</td>
                            <td class="w-2 py-0.2">:</td>
                            <td class="font-semibold py-0.2">{{ $slipGaji->nama_karyawan }}</td>
                        </tr>
                        <tr class="align-top">
                            <td class="font-bold py-0.2">Jabatan</td>
                            <td class="py-0.2">:</td>
                            <td class="py-0.2">{{ $slipGaji->jabatan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Vertically Stacked Earnings and Deductions Tables -->
                <div class="space-y-1 mb-1.5 relative z-10">
                    <!-- Pendapatan Table -->
                    <table class="my-table text-[8px]">
                        <thead>
                            <tr>
                                <th class="text-left" style="width: 60%;">I. PENDAPATAN (EARNINGS)</th>
                                <th class="text-right" style="width: 40%;">JUMLAH</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Gaji Pokok</td>
                                <td>
                                    <div class="flex justify-between w-full">
                                        <span>Rp</span>
                                        <span class="font-semibold">{{ number_format($slipGaji->gaji_pokok, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Lembur</td>
                                <td>
                                    <div class="flex justify-between w-full">
                                        <span>Rp</span>
                                        <span class="font-semibold">{{ number_format($slipGaji->lembur, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Tunjangan / Bonus</td>
                                <td>
                                    <div class="flex justify-between w-full">
                                        <span>Rp</span>
                                        <span class="font-semibold">{{ number_format($slipGaji->tunjangan_bonus, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $totalPendapatan = $slipGaji->gaji_pokok + $slipGaji->lembur + $slipGaji->tunjangan_bonus;
                            @endphp
                            <tr class="font-bold">
                                <td>Total Pendapatan (A)</td>
                                <td style="border-top: 1.5px solid #000000;">
                                    <div class="flex justify-between w-full">
                                        <span>Rp</span>
                                        <span>{{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Potongan Table -->
                    <table class="my-table text-[8px]">
                        <thead>
                            <tr>
                                <th class="text-left" style="width: 60%;">II. POTONGAN (DEDUCTIONS)</th>
                                <th class="text-right" style="width: 40%;">JUMLAH</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>BPJS Kesehatan</td>
                                <td>
                                    <div class="flex justify-between w-full">
                                        <span>Rp</span>
                                        <span class="font-semibold">{{ number_format($slipGaji->bpjs_kesehatan, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>BPJS Ketenagakerjaan</td>
                                <td>
                                    <div class="flex justify-between w-full">
                                        <span>Rp</span>
                                        <span class="font-semibold">{{ number_format($slipGaji->bpjs_ketenagakerjaan, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $totalPotongan = $slipGaji->bpjs_kesehatan + $slipGaji->bpjs_ketenagakerjaan;
                            @endphp
                            <tr class="font-bold">
                                <td>Total Potongan (B)</td>
                                <td style="border-top: 1.5px solid #000000;">
                                    <div class="flex justify-between w-full">
                                        <span>Rp</span>
                                        <span>{{ number_format($totalPotongan, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Gaji Bersih Display Banner -->
                <div class="mb-1.5 p-1.5 grid grid-cols-[60%_40%] text-white rounded text-[8.5px] font-black uppercase tracking-wide relative z-10" style="background-color: {{ $isFarma ? '#064e3b' : '#111827' }};">
                    <span>Gaji Bersih Diterima (Net Salary) = A - B</span>
                    <div class="flex justify-between w-full text-[9px] px-1">
                        <span>Rp</span>
                        <span>{{ number_format($slipGaji->total_gaji, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Terbilang -->
                <div class="text-[7.5px] italic font-bold border-b border-dashed border-black pb-0.5 mb-2 relative z-10">
                    Terbilang: {{ \App\Helpers\TerbilangHelper::terbilang($slipGaji->total_gaji) }} Rupiah
                </div>

                <!-- Catatan -->
                @if($slipGaji->catatan)
                <div class="text-[7.5px] border border-dashed border-gray-400 p-1 rounded mb-2 relative z-10">
                    <span class="font-bold">Catatan:</span> {{ $slipGaji->catatan }}
                </div>
                @endif

                <!-- Tanda Tangan -->
                <div class="mt-4 mb-4 relative z-10">
                    <div class="flex justify-between text-[8px] font-bold text-center">
                        <div class="w-36">
                            <p class="uppercase mb-12">DIREKTUR</p>
                            <p class="font-bold uppercase pb-0.5 inline-block w-full">HJ. NORMAULIDA, S.H.</p>
                        </div>
                        <div class="w-36">
                            <p class="uppercase mb-12">PENERIMA / KARYAWAN</p>
                            <p class="font-bold pb-0.5 inline-block w-full">{{ $formattedEmployeeName }}</p>
                        </div>
                    </div>
                </div>

                <!-- Official Company Footer -->
                @if($isFarma)
                    <div class="p-1 text-center text-[7px] font-semibold tracking-wide mt-2 relative z-10" style="border-radius: 4px; background-color: #064e3b; color: white; line-height: 1.3;">
                        <div>Alamat Kantor : Jl. Panglima Batur Banjarbaru Utara, Banjarbaru Kalimantan Selatan</div>
                        <div class="mt-0.5 text-emerald-200 text-[6px]">
                            <span>WhatsApp: 0851-6665-7171</span> &nbsp;|&nbsp;
                            <span>Instagram: @nurmadanifarma</span> &nbsp;|&nbsp;
                            <span>Website: www.nurmadanifarma.com</span>
                        </div>
                    </div>
                @else
                    <div class="p-1 text-center text-[7px] font-semibold tracking-wide mt-2 relative z-10" style="border-radius: 4px; background-color: #111827; color: white; line-height: 1.3;">
                        <div>Alamat Kantor : Jl. Panglima Batur Banjarbaru Utara, Banjarbaru Kalimantan Selatan</div>
                        <div class="mt-0.5 text-gray-300 text-[6px]">
                            <span>WhatsApp: 0851-6665-7171</span> &nbsp;|&nbsp;
                            <span>Instagram: @pt_umar</span> &nbsp;|&nbsp;
                            <span>Website: www.ptutamamadaniraya.com</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- DIVIDER SPACER -->
            <div class="payslip-spacer"></div>

            <!-- SECOND HALF (COPY ARSIP) -->
            <div class="payslip-half">
                <!-- Watermark Background -->
                @if($isFarma)
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-30deg); font-size: 32px; font-weight: 900; color: rgba(13, 148, 136, 0.05); text-transform: uppercase; letter-spacing: 0.1em; pointer-events: none; z-index: 0; white-space: nowrap; user-select: none; width: 100%; text-align: center;">
                        NUR MADANI FARMA
                    </div>
                @else
                    <img src="{{ asset('img/watermark-tengah.png') }}" alt="Watermark" class="watermark">
                @endif

                <!-- Kop Surat Resmi -->
                @if($isFarma)
                    <div class="w-full mb-1 flex items-center justify-between p-2 rounded" style="background: linear-gradient(135deg, #064e3b 0%, #0d9488 100%); color: white; min-height: 52px; box-sizing: border-box; border: 1px solid #042f1a;">
                        <div class="flex items-center gap-2">
                            <div class="flex items-center justify-center bg-white text-emerald-800 rounded-full w-8 h-8 font-black text-xs shadow border border-emerald-100">
                                NMF
                            </div>
                            <div>
                                <h1 class="text-[10px] font-black tracking-wider uppercase m-0 leading-tight" style="color: #fcd34d;">PT. NUR MADANI FARMA</h1>
                                <p class="text-[6px] font-semibold tracking-wide m-0 text-emerald-100 opacity-90 leading-tight">Distributor & Mitra Pengadaan Alat Kesehatan & Farmasi</p>
                            </div>
                        </div>
                        <div class="text-right text-[6px] leading-relaxed text-emerald-100 opacity-90 font-medium">
                            <div>Telp: 0851-6665-7171</div>
                            <div>Email: ptnurmadanifarma@gmail.com</div>
                        </div>
                    </div>
                @else
                    <div class="w-full mb-1">
                        <img src="{{ asset('img/invoice-header.png') }}" alt="Kop Surat PT UMAR" class="w-full h-auto object-contain">
                    </div>
                @endif

                <!-- Judul Dokumen -->
                <div class="flex justify-between items-center mb-1 border-b border-black pb-0.5">
                    <h2 class="text-[10px] font-black uppercase tracking-widest">SLIP GAJI KARYAWAN</h2>
                    <span class="text-[7.5px] font-bold border border-black px-1.5 py-0.2 uppercase tracking-wider rounded bg-transparent">COPY ARSIP</span>
                </div>

                <!-- Informasi Detail Karyawan -->
                <div class="grid grid-cols-2 gap-2 mb-1.5 text-[8px] text-black border border-black p-1.5 rounded bg-transparent relative z-10">
                    <table class="w-full" style="border: none;">
                        <tr class="align-top">
                            <td class="w-12 font-bold py-0.2">No. Slip</td>
                            <td class="w-2 py-0.2">:</td>
                            <td class="font-semibold py-0.2">{{ $slipGaji->nomor_slip }}</td>
                        </tr>
                        <tr class="align-top">
                            <td class="font-bold py-0.2">Periode</td>
                            <td class="py-0.2">:</td>
                            <td class="py-0.2">{{ $slipGaji->periode }}</td>
                        </tr>
                    </table>
                    <table class="w-full" style="border: none;">
                        <tr class="align-top">
                            <td class="w-18 font-bold py-0.2">Nama</td>
                            <td class="w-2 py-0.2">:</td>
                            <td class="font-semibold py-0.2">{{ $slipGaji->nama_karyawan }}</td>
                        </tr>
                        <tr class="align-top">
                            <td class="font-bold py-0.2">Jabatan</td>
                            <td class="py-0.2">:</td>
                            <td class="py-0.2">{{ $slipGaji->jabatan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Vertically Stacked Earnings and Deductions Tables -->
                <div class="space-y-1 mb-1.5 relative z-10">
                    <!-- Pendapatan Table -->
                    <table class="my-table text-[8px]">
                        <thead>
                            <tr>
                                <th class="text-left" style="width: 60%;">I. PENDAPATAN (EARNINGS)</th>
                                <th class="text-right" style="width: 40%;">JUMLAH</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Gaji Pokok</td>
                                <td>
                                    <div class="flex justify-between w-full">
                                        <span>Rp</span>
                                        <span class="font-semibold">{{ number_format($slipGaji->gaji_pokok, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Lembur</td>
                                <td>
                                    <div class="flex justify-between w-full">
                                        <span>Rp</span>
                                        <span class="font-semibold">{{ number_format($slipGaji->lembur, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Tunjangan / Bonus</td>
                                <td>
                                    <div class="flex justify-between w-full">
                                        <span>Rp</span>
                                        <span class="font-semibold">{{ number_format($slipGaji->tunjangan_bonus, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $totalPendapatan = $slipGaji->gaji_pokok + $slipGaji->lembur + $slipGaji->tunjangan_bonus;
                            @endphp
                            <tr class="font-bold">
                                <td>Total Pendapatan (A)</td>
                                <td style="border-top: 1.5px solid #000000;">
                                    <div class="flex justify-between w-full">
                                        <span>Rp</span>
                                        <span>{{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Potongan Table -->
                    <table class="my-table text-[8px]">
                        <thead>
                            <tr>
                                <th class="text-left" style="width: 60%;">II. POTONGAN (DEDUCTIONS)</th>
                                <th class="text-right" style="width: 40%;">JUMLAH</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>BPJS Kesehatan</td>
                                <td>
                                    <div class="flex justify-between w-full">
                                        <span>Rp</span>
                                        <span class="font-semibold">{{ number_format($slipGaji->bpjs_kesehatan, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>BPJS Ketenagakerjaan</td>
                                <td>
                                    <div class="flex justify-between w-full">
                                        <span>Rp</span>
                                        <span class="font-semibold">{{ number_format($slipGaji->bpjs_ketenagakerjaan, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $totalPotongan = $slipGaji->bpjs_kesehatan + $slipGaji->bpjs_ketenagakerjaan;
                            @endphp
                            <tr class="font-bold">
                                <td>Total Potongan (B)</td>
                                <td style="border-top: 1.5px solid #000000;">
                                    <div class="flex justify-between w-full">
                                        <span>Rp</span>
                                        <span>{{ number_format($totalPotongan, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Gaji Bersih Display Banner -->
                <div class="mb-1.5 p-1.5 grid grid-cols-[60%_40%] text-white rounded text-[8.5px] font-black uppercase tracking-wide relative z-10" style="background-color: {{ $isFarma ? '#064e3b' : '#111827' }};">
                    <span>Gaji Bersih Diterima (Net Salary) = A - B</span>
                    <div class="flex justify-between w-full text-[9px] px-1">
                        <span>Rp</span>
                        <span>{{ number_format($slipGaji->total_gaji, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Terbilang -->
                <div class="text-[7.5px] italic font-bold border-b border-dashed border-black pb-0.5 mb-2 relative z-10">
                    Terbilang: {{ \App\Helpers\TerbilangHelper::terbilang($slipGaji->total_gaji) }} Rupiah
                </div>

                <!-- Catatan -->
                @if($slipGaji->catatan)
                <div class="text-[7.5px] border border-dashed border-gray-400 p-1 rounded mb-2 relative z-10">
                    <span class="font-bold">Catatan:</span> {{ $slipGaji->catatan }}
                </div>
                @endif

                <!-- Tanda Tangan -->
                <div class="mt-4 mb-4 relative z-10">
                    <div class="flex justify-between text-[8px] font-bold text-center">
                        <div class="w-36">
                            <p class="uppercase mb-12">DIREKTUR</p>
                            <p class="font-bold uppercase pb-0.5 inline-block w-full">HJ. NORMAULIDA, S.H.</p>
                        </div>
                        <div class="w-36">
                            <p class="uppercase mb-12">PENERIMA / KARYAWAN</p>
                            <p class="font-bold pb-0.5 inline-block w-full">{{ $formattedEmployeeName }}</p>
                        </div>
                    </div>
                </div>

                <!-- Official Company Footer -->
                @if($isFarma)
                    <div class="p-1 text-center text-[7px] font-semibold tracking-wide mt-2 relative z-10" style="border-radius: 4px; background-color: #064e3b; color: white; line-height: 1.3;">
                        <div>Alamat Kantor : Jl. Panglima Batur Banjarbaru Utara, Banjarbaru Kalimantan Selatan</div>
                        <div class="mt-0.5 text-emerald-200 text-[6px]">
                            <span>WhatsApp: 0851-6665-7171</span> &nbsp;|&nbsp;
                            <span>Instagram: @nurmadanifarma</span> &nbsp;|&nbsp;
                            <span>Website: www.nurmadanifarma.com</span>
                        </div>
                    </div>
                @else
                    <div class="p-1 text-center text-[7px] font-semibold tracking-wide mt-2 relative z-10" style="border-radius: 4px; background-color: #111827; color: white; line-height: 1.3;">
                        <div>Alamat Kantor : Jl. Panglima Batur Banjarbaru Utara, Banjarbaru Kalimantan Selatan</div>
                        <div class="mt-0.5 text-gray-300 text-[6px]">
                            <span>WhatsApp: 0851-6665-7171</span> &nbsp;|&nbsp;
                            <span>Instagram: @pt_umar</span> &nbsp;|&nbsp;
                            <span>Website: www.ptutamamadaniraya.com</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

</body>
</html>
