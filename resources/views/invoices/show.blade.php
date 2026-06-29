<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $invoice->nomor_invoice }}</title>
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
            padding: 5px 4px;
        }
        .my-table td.bordered {
            padding: 4px 4px;
            font-size: 11px;
        }
        .rp-num {
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
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

    <!-- Tombol Print -->
    <div class="no-print mb-6 flex justify-end gap-2">
        @if($invoice->status_pembayaran === 'belum_lunas' && in_array(auth()->user()->role, ['staf_admin', 'bendahara', 'superadmin']))
        <form action="{{ route('invoices.mark-paid', $invoice) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menandai invoice ini sebagai LUNAS?');">
            @csrf
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-semibold flex items-center shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Tandai Lunas
            </button>
        </form>
        @endif

        @if(!$isInternal)
        <a href="{{ route('invoices.show', ['invoice' => $invoice->id, 'mode' => 'internal']) }}" class="bg-gray-200 hover:bg-gray-300 text-black px-4 py-2 rounded text-sm font-semibold">Beralih ke Tampilan Internal</a>
        @else
        <a href="{{ route('invoices.show', $invoice->id) }}" class="bg-gray-200 hover:bg-gray-300 text-black px-4 py-2 rounded text-sm font-semibold">Beralih ke Tampilan Klien</a>
        @endif
        
        <a href="{{ route('invoices.export-word', $invoice->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm font-semibold flex items-center shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Export Word
        </a>

        <a href="{{ route('invoices.export-excel', $invoice->id) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded text-sm font-semibold flex items-center shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Export Excel
        </a>

        <a href="{{ route('invoices.surat-jalan', $invoice->id) }}" target="_blank" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded text-sm font-semibold flex items-center shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zm12 0a2 2 0 11-4 0 2 2 0 014 0zm0 0V9a2 2 0 00-2-2h-5M9 7V5a2 2 0 012-2h4a2 2 0 012 2v2m-3 5h3m-6 0h3m-3 0a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            Cetak Surat Jalan
        </a>

        <a href="{{ route('invoices.surat-jalan-lx310', $invoice->id) }}" target="_blank" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded text-sm font-semibold flex items-center shadow-sm" title="Cetak Surat Jalan untuk printer Epson LX-310 (Continuous Form 9.5x11 inch 3-ply)">
            🖨️ SJ LX-310
        </a>

        <a href="{{ route('invoices.invoice-lx310', $isInternal ? ['invoice' => $invoice->id, 'mode' => 'internal'] : $invoice->id) }}" target="_blank" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded text-sm font-semibold flex items-center shadow-sm" title="Cetak Invoice untuk printer Epson LX-310 (Continuous Form 9.5x11 inch 3-ply){{ $isInternal ? ' - Mode Internal' : '' }}">
            🖨️ Invoice LX-310{{ $isInternal ? ' (Internal)' : '' }}
        </a>

        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold flex items-center shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak (Ctrl+P)
        </button>
    </div>

    <!-- Watermark Background -->
    <img src="{{ asset('img/watermark-tengah.png') }}" alt="Watermark" class="watermark">

    <!-- MAIN INVOICE TABLE -->
    <table class="w-full my-table text-sm text-center bg-transparent inner-table">
        <thead class="bg-transparent">
            <tr>
                @php $totalColspan = $isInternal ? 12 : 9; @endphp
                <td colspan="{{ $totalColspan }}" style="border: none !important; padding: 0;" class="text-left bg-transparent">
                    <img src="{{ asset('img/invoice-header.png') }}" alt="Kop Surat PT UMAR" class="w-full h-auto object-contain mb-6">
                    
                    <div class="flex justify-between mb-6 text-black px-2">
                        <div>
                            <p class="font-bold uppercase border-b border-black pb-1 inline-block mb-1">KEPADA :</p>
                            <h3 class="font-bold text-lg uppercase">{{ $invoice->nama_klien }}</h3>
                        </div>
                        <div class="text-right">
                            <h3 class="font-bold text-lg mb-2">No. Invoice : {{ $invoice->nomor_invoice }}</h3>
                            @if($isInternal)
                            <div class="mb-2">
                                @if($invoice->status_pembayaran === 'lunas')
                                    <span style="display:inline-block; padding: 2px 8px; border: 2px solid #22c55e; color: #166534; font-weight: bold; border-radius: 4px; font-size: 11px; text-transform: uppercase;">LUNAS</span>
                                @else
                                    <span style="display:inline-block; padding: 2px 8px; border: 2px solid #ef4444; color: #991b1b; font-weight: bold; border-radius: 4px; font-size: 11px; text-transform: uppercase;">BELUM LUNAS</span>
                                @endif
                            </div>
                            @endif
                            <table class="w-full text-right text-sm" style="border: none;">
                                <tr>
                                    <td class="pr-2 py-1" style="border: none;">Tanggal:</td>
                                    <td class="font-semibold" style="border: none;">{{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->translatedFormat('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="pr-2 py-1" style="border: none;">Jatuh Tempo:</td>
                                    <td class="font-semibold" style="border: none;">
                                        @if($invoice->tanggal_jatuh_tempo)
                                            {{ \Carbon\Carbon::parse($invoice->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->addDays(30)->translatedFormat('d F Y') }}
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th style="width:24px">No</th>
                <th style="width:{{ $isInternal ? '50px' : '60px' }}">Kode Barang</th>
                <th style="min-width:120px">Nama Barang / Jasa</th>
                <th style="width:{{ $isInternal ? '50px' : '60px' }}">Merek</th>
                <th style="width:36px">Sat.</th>
                <th style="width:{{ $isInternal ? '55px' : '65px' }}">Kategori</th>
                <th style="width:30px">Jml</th>
                <th style="width:70px">Harga Satuan</th>
                <th style="width:75px">Total</th>
                @if($isInternal)
                <th class="bg-yellow-100" style="width:70px">Modal/Satuan</th>
                <th class="bg-yellow-100" style="width:75px">Total Modal</th>
                <th class="bg-yellow-100" style="width:70px">Keuntungan</th>
                @endif
            </tr>
        </thead>
        <tbody class="bg-transparent">
            @php 
                $total_modal = 0; 
            @endphp
            
            @foreach($invoice->invoiceItems as $index => $item)
                @php 
                    $modal_item = $item->harga_modal_snapshot * $item->jumlah;
                    $total_modal += $modal_item;
                    $keuntungan_item = $item->total_harga - $modal_item;
                @endphp
            <tr>
                <td class="bordered text-center">{{ $index + 1 }}</td>
                <td class="bordered text-center font-mono" style="font-size:9px;">{{ $item->product->sku ?? '-' }}</td>
                <td class="bordered text-left">
                    <span class="font-bold">{{ $item->product->nama_barang ?? 'Barang Dihapus' }}</span>
                </td>
                <td class="bordered text-center" style="font-size:9px; text-transform:uppercase;">{{ $item->product->merk->nama_merk ?? '-' }}</td>
                <td class="bordered text-center" style="text-transform:uppercase;">PCS</td>
                <td class="bordered text-center" style="font-size:9px;">{{ $item->product->category->nama_kategori ?? '-' }}</td>
                <td class="bordered text-center font-bold">{{ $item->jumlah }}</td>
                <td class="bordered text-right rp-num">Rp&nbsp;{{ number_format($item->harga_jual_snapshot, 0, ',', '.') }}</td>
                <td class="bordered text-right rp-num font-semibold">Rp&nbsp;{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                @if($isInternal)
                <td class="bordered text-right rp-num">Rp&nbsp;{{ number_format($item->harga_modal_snapshot, 0, ',', '.') }}</td>
                <td class="bordered text-right rp-num">Rp&nbsp;{{ number_format($modal_item, 0, ',', '.') }}</td>
                <td class="bordered text-right rp-num font-bold">Rp&nbsp;{{ number_format($keuntungan_item, 0, ',', '.') }}</td>
                @endif
            </tr>
            @endforeach
            
            <!-- TOTALS -->
            <tr class="font-bold" style="border-top: 2px solid #1f2937;">
                <td colspan="8" class="py-1 px-3 text-right bordered border-r">Sub Total</td>
                <td class="py-1 px-2 text-right bordered rp-num">Rp&nbsp;{{ number_format($invoice->sub_total, 0, ',', '.') }}</td>
                @if($isInternal)
                <td colspan="2" class="py-1 px-2 bordered bg-yellow-50 text-right align-middle rp-num" rowspan="3">Rp&nbsp;{{ number_format($total_modal, 0, ',', '.') }}</td>
                <td class="py-1 px-2 text-right bordered align-middle bg-yellow-50 border-l rp-num font-black" rowspan="3">
                    Rp&nbsp;{{ number_format($invoice->sub_total - $total_modal, 0, ',', '.') }}
                </td>
                @endif
            </tr>
            <tr class="font-bold">
                <td colspan="8" class="py-1 px-3 text-right bordered border-r">Pajak (PPN)</td>
                <td class="py-1 px-2 text-right bordered rp-num">Rp&nbsp;{{ number_format($invoice->pajak_ppn, 0, ',', '.') }}</td>
            </tr>
            <tr class="font-bold">
                <td colspan="8" class="py-1 px-3 text-right bordered border-r">Ongkos Kirim (Ongkir)</td>
                <td class="py-1 px-2 text-right bordered rp-num">Rp&nbsp;{{ number_format($invoice->ongkir ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr class="font-bold">
                <td colspan="8" class="py-1 px-3 text-right bordered border-r" style="background:#1f2937; color:#fff;">Total Tagihan</td>
                <td class="py-1 px-2 text-right bordered rp-num font-black" style="background:#1f2937; color:#fff;">Rp&nbsp;{{ number_format($invoice->total_tagihan, 0, ',', '.') }}</td>
            </tr>
            <!-- Terbilang -->
            <tr class="italic font-bold">
                <td colspan="{{ $totalColspan }}" class="py-2 px-4 text-left bordered border-t border-black">
                    <span class="mr-2">Terbilang :</span> 
                    {{ \App\Helpers\TerbilangHelper::terbilang($invoice->total_tagihan) }} Rupiah
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Informasi Pembayaran & Tanda Tangan -->
    <div class="mt-4 page-break-avoid" style="margin-bottom: 15mm;">
        <div class="text-sm mb-6">
            <p class="mb-1">Pembayaran dapat dilakukan Cash atau Transfer melalui rekening :</p>
            <table class="w-full max-w-sm" style="border: none;">
                <tr>
                    <td class="w-20 border-0 p-1">Bank</td>
                    <td class="font-bold border-0 p-1">: BSI</td>
                </tr>
                <tr>
                    <td class="border-0 p-1">No. Rek</td>
                    <td class="font-bold text-lg border-0 p-1">: 7343793687</td>
                </tr>
                <tr>
                    <td class="border-0 p-1">A/N</td>
                    <td class="font-bold border-0 p-1">: PT Utama Madani Raya</td>
                </tr>
            </table>
        </div>
        
        <div class="flex justify-end">
            <div class="text-center w-64 mr-8">
                <p class="font-bold uppercase mb-20">OWNER</p>
                <p class="border-b border-black font-bold uppercase pb-1 inline-block w-full">HJ. NORMAULIDA, S.H.</p>
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
</html>
