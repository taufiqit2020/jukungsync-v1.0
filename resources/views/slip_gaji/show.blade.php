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
                size: A4 portrait; 
                margin: 0;
            }
            .payslip-page {
                width: 210mm;
                height: 297mm;
                padding: 0;
                margin: 0;
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
                width: 210mm;
                height: 297mm;
                padding: 0;
                margin: 2rem auto;
                box-sizing: border-box;
                position: relative;
            }
        }
        .payslip-half {
            height: 144mm;
            padding: 8mm 10mm;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }
        .divider-container {
            height: 9mm;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-sizing: border-box;
            background-color: #f3f4f6;
        }
        @media print {
            .divider-container {
                background-color: white !important;
            }
        }
        .divider-line {
            width: 100%;
            border-top: 1.5px dashed #9ca3af;
            position: relative;
        }
        .divider-badge {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 2px 12px;
            font-size: 9px;
            font-weight: 700;
            color: #4b5563;
            border: 1px solid #d1d5db;
            border-radius: 9999px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .my-table {
            border-collapse: collapse;
            width: 100%;
        }
        .my-table th, .my-table td {
            border: 1px solid #000000;
            padding: 5px 8px;
            font-size: 10px;
        }
        .my-table th {
            background-color: #f3f4f6;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 9px;
            letter-spacing: 0.05em;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.04;
            z-index: 0;
            width: 50%;
            max-width: 350px;
            pointer-events: none;
        }
    </style>
</head>
<body class="p-4 md:p-8">

    <!-- Top Action Buttons (Hidden on print) -->
    <div class="no-print max-w-4xl mx-auto mb-6 flex justify-between items-center bg-slate-900 text-white p-4 rounded-xl shadow-md">
        <div>
            <h2 class="text-sm font-bold">Cetak Slip Gaji (A4 Dibagi 2)</h2>
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

    <!-- The A4 printable page wrapper -->
    <div class="payslip-page">
        <!-- FIRST HALF (COPY KARYAWAN) -->
        <div class="payslip-half">
            <!-- Watermark Background -->
            <img src="{{ asset('img/watermark-tengah.png') }}" alt="Watermark" class="watermark">

            <!-- Top Content Area -->
            <div>
                <!-- Kop Surat Resmi -->
                <div class="w-full mb-2">
                    <img src="{{ asset('img/invoice-header.png') }}" alt="Kop Surat PT UMAR" class="w-full h-[15mm] object-contain">
                </div>

                <!-- Judul Dokumen -->
                <div class="flex justify-between items-center mb-2 border-b border-black pb-1">
                    <h2 class="text-xs font-black uppercase tracking-widest">SLIP GAJI KARYAWAN</h2>
                    <span class="text-[8px] font-bold border border-black px-2 py-0.5 uppercase tracking-wider rounded bg-gray-100">COPY KARYAWAN</span>
                </div>

                <!-- Informasi Detail Karyawan -->
                <div class="grid grid-cols-2 gap-4 mb-2 text-[9px] text-black border border-black p-2 rounded bg-transparent relative z-10">
                    <table class="w-full" style="border: none;">
                        <tr class="align-top">
                            <td class="w-16 font-bold py-0.5">No. Slip</td>
                            <td class="w-2 py-0.5">:</td>
                            <td class="font-semibold py-0.5">{{ $slipGaji->nomor_slip }}</td>
                        </tr>
                        <tr class="align-top">
                            <td class="font-bold py-0.5">Periode</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5">{{ $slipGaji->periode }}</td>
                        </tr>
                    </table>
                    <table class="w-full" style="border: none;">
                        <tr class="align-top">
                            <td class="w-24 font-bold py-0.5">Nama Karyawan</td>
                            <td class="w-2 py-0.5">:</td>
                            <td class="font-semibold py-0.5">{{ $slipGaji->nama_karyawan }}</td>
                        </tr>
                        <tr class="align-top">
                            <td class="font-bold py-0.5">Jabatan</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5">{{ $slipGaji->jabatan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Side-by-Side Earnings and Deductions Tables -->
                <div class="flex justify-between items-start gap-4 mb-2 relative z-10">
                    <!-- Pendapatan Table -->
                    <div class="w-[49%]">
                        <table class="my-table text-[9px]">
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
                                <tr class="font-bold bg-gray-50">
                                    <td>Total Pendapatan (A)</td>
                                    <td class="text-right" style="border-top: 1.5px solid #000000;">{{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Potongan Table -->
                    <div class="w-[49%]">
                        <table class="my-table text-[9px]">
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
                                <tr class="font-bold bg-gray-50">
                                    <td>Total Potongan (B)</td>
                                    <td class="text-right" style="border-top: 1.5px solid #000000;">{{ number_format($totalPotongan, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Gaji Bersih Display Banner -->
                <div class="mb-1.5 p-2 flex justify-between items-center bg-slate-900 text-white rounded text-[10px] font-black uppercase tracking-wide relative z-10" style="background-color: #111827;">
                    <span>Gaji Bersih Diterima (Net Salary) = A - B</span>
                    <span class="text-xs">Rp {{ number_format($slipGaji->total_gaji, 0, ',', '.') }}</span>
                </div>

                <!-- Terbilang -->
                <div class="text-[9px] italic font-bold border-b border-dashed border-black pb-1 mb-1.5 relative z-10">
                    Terbilang: {{ \App\Helpers\TerbilangHelper::terbilang($slipGaji->total_gaji) }} Rupiah
                </div>

                <!-- Catatan -->
                @if($slipGaji->catatan)
                <div class="text-[8px] border border-dashed border-gray-400 p-1.5 rounded mb-1 relative z-10">
                    <span class="font-bold">Catatan:</span> {{ $slipGaji->catatan }}
                </div>
                @endif
            </div>

            <!-- Bottom Content Area -->
            <div>
                <!-- Tanda Tangan -->
                <div class="mt-1 relative z-10">
                    <div class="flex justify-between text-[9px] font-bold text-center">
                        <div class="w-48">
                            <p class="uppercase mb-8">DIREKTUR</p>
                            <p class="border-b border-black font-bold uppercase pb-0.5 inline-block w-full">HJ. NORMAULIDA, S.H.</p>
                        </div>
                        <div class="w-48">
                            <p class="uppercase mb-8">PENERIMA / KARYAWAN</p>
                            <p class="border-b border-black font-bold uppercase pb-0.5 inline-block w-full">{{ $slipGaji->nama_karyawan }}</p>
                        </div>
                    </div>
                </div>

                <!-- Official Company Footer -->
                <div class="p-1.5 text-center text-[8px] font-semibold tracking-wide mt-2" style="border-radius: 4px; background-color: #111827; color: white; line-height: 1.3;">
                    <div>Alamat Kantor : Jl. Panglima Batur Banjarbaru Utara, Banjarbaru Kalimantan Selatan</div>
                    <div class="mt-0.5 text-gray-300 text-[7px]">
                        <span>WhatsApp: 0851-6665-7171</span> &nbsp;|&nbsp;
                        <span>Instagram: @pt_umar</span> &nbsp;|&nbsp;
                        <span>Website: www.ptutamamadaniraya.com</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- DIVIDER -->
        <div class="divider-container">
            <div class="divider-line"></div>
            <span class="divider-badge">✂ Potong di Sini</span>
        </div>

        <!-- SECOND HALF (COPY ARSIP) -->
        <div class="payslip-half">
            <!-- Watermark Background -->
            <img src="{{ asset('img/watermark-tengah.png') }}" alt="Watermark" class="watermark">

            <!-- Top Content Area -->
            <div>
                <!-- Kop Surat Resmi -->
                <div class="w-full mb-2">
                    <img src="{{ asset('img/invoice-header.png') }}" alt="Kop Surat PT UMAR" class="w-full h-[15mm] object-contain">
                </div>

                <!-- Judul Dokumen -->
                <div class="flex justify-between items-center mb-2 border-b border-black pb-1">
                    <h2 class="text-xs font-black uppercase tracking-widest">SLIP GAJI KARYAWAN</h2>
                    <span class="text-[8px] font-bold border border-black px-2 py-0.5 uppercase tracking-wider rounded bg-gray-100">COPY ARSIP</span>
                </div>

                <!-- Informasi Detail Karyawan -->
                <div class="grid grid-cols-2 gap-4 mb-2 text-[9px] text-black border border-black p-2 rounded bg-transparent relative z-10">
                    <table class="w-full" style="border: none;">
                        <tr class="align-top">
                            <td class="w-16 font-bold py-0.5">No. Slip</td>
                            <td class="w-2 py-0.5">:</td>
                            <td class="font-semibold py-0.5">{{ $slipGaji->nomor_slip }}</td>
                        </tr>
                        <tr class="align-top">
                            <td class="font-bold py-0.5">Periode</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5">{{ $slipGaji->periode }}</td>
                        </tr>
                    </table>
                    <table class="w-full" style="border: none;">
                        <tr class="align-top">
                            <td class="w-24 font-bold py-0.5">Nama Karyawan</td>
                            <td class="w-2 py-0.5">:</td>
                            <td class="font-semibold py-0.5">{{ $slipGaji->nama_karyawan }}</td>
                        </tr>
                        <tr class="align-top">
                            <td class="font-bold py-0.5">Jabatan</td>
                            <td class="py-0.5">:</td>
                            <td class="py-0.5">{{ $slipGaji->jabatan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Side-by-Side Earnings and Deductions Tables -->
                <div class="flex justify-between items-start gap-4 mb-2 relative z-10">
                    <!-- Pendapatan Table -->
                    <div class="w-[49%]">
                        <table class="my-table text-[9px]">
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
                                <tr class="font-bold bg-gray-50">
                                    <td>Total Pendapatan (A)</td>
                                    <td class="text-right" style="border-top: 1.5px solid #000000;">{{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Potongan Table -->
                    <div class="w-[49%]">
                        <table class="my-table text-[9px]">
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
                                <tr class="font-bold bg-gray-50">
                                    <td>Total Potongan (B)</td>
                                    <td class="text-right" style="border-top: 1.5px solid #000000;">{{ number_format($totalPotongan, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Gaji Bersih Display Banner -->
                <div class="mb-1.5 p-2 flex justify-between items-center bg-slate-900 text-white rounded text-[10px] font-black uppercase tracking-wide relative z-10" style="background-color: #111827;">
                    <span>Gaji Bersih Diterima (Net Salary) = A - B</span>
                    <span class="text-xs">Rp {{ number_format($slipGaji->total_gaji, 0, ',', '.') }}</span>
                </div>

                <!-- Terbilang -->
                <div class="text-[9px] italic font-bold border-b border-dashed border-black pb-1 mb-1.5 relative z-10">
                    Terbilang: {{ \App\Helpers\TerbilangHelper::terbilang($slipGaji->total_gaji) }} Rupiah
                </div>

                <!-- Catatan -->
                @if($slipGaji->catatan)
                <div class="text-[8px] border border-dashed border-gray-400 p-1.5 rounded mb-1 relative z-10">
                    <span class="font-bold">Catatan:</span> {{ $slipGaji->catatan }}
                </div>
                @endif
            </div>

            <!-- Bottom Content Area -->
            <div>
                <!-- Tanda Tangan -->
                <div class="mt-1 relative z-10">
                    <div class="flex justify-between text-[9px] font-bold text-center">
                        <div class="w-48">
                            <p class="uppercase mb-8">DIREKTUR</p>
                            <p class="border-b border-black font-bold uppercase pb-0.5 inline-block w-full">HJ. NORMAULIDA, S.H.</p>
                        </div>
                        <div class="w-48">
                            <p class="uppercase mb-8">PENERIMA / KARYAWAN</p>
                            <p class="border-b border-black font-bold uppercase pb-0.5 inline-block w-full">{{ $slipGaji->nama_karyawan }}</p>
                        </div>
                    </div>
                </div>

                <!-- Official Company Footer -->
                <div class="p-1.5 text-center text-[8px] font-semibold tracking-wide mt-2" style="border-radius: 4px; background-color: #111827; color: white; line-height: 1.3;">
                    <div>Alamat Kantor : Jl. Panglima Batur Banjarbaru Utara, Banjarbaru Kalimantan Selatan</div>
                    <div class="mt-0.5 text-gray-300 text-[7px]">
                        <span>WhatsApp: 0851-6665-7171</span> &nbsp;|&nbsp;
                        <span>Instagram: @pt_umar</span> &nbsp;|&nbsp;
                        <span>Website: www.ptutamamadaniraya.com</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
