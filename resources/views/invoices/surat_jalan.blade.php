<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan - {{ $invoice->nomor_invoice }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
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
            .inner-table tr {
                page-break-inside: avoid;
            }
            .page-break-avoid { page-break-inside: avoid !important; }
            img { max-width: 100% !important; height: auto !important; }
            .watermark { z-index: -1 !important; opacity: 0.08 !important; }
        }
        @media screen {
            .print-footer {
                margin-top: 2rem;
                width: 100%;
            }
        }
        .header-bg {
            background-color: #111827;
            color: white;
        }
        .my-table {
            border-collapse: collapse;
        }
        .my-table th, .my-table td.bordered {
            border: 1px solid #374151;
        }
        .my-table th {
            background-color: #1f2937;
            color: #ffffff;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 6px 4px;
        }
        .my-table td.bordered {
            padding: 5px 4px;
            font-size: 11px;
        }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.08;
            z-index: 0;
            width: 65%;
            max-width: 550px;
            pointer-events: none;
        }
        .page-break-avoid { page-break-inside: avoid !important; }
    </style>
</head>
<body class="max-w-5xl mx-auto p-4 md:p-8 relative">

    <!-- Tombol Print (Layar) -->
    <div class="no-print mb-6 flex justify-end gap-2">
        <a href="javascript:window.history.back()" class="bg-gray-200 hover:bg-gray-300 text-black px-4 py-2 rounded text-sm font-semibold flex items-center shadow-sm">
            Kembali
        </a>
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold flex items-center shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Surat Jalan (Ctrl+P)
        </button>
    </div>

    <!-- Watermark Background -->
    <img src="{{ asset('img/watermark-tengah.png') }}" alt="Watermark" class="watermark">

    <!-- MAIN TABLE -->
    <table class="w-full my-table text-sm text-center bg-transparent inner-table">
        <thead class="bg-transparent">
            <tr>
                <td colspan="8" style="border: none !important; padding: 0;" class="text-left bg-transparent">
                    <img src="{{ asset('img/invoice-header.png') }}" alt="Kop Surat PT UMAR" class="w-full h-auto object-contain mb-6">
                    
                    <div class="text-center mb-6">
                        <h2 class="font-bold text-xl uppercase tracking-wider border-b-2 border-black inline-block pb-1">SURAT JALAN / TANDA TERIMA BARANG</h2>
                    </div>

                    <div class="flex justify-between mb-6 text-black px-2">
                        <div>
                            <p class="font-bold uppercase border-b border-black pb-1 inline-block mb-1">KEPADA YTH :</p>
                            <h3 class="font-bold text-lg uppercase">{{ $invoice->nama_klien }}</h3>
                            @if($invoice->alamat_pengiriman)
                                <p class="text-xs mt-2 text-gray-750 max-w-sm leading-relaxed">
                                    <strong>Alamat Kirim:</strong><br>
                                    {{ $invoice->alamat_pengiriman }}
                                </p>
                            @endif
                        </div>
                        <div class="text-right">
                            <table class="text-right text-sm ml-auto" style="border: none;">
                                <tr>
                                    <td class="pr-2 py-1" style="border: none;">No. Rujukan/Invoice:</td>
                                    <td class="font-bold" style="border: none;">{{ $invoice->nomor_invoice }}</td>
                                </tr>
                                <tr>
                                    <td class="pr-2 py-1" style="border: none;">Tanggal Kirim:</td>
                                    <td class="font-semibold" style="border: none;">{{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->translatedFormat('d F Y') }}</td>
                                </tr>
                                @if($invoice->ekspedisi)
                                <tr>
                                    <td class="pr-2 py-1" style="border: none;">Ekspedisi/Kurir:</td>
                                    <td class="font-semibold" style="border: none; text-transform: uppercase;">{{ $invoice->ekspedisi }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th style="width:28px">No</th>
                <th style="width:70px">Kode Barang</th>
                <th style="min-width:150px">Nama Barang / Jasa</th>
                <th style="width:80px">Merek</th>
                <th style="width:40px">Satuan</th>
                <th style="width:85px">Kategori</th>
                <th style="width:40px">Jumlah</th>
                <th style="min-width:100px">Keterangan / Paraf Cek</th>
            </tr>
        </thead>
        <tbody class="bg-transparent">
            @foreach($invoice->invoiceItems as $index => $item)
            <tr>
                <td class="bordered text-center">{{ $index + 1 }}</td>
                <td class="bordered text-center font-mono" style="font-size:9px;">{{ $item->product->sku ?? '-' }}</td>
                <td class="bordered text-left">
                    <span class="font-bold">{{ $item->product->nama_barang ?? 'Barang Dihapus' }}</span>
                </td>
                <td class="bordered text-center" style="font-size:9px; text-transform:uppercase;">{{ $item->product->merk->nama_merk ?? '-' }}</td>
                <td class="bordered text-center" style="text-transform:uppercase;">PCS</td>
                <td class="bordered text-center" style="font-size:9px;">{{ $item->product->category->nama_kategori ?? '-' }}</td>
                <td class="bordered text-center font-black text-sm">{{ $item->jumlah }}</td>
                <td class="bordered text-center text-xs text-gray-400">[ &nbsp; &nbsp; ]</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($invoice->catatan_pengiriman)
    <div class="mt-4 px-2 text-xs">
        <strong>Catatan Pengiriman:</strong>
        <p class="italic text-gray-650 mt-1 bg-gray-50 p-2.5 rounded border border-gray-200">"{{ $invoice->catatan_pengiriman }}"</p>
    </div>
    @endif

    <!-- Tanda Tangan Grid (4 Kolom) -->
    <div class="mt-8 page-break-avoid">
        <div class="grid grid-cols-4 gap-4 text-center text-xs">
            <div>
                <p class="font-bold mb-16 uppercase">Penerima / Klien</p>
                <p class="border-b border-black font-bold uppercase pb-1 inline-block w-3/4 mx-auto"></p>
                <p class="text-[9px] text-gray-500 mt-0.5">(Tanda Tangan & Cap)</p>
            </div>
            <div>
                <p class="font-bold mb-16 uppercase">Sopir / Ekspedisi</p>
                <p class="border-b border-black font-bold uppercase pb-1 inline-block w-3/4 mx-auto"></p>
                <p class="text-[9px] text-gray-500 mt-0.5">(Nama Jelas)</p>
            </div>
            <div>
                <p class="font-bold mb-16 uppercase">Warehouse / Gudang</p>
                <p class="border-b border-black font-bold uppercase pb-1 inline-block w-3/4 mx-auto"></p>
                <p class="text-[9px] text-gray-500 mt-0.5">(Nama Jelas)</p>
            </div>
            <div>
                <p class="font-bold mb-16 uppercase">Mengetahui (Owner)</p>
                <p class="border-b border-black font-bold uppercase pb-1 inline-block w-3/4 mx-auto">HJ. NORMAULIDA, S.H.</p>
                <p class="text-[9px] text-gray-500 mt-0.5">(Tanda Tangan & Cap)</p>
            </div>
        </div>
    </div>

    <!-- Banner Footer -->
    <div class="print-footer header-bg p-2 text-center text-xs font-semibold tracking-wide" style="border-radius: 4px; background-color: #111827; color: white; line-height: 1.5;">
        <div>Alamat Kantor : Jl. Panglima Batur Banjarbaru Utara, Banjarbaru Kalimantan Selatan</div>
        <div class="mt-0.5 text-gray-300 text-[10px]">
            <span>WhatsApp: 0851-6665-7171</span> &nbsp;|&nbsp;
            <span>Instagram: @pt_umar</span> &nbsp;|&nbsp;
            <span>Website: www.ptutamamadaniraya.com</span>
        </div>
    </div>

</body>
</html>
