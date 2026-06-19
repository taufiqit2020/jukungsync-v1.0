<?php
$content = file_get_contents('show.blade.php.bak');

// 1. Clean up CSS - Remove all print position: fixed and repeating hacks
$css_replace = <<<EOD
        @media print {
            .no-print { display: none !important; }
            @page { 
                size: A4 portrait; 
                margin: 10mm 15mm; 
            }
            body { 
                margin: 0 !important; 
                padding: 0 !important; 
                background-color: transparent !important;
            }
            .inner-table tr {
                page-break-inside: avoid;
            }
            .mt-auto { margin-top: 2rem !important; }
            .page-break-avoid { page-break-inside: avoid !important; }
            img { max-width: 100% !important; height: auto !important; }
            .watermark { z-index: -1 !important; opacity: 0.1 !important; }
        }
        
        /* For screen view */
        @media screen {
            
        }
EOD;

$content = preg_replace('/@media print\s*\{.*?\/\*\s*For screen view\s*\*\/\s*@media screen\s*\{[^}]+\}/s', $css_replace, $content);

// 2. We need to extract the "KEPADA" block, the items loop, the totals, and the signature block.
// Since it's complex, let's just write the body manually while keeping the dynamic parts.

$body = <<<EOD
<body class="max-w-5xl mx-auto p-4 md:p-8 relative">

    <!-- Tombol Print -->
    <div class="no-print mb-6 flex justify-end gap-2">
        @if(\$invoice->status_pembayaran === 'belum_lunas' && in_array(auth()->user()->role, ['staf_admin', 'bendahara', 'superadmin']))
        <form action="{{ route('invoices.mark-paid', \$invoice) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menandai invoice ini sebagai LUNAS?');">
            @csrf
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-semibold flex items-center shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Tandai Lunas
            </button>
        </form>
        @endif

        @if(!\$isInternal)
        <a href="{{ route('invoices.show', ['invoice' => \$invoice->id, 'mode' => 'internal']) }}" class="bg-gray-200 hover:bg-gray-300 text-black px-4 py-2 rounded text-sm font-semibold">Beralih ke Tampilan Internal</a>
        @else
        <a href="{{ route('invoices.show', \$invoice->id) }}" class="bg-gray-200 hover:bg-gray-300 text-black px-4 py-2 rounded text-sm font-semibold">Beralih ke Tampilan Klien</a>
        @endif
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak (Ctrl+P)
        </button>
    </div>

    <!-- Watermark Background -->
    <img src="{{ asset('img/watermark-tengah.png') }}" alt="Watermark" class="watermark">

    <!-- MAIN INVOICE TABLE -->
    <table class="w-full table-border border-collapse {{ \$isInternal ? 'text-[10px]' : 'text-sm' }} text-center bg-transparent inner-table" style="position: relative; z-index: 10;">
        <thead class="bg-transparent">
            <tr>
                @php \$totalColspan = \$isInternal ? 12 : 9; @endphp
                <td colspan="{{ \$totalColspan }}" class="!border-0 p-0 text-left bg-transparent">
                    <img src="{{ asset('img/invoice-header.png') }}" alt="Kop Surat PT UMAR" class="w-full h-auto object-contain mb-6">
                    
                    <div class="flex justify-between mb-6 text-black px-2">
                        <div>
                            <p class="font-bold uppercase border-b border-black pb-1 inline-block mb-1">KEPADA :</p>
                            <h3 class="font-bold text-lg uppercase">{{ \$invoice->nama_klien }}</h3>
                        </div>
                        <div class="text-right">
                            <h3 class="font-bold text-lg mb-2">No. Invoice : {{ \$invoice->nomor_invoice }}</h3>
                            @if(\$isInternal)
                            <div class="mb-2">
                                @if(\$invoice->status_pembayaran === 'lunas')
                                    <span style="display:inline-block; padding: 2px 8px; border: 2px solid #22c55e; color: #166534; font-weight: bold; border-radius: 4px; font-size: 11px; text-transform: uppercase;">LUNAS</span>
                                @else
                                    <span style="display:inline-block; padding: 2px 8px; border: 2px solid #ef4444; color: #991b1b; font-weight: bold; border-radius: 4px; font-size: 11px; text-transform: uppercase;">BELUM LUNAS</span>
                                @endif
                            </div>
                            @endif
                            <table class="w-full text-right text-sm">
                                <tr>
                                    <td class="pr-2 py-1 border-0">Tanggal:</td>
                                    <td class="font-semibold border-0">{{ \Carbon\Carbon::parse(\$invoice->tanggal_invoice)->translatedFormat('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="pr-2 py-1 border-0">Jatuh Tempo:</td>
                                    <td class="font-semibold border-0">
                                        @if(\$invoice->tanggal_jatuh_tempo)
                                            {{ \Carbon\Carbon::parse(\$invoice->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse(\$invoice->tanggal_invoice)->addDays(30)->translatedFormat('d F Y') }}
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="font-bold bg-gray-100">
                <th class="py-1 px-1 w-8">No</th>
                <th class="py-1 px-1 {{ \$isInternal ? 'w-16' : 'w-24' }}">Kode Barang</th>
                <th class="py-1 px-1">Nama Barang / Jasa</th>
                <th class="py-1 px-1 {{ \$isInternal ? 'w-16' : 'w-24' }}">Merek</th>
                <th class="py-1 px-1 {{ \$isInternal ? 'w-16' : 'w-24' }}">Kategori</th>
                <th class="py-1 px-1">Harga Satuan</th>
                <th class="py-1 px-1 w-10">Jumlah</th>
                <th class="py-1 px-1 w-12">Satuan</th>
                <th class="py-1 px-1">Total</th>
                
                @if(\$isInternal)
                <th class="py-2 px-2 bg-yellow-100">Modal Sesuai Struk</th>
                <th class="py-2 px-2 bg-yellow-100">Total Harga Modal</th>
                <th class="py-2 px-2 bg-yellow-100">Keuntungan</th>
                @endif
            </tr>
        </thead>
        <tbody class="bg-transparent">
            @php 
                \$total_modal = 0; 
            @endphp
            
            @foreach(\$invoice->invoiceItems as \$index => \$item)
                @php 
                    \$modal_item = \$item->harga_modal_snapshot * \$item->jumlah;
                    \$total_modal += \$modal_item;
                    \$keuntungan_item = \$item->total_harga - \$modal_item;
                @endphp
            <tr>
                <td class="py-2 px-2">{{ \$index + 1 }}</td>
                <td class="py-2 px-2 font-mono text-xs">{{ \$item->product->sku ?? '-' }}</td>
                <td class="py-2 px-2 text-left">
                    <span class="font-bold">{{ \$item->product->nama_barang ?? 'Barang Dihapus' }}</span>
                </td>
                <td class="py-2 px-2 text-xs uppercase">{{ \$item->product->merk->nama_merk ?? '-' }}</td>
                <td class="py-2 px-2 text-xs">{{ \$item->product->category->nama_kategori ?? '-' }}</td>
                <td class="py-2 px-2 text-right">Rp{{ number_format(\$item->harga_jual_snapshot, 2, ',', '.') }}</td>
                <td class="py-2 px-2">{{ \$item->jumlah }}</td>
                <td class="py-2 px-2 uppercase">PCS</td>
                <td class="py-2 px-2 text-right">Rp{{ number_format(\$item->total_harga, 2, ',', '.') }}</td>
                
                @if(\$isInternal)
                <td class="py-2 px-2 text-right">Rp {{ number_format(\$item->harga_modal_snapshot, 0, ',', '.') }}</td>
                <td class="py-2 px-2 text-right">Rp {{ number_format(\$modal_item, 0, ',', '.') }}</td>
                <td class="py-2 px-2 text-right border-l">Rp {{ number_format(\$keuntungan_item, 0, ',', '.') }}</td>
                @endif
            </tr>
            @endforeach
            
            <!-- Baris Kosong Pelengkap (Filler) -->
            @for(\$i = 0; \$i < max(0, 6 - count(\$invoice->invoiceItems)); \$i++)
            <tr>
                <td class="py-2 px-2 text-transparent">-</td>
                <td class="py-2 px-2 text-transparent">-</td>
                <td class="py-2 px-2 text-transparent">-</td>
                <td class="py-2 px-2 text-transparent">-</td>
                <td class="py-2 px-2 text-transparent">-</td>
                <td class="py-2 px-2 text-transparent">-</td>
                <td class="py-2 px-2 text-transparent">-</td>
                <td class="py-2 px-2 text-transparent">-</td>
                <td class="py-2 px-2 text-transparent">-</td>
                @if(\$isInternal)
                <td class="py-2 px-2 text-transparent">-</td>
                <td class="py-2 px-2 text-transparent">-</td>
                <td class="py-2 px-2 text-transparent border-l">-</td>
                @endif
            </tr>
            @endfor
            
            <!-- TOTALS (Now inside tbody so they don't repeat on every page) -->
            <tr class="font-bold border-t-2 border-black">
                <td colspan="8" class="py-2 px-4 text-right border-r">Sub Total</td>
                <td class="py-2 px-2 text-right">Rp{{ number_format(\$invoice->sub_total, 2, ',', '.') }}</td>
                
                @if(\$isInternal)
                <td colspan="2" class="py-2 px-2 bg-yellow-50 text-center align-middle" rowspan="3" style="font-size: 1.1em;">Rp{{ number_format(\$total_modal, 0, ',', '.') }}</td>
                <td class="py-2 px-2 text-center align-middle bg-yellow-50 border-l" rowspan="3" style="font-size: 1.1em;">
                    Rp{{ number_format(\$invoice->sub_total - \$total_modal, 2, ',', '.') }}
                </td>
                @endif
            </tr>
            <tr class="font-bold">
                <td colspan="8" class="py-2 px-4 text-right border-r">Pajak (PPN)</td>
                <td class="py-2 px-2 text-right">Rp{{ number_format(\$invoice->pajak_ppn, 2, ',', '.') }}</td>
            </tr>
            <tr class="font-bold">
                <td colspan="8" class="py-2 px-4 text-right border-r">Total Tagihan</td>
                <td class="py-2 px-2 text-right">Rp{{ number_format(\$invoice->total_tagihan, 2, ',', '.') }}</td>
            </tr>
            <!-- Terbilang -->
            <tr class="italic font-bold">
                <td colspan="{{ \$totalColspan }}" class="py-2 px-4 text-left border-t border-black">
                    <span class="mr-2">Terbilang :</span> 
                    {{ \App\Helpers\TerbilangHelper::terbilang(\$invoice->total_tagihan) }} Rupiah
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Informasi Pembayaran & Tanda Tangan -->
    <div class="mt-8 flex justify-between page-break-avoid">
        <div class="text-sm">
            <p class="mb-1">Pembayaran dapat dilakukan Cash atau Transfer melalui rekening :</p>
            <table class="w-full max-w-sm">
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
        <div class="text-center w-64 mr-8">
            <p class="font-bold uppercase mb-20">OWNER</p>
            <p class="border-b border-black font-bold uppercase pb-1 inline-block w-full">HJ. NORMAULIDA, S.H.</p>
        </div>
    </div>

    <!-- Banner Footer (Absolute standard flow) -->
    <div class="mt-12 header-bg p-2 text-center text-sm font-semibold tracking-wide" style="border-radius: 4px; background-color: #111827; color: white;">
        Alamat Kantor : Jl. Panglima Batur Banjarbaru Utara, Banjarbaru Kalimantan Selatan
    </div>

</body>
</html>
EOD;

$content = preg_replace('/<body.*<\/body>/s', $body, $content);

file_put_contents('resources/views/invoices/show.blade.php', $content);
echo "Modification complete.";
