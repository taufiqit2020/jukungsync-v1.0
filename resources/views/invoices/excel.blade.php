<html xmlns:xx="urn:schemas-microsoft-com:office:excel"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="ProgId" content="Excel.Sheet">
<meta name="Generator" content="Microsoft Excel 15">
<!--[if gte mso 9]>
<xml>
<xx:ExcelWorkbook>
<xx:ExcelWorksheets>
<xx:ExcelWorksheet>
<xx:Name>Invoice {{ $invoice->nomor_invoice }}</xx:Name>
<xx:WorksheetOptions>
<xx:DisplayGridlines/>
<xx:Print>
<xx:ValidPrinterInfo/>
</xx:Print>
</xx:WorksheetOptions>
</xx:ExcelWorksheet>
</xx:ExcelWorksheets>
</xx:ExcelWorkbook>
</xml>
<![endif]-->
<style>
    table { border-collapse: collapse; font-family: 'Arial', sans-serif; font-size: 11px; }
    td, th { padding: 5px 6px; vertical-align: middle; }
    .header-title { font-size: 16px; font-weight: bold; text-transform: uppercase; }
    .header-sub { font-size: 11px; font-weight: bold; }
    .header-addr { font-size: 10px; color: #333; }
    .table-header {
        background-color: #1f2937;
        color: #ffffff;
        font-size: 10px;
        font-weight: bold;
        text-transform: uppercase;
        text-align: center;
        border: 1px solid #000;
    }
    .bordered {
        border: 1px solid #374151;
    }
    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .text-left { text-align: left; }
    .bold { font-weight: bold; }
    .total-row {
        font-weight: bold;
        border: 1px solid #374151;
    }
    .grand-total {
        background-color: #1f2937;
        color: #ffffff;
        font-weight: bold;
        font-size: 12px;
        border: 1px solid #000;
    }
    .terbilang {
        font-style: italic;
        font-weight: bold;
        font-size: 10px;
    }
    .rp-format {
        mso-number-format: '\Rp\ \#\,\#\#0';
        text-align: right;
    }
</style>
</head>
<body>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <!-- KOP SURAT -->
    <tr>
        <td colspan="9" style="padding-bottom: 3px;">
            <span class="header-title">PT. UTAMA MADANI RAYA</span>
        </td>
    </tr>
    <tr>
        <td colspan="9">
            <span class="header-sub">Distributor &amp; Mitra Pengadaan Barang</span>
        </td>
    </tr>
    <tr>
        <td colspan="9">
            <span class="header-addr">Jl. Panglima Batur, Banjarbaru Utara, Kota Banjarbaru, Kalimantan Selatan</span>
        </td>
    </tr>
    <tr>
        <td colspan="9">
            <span class="header-addr">WA: 0851-6665-7171 | Web: www.ptutamamadaniraya.com</span>
        </td>
    </tr>
    <tr><td colspan="9" style="border-bottom: 2px solid #000; padding: 3px 0;">&nbsp;</td></tr>

    <!-- JUDUL -->
    <tr>
        <td colspan="9" style="text-align: center; padding: 8px 0; font-size: 14px; font-weight: bold; letter-spacing: 3px; text-transform: uppercase;">
            FAKTUR / INVOICE
        </td>
    </tr>

    <!-- INFO -->
    <tr>
        <td colspan="2" class="bold" style="padding: 3px 5px;">Kepada</td>
        <td colspan="3" style="padding: 3px 5px; font-weight: bold; font-size: 13px; text-transform: uppercase;">: {{ $invoice->nama_klien }}</td>
        <td colspan="2" class="bold text-right" style="padding: 3px 5px;">No. Invoice</td>
        <td colspan="2" style="padding: 3px 5px; font-weight: bold; font-size: 12px;">: {{ $invoice->nomor_invoice }}</td>
    </tr>
    @if($invoice->customer && $invoice->customer->telepon)
    <tr>
        <td colspan="2" class="bold" style="padding: 2px 5px;">Telepon</td>
        <td colspan="3" style="padding: 2px 5px;">: {{ $invoice->customer->telepon }}</td>
        <td colspan="2" class="bold text-right" style="padding: 2px 5px;">Tanggal</td>
        <td colspan="2" style="padding: 2px 5px;">: {{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->translatedFormat('d F Y') }}</td>
    </tr>
    @else
    <tr>
        <td colspan="5">&nbsp;</td>
        <td colspan="2" class="bold text-right" style="padding: 2px 5px;">Tanggal</td>
        <td colspan="2" style="padding: 2px 5px;">: {{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->translatedFormat('d F Y') }}</td>
    </tr>
    @endif
    <tr>
        @if($invoice->alamat_pengiriman)
        <td colspan="2" class="bold" style="padding: 2px 5px; vertical-align: top;">Alamat</td>
        <td colspan="3" style="padding: 2px 5px; font-size: 10px;">: {{ $invoice->alamat_pengiriman }}</td>
        @else
        <td colspan="5">&nbsp;</td>
        @endif
        <td colspan="2" class="bold text-right" style="padding: 2px 5px;">Jatuh Tempo</td>
        <td colspan="2" style="padding: 2px 5px;">: @if($invoice->tanggal_jatuh_tempo){{ \Carbon\Carbon::parse($invoice->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}@else{{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->addDays(30)->translatedFormat('d F Y') }}@endif</td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
        <td colspan="2" class="bold text-right" style="padding: 2px 5px;">Status</td>
        <td colspan="2" style="padding: 2px 5px; font-weight: bold; text-transform: uppercase;">: {{ $invoice->status_pembayaran === 'lunas' ? 'LUNAS' : 'BELUM LUNAS' }}</td>
    </tr>

    <!-- SPACER -->
    <tr><td colspan="9" style="padding: 4px 0;">&nbsp;</td></tr>
</table>

<!-- TABEL BARANG -->
<table border="1" cellpadding="5" cellspacing="0" width="100%" style="border: 1px solid #000;">
    <thead>
        <tr>
            <th width="4%" class="table-header">No</th>
            <th width="10%" class="table-header">Kode Brg</th>
            <th width="28%" class="table-header">Nama Barang / Jasa</th>
            <th width="10%" class="table-header">Merek</th>
            <th width="6%" class="table-header">Sat.</th>
            <th width="8%" class="table-header">Kategori</th>
            <th width="5%" class="table-header">Qty</th>
            <th width="14%" class="table-header">Harga Satuan</th>
            <th width="15%" class="table-header">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoice->invoiceItems as $index => $item)
        <tr>
            <td class="bordered text-center">{{ $index + 1 }}</td>
            <td class="bordered text-center" style="font-size: 10px; font-family: 'Courier New', monospace;">{{ $item->product->sku ?? '-' }}</td>
            <td class="bordered text-left bold">{{ $item->product->nama_barang ?? 'Barang Dihapus' }}</td>
            <td class="bordered text-center" style="font-size: 10px; text-transform: uppercase;">{{ $item->product->merk->nama_merk ?? '-' }}</td>
            <td class="bordered text-center" style="text-transform: uppercase;">{{ $item->product->satuan ?? 'PCS' }}</td>
            <td class="bordered text-center" style="font-size: 10px;">{{ $item->product->category->nama_kategori ?? '-' }}</td>
            <td class="bordered text-center bold">{{ $item->jumlah }}</td>
            <td class="bordered text-right">Rp {{ number_format($item->harga_jual_snapshot, 0, ',', '.') }}</td>
            <td class="bordered text-right bold">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
        </tr>
        @endforeach

        <!-- TOTALS -->
        <tr class="total-row">
            <td colspan="8" class="bordered text-right" style="padding: 5px 8px;">Sub Total</td>
            <td class="bordered text-right">Rp {{ number_format($invoice->sub_total, 0, ',', '.') }}</td>
        </tr>
        <tr class="total-row">
            <td colspan="8" class="bordered text-right" style="padding: 5px 8px;">PPN ({{ $invoice->pajak_ppn > 0 ? '11%' : '0%' }})</td>
            <td class="bordered text-right">Rp {{ number_format($invoice->pajak_ppn, 0, ',', '.') }}</td>
        </tr>
        <tr class="total-row">
            <td colspan="8" class="bordered text-right" style="padding: 5px 8px;">Ongkos Kirim</td>
            <td class="bordered text-right">Rp {{ number_format($invoice->ongkir ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td colspan="8" class="grand-total text-right" style="padding: 6px 8px;">TOTAL TAGIHAN</td>
            <td class="grand-total text-right" style="padding: 6px 8px;">Rp {{ number_format($invoice->total_tagihan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td colspan="9" class="bordered terbilang" style="padding: 4px 8px;">
                Terbilang : {{ \App\Helpers\TerbilangHelper::terbilang($invoice->total_tagihan) }} Rupiah
            </td>
        </tr>
    </tbody>
</table>

<!-- INFO BAYAR & TTD -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 15px;">
    <tr>
        <td width="55%" valign="top">
            <table border="0" cellpadding="3" cellspacing="0" width="100%">
                <tr><td colspan="3" style="font-weight: bold; font-size: 10px; border-bottom: 1px solid #000; padding-bottom: 3px;">INFORMASI PEMBAYARAN</td></tr>
                <tr>
                    <td width="20%" class="bold">Bank</td>
                    <td width="5%">:</td>
                    <td class="bold" style="font-size: 12px;">BSI</td>
                </tr>
                <tr>
                    <td class="bold">No. Rek</td>
                    <td>:</td>
                    <td class="bold" style="font-size: 14px; letter-spacing: 1px;">7343793687</td>
                </tr>
                <tr>
                    <td class="bold">A/N</td>
                    <td>:</td>
                    <td class="bold">PT Utama Madani Raya</td>
                </tr>
                <tr>
                    <td colspan="3" style="font-size: 9px; font-style: italic; padding-top: 5px;">
                        Pembayaran dapat dilakukan melalui transfer bank atau tunai.<br>
                        Harap konfirmasi pembayaran ke: WA 0851-6665-7171
                    </td>
                </tr>
            </table>
        </td>
        <td width="5%">&nbsp;</td>
        <td width="20%" valign="top" align="center" style="border: 1px solid #000; padding: 5px;">
            <div style="font-weight: bold; text-transform: uppercase; font-size: 10px; border-bottom: 1px solid #000; padding-bottom: 3px; margin-bottom: 5px;">Penerima / Klien</div>
            <div style="height: 50px;">&nbsp;</div>
            <div style="border-top: 1px solid #000; padding-top: 3px; font-weight: bold;">{{ $invoice->nama_klien }}</div>
            <div style="font-size: 8px;">(Tanda Tangan &amp; Cap)</div>
        </td>
        <td width="2%">&nbsp;</td>
        <td width="18%" valign="top" align="center" style="border: 1px solid #000; padding: 5px;">
            <div style="font-weight: bold; text-transform: uppercase; font-size: 10px; border-bottom: 1px solid #000; padding-bottom: 3px; margin-bottom: 5px;">Hormat Kami</div>
            <div style="height: 50px;">&nbsp;</div>
            <div style="border-top: 1px solid #000; padding-top: 3px; font-weight: bold;">HJ. NORMAULIDA, S.H.</div>
            <div style="font-size: 8px;">(Tanda Tangan &amp; Cap)</div>
        </td>
    </tr>
</table>

<!-- FOOTER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 20px;">
    <tr>
        <td style="background-color: #1f2937; color: white; text-align: center; padding: 8px; font-size: 10px; font-weight: bold;">
            PT. UTAMA MADANI RAYA | Jl. Panglima Batur, Banjarbaru Utara, Kalimantan Selatan | WA: 0851-6665-7171 | www.ptutamamadaniraya.com
        </td>
    </tr>
</table>

</body>
</html>
