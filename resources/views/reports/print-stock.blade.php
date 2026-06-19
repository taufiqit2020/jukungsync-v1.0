<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Stok - {{ $selectedProduct->nama_barang }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap');
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
                size: A4 portrait; 
                margin: 0mm; 
            }
            body { 
                margin: 0 !important; 
                padding: 10mm 15mm !important; 
                padding-top: 90mm !important;
                padding-bottom: 25mm !important;
                min-height: auto !important;
            }
            .print-header {
                position: fixed !important;
                top: 0 !important;
                left: 15mm !important;
                right: 15mm !important;
                width: auto !important;
                background: white !important;
                z-index: 50 !important;
                padding-top: 10mm !important;
                padding-bottom: 5mm !important;
                margin: 0 !important;
            }
            .print-footer {
                position: fixed !important;
                bottom: 10mm !important;
                left: 15mm !important;
                right: 15mm !important;
                width: auto !important;
                z-index: 50 !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            table, tr, td, th, tbody {
                page-break-inside: avoid;
            }
            .mt-auto { margin-top: 2rem !important; }
            .print-signature { margin-bottom: 2.5rem !important; }
            
            img { max-width: 100% !important; height: auto !important; }
            .watermark { z-index: -1 !important; opacity: 0.15 !important; }
        }
        .header-bg {
            background-color: #111827;
            color: white;
        }
        /* Watermark Styles */
        .watermark-container {
            position: relative;
        }
        .watermark-bg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            z-index: -1;
            width: 400px;
            pointer-events: none;
        }
    </style>
</head>
<body class="max-w-5xl mx-auto min-h-screen flex flex-col relative z-0  ">

    <!-- Print Container -->
    <div class="print-container flex-1 p-4 md:p-8 flex flex-col">
        <!-- Tombol Print -->
        <div class="no-print mb-6 flex justify-end">
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak (Ctrl+P)
            </button>
        </div>

        <!-- Kop Surat (Logo Perusahaan) -->
        <div class="print-header w-full mb-6">
        <img src="{{ asset('img/invoice-header.png') }}" alt="Kop Surat PT UMAR" class="w-full h-auto object-contain">
        </div>

        <!-- Judul Laporan -->
        <div class="text-center mb-8">
            <h2 class="text-xl font-bold uppercase underline">LAPORAN KARTU STOK</h2>
            <p class="text-sm mt-1">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
        </div>

        <!-- Detail Produk -->
        <div class="mb-4 text-sm font-semibold">
            <table class="w-1/2">
                <tr>
                    <td class="py-1 w-32 uppercase text-gray-600">Nama Barang</td>
                    <td class="py-1">: {{ $selectedProduct->nama_barang }}</td>
                </tr>
                <tr>
                    <td class="py-1 uppercase text-gray-600">Kode / SKU</td>
                    <td class="py-1">: {{ $selectedProduct->sku }}</td>
                </tr>
            </table>
        </div>

        <!-- Tabel Rincian -->
        <div class="watermark-container">
            <img src="{{ asset('img/watermark-tengah.png') }}" alt="Watermark" class="watermark-bg">
            <table class="w-full text-left border-collapse table-border text-[11px] mb-10">
                <thead>
                    <tr>
                        <th class="py-2 px-2 text-center w-24">Tanggal</th>
                        <th class="py-2 px-2">Keterangan / Ref</th>
                        <th class="py-2 px-2 text-center w-20">Masuk</th>
                        <th class="py-2 px-2 text-center w-20">Keluar</th>
                        <th class="py-2 px-2 text-center w-24">Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-2 px-2 text-center">-</td>
                        <td class="py-2 px-2 font-bold uppercase">Saldo Awal</td>
                        <td class="py-2 px-2 text-center">-</td>
                        <td class="py-2 px-2 text-center">-</td>
                        <td class="py-2 px-2 text-center font-black bg-gray-100">{{ $saldoAwal }}</td>
                    </tr>
                    @php $currentSaldo = $saldoAwal; @endphp
                    @forelse($movements as $m)
                        @php
                            if($m->tipe_pergerakan === 'masuk') {
                                $currentSaldo += $m->jumlah;
                            } else {
                                $currentSaldo -= $m->jumlah;
                            }
                        @endphp
                        <tr>
                            <td class="py-2 px-2 text-center">{{ \Carbon\Carbon::parse($m->tanggal)->format('d/m/Y') }}</td>
                            <td class="py-2 px-2">{{ $m->keterangan }}</td>
                            <td class="py-2 px-2 text-center font-bold">{{ $m->tipe_pergerakan === 'masuk' ? $m->jumlah : '-' }}</td>
                            <td class="py-2 px-2 text-center font-bold">{{ $m->tipe_pergerakan === 'keluar' ? $m->jumlah : '-' }}</td>
                            <td class="py-2 px-2 text-center font-bold bg-gray-50">{{ $currentSaldo }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center italic text-gray-500">Tidak ada mutasi pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="font-bold bg-gray-100">
                    <tr>
                        <td colspan="4" class="py-2 px-2 text-right uppercase">SALDO AKHIR TANGGAL {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }} :</td>
                        <td class="py-2 px-2 text-center text-sm font-black">{{ $currentSaldo }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Tanda Tangan -->
        <div class="flex justify-end mt-12 mb-10 page-break-inside-avoid">
            <div class="text-center w-64">
                <p class="mb-1 text-sm">Banjarbaru, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
                <p class="mb-20 text-sm font-bold {{ auth()->user()->role === 'bendahara' ? 'uppercase' : 'capitalize' }}">Mengetahui {{ auth()->user()->role === 'bendahara' ? 'KEPALA ADMINISTRASI DAN KEUANGAN' : ucwords(str_replace('_', ' ', auth()->user()->role ?? 'Pimpinan')) }},</p>
                <p class="border-b border-black font-bold pb-1 text-sm whitespace-nowrap">{{ auth()->user()->name ?? 'HJ. NORMAULIDA, SH' }}</p>
            </div>
        </div>
    </div>

    <!-- Banner Footer -->
    <div class="print-footer w-full mt-auto">
        <div class="header-bg p-3 text-center text-xs font-semibold tracking-wide" style="border-radius: 4px; background-color: #111827; color: white; line-height: 1.5;">
            <div>Alamat Kantor : Jl. Panglima Batur Banjarbaru Utara, Banjarbaru Kalimantan Selatan</div>
            <div class="mt-1 text-gray-300 text-[10px]">
                <span>WhatsApp: 0851-6665-7171</span> &nbsp;|&nbsp;
                <span>Instagram: @pt_umar</span> &nbsp;|&nbsp;
                <span>Website: www.ptutamamadaniraya.com</span>
            </div>
        </div>
    </div>

</body>
</html>
