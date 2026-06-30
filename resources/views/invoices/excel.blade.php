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
    body, table { font-family: 'Segoe UI', Arial, sans-serif; font-size: 10pt; }
    td, th { padding: 4px 6px; vertical-align: middle; }
    .header-title { font-size: 15pt; font-weight: bold; color: #111827; }
    .header-sub { font-size: 10.5pt; font-weight: bold; color: #4b5563; }
    .header-addr { font-size: 9pt; color: #4b5563; }
    .title-banner {
        background-color: #f3f4f6;
        font-size: 13pt;
        font-weight: bold;
        text-align: center;
        letter-spacing: 2px;
        border-top: 1.5px solid #000000;
        border-bottom: 1.5px solid #000000;
        padding: 6px 0;
    }
    .table-header {
        background-color: #1f2937;
        color: #ffffff;
        font-size: 9.5pt;
        font-weight: bold;
        text-transform: uppercase;
        text-align: center;
        border: 1px solid #000000;
        padding: 6px;
    }
    .bordered {
        border: 1px solid #000000;
    }
    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .text-left { text-align: left; }
    .bold { font-weight: bold; }
    .italic { font-style: italic; }
    .total-row td {
        font-weight: bold;
        border: 1px solid #000000;
    }
    .grand-total {
        background-color: #1f2937;
        color: #ffffff;
        font-weight: bold;
        font-size: 11pt;
        border: 1px solid #000000;
    }
    .terbilang {
        font-style: italic;
        font-weight: bold;
        font-size: 9.5pt;
        background-color: #f9fafb;
        border: 1px solid #000000;
        padding: 6px;
    }
    .rp-format {
        mso-number-format: '"Rp "* \#\,\#\#0;[Red]\("Rp "* \#\,\#\#0\);"-"';
        text-align: right;
    }
    .qty-format {
        mso-number-format: '#\,\#\#0';
        text-align: center;
    }
    .bank-header {
        background-color: #f3f4f6;
        font-weight: bold;
        border: 1px solid #000000;
    }
    .ttd-header {
        font-weight: bold;
        text-align: center;
        text-transform: uppercase;
        border-top: 1px solid #000000;
        border-left: 1px solid #000000;
        border-right: 1px solid #000000;
    }
    .ttd-side-border {
        border-left: 1px solid #000000;
        border-right: 1px solid #000000;
    }
    .ttd-name {
        font-weight: bold;
        text-align: center;
        border-left: 1px solid #000000;
        border-right: 1px solid #000000;
        text-decoration: underline;
    }
    .ttd-footer {
        font-size: 8.5pt;
        text-align: center;
        border-left: 1px solid #000000;
        border-right: 1px solid #000000;
        border-bottom: 1px solid #000000;
    }
    .footer-bar {
        background-color: #1f2937;
        color: #ffffff;
        text-align: center;
        font-size: 8.5pt;
        font-weight: bold;
        padding: 8px 0;
    }
</style>
</head>
<body>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <colgroup>
        <col width="35" style="width: 35px;">
        <col width="90" style="width: 90px;">
        <col width="280" style="width: 280px;">
        <col width="80" style="width: 80px;">
        <col width="50" style="width: 50px;">
        <col width="100" style="width: 100px;">
        <col width="50" style="width: 50px;">
        <col width="110" style="width: 110px;">
        <col width="120" style="width: 120px;">
    </colgroup>

    <!-- KOP SURAT -->
    <tr>
        <td colspan="9" class="header-title">PT. UTAMA MADANI RAYA</td>
    </tr>
    <tr>
        <td colspan="9" class="header-sub">Distributor &amp; Mitra Pengadaan Barang</td>
    </tr>
    <tr>
        <td colspan="9" class="header-addr">Jl. Panglima Batur, Banjarbaru Utara, Kota Banjarbaru, Kalimantan Selatan</td>
    </tr>
    <tr>
        <td colspan="9" class="header-addr">WA: 0851-6665-7171 | Web: www.ptutamamadaniraya.com</td>
    </tr>
    <tr>
        <td colspan="9" style="border-bottom: 3px solid #000000; height: 5px;">&nbsp;</td>
    </tr>

    <!-- SPACER -->
    <tr height="10"><td colspan="9">&nbsp;</td></tr>

    <!-- JUDUL -->
    <tr>
        <td colspan="9" class="title-banner">FAKTUR / INVOICE</td>
    </tr>

    <!-- SPACER -->
    <tr height="10"><td colspan="9">&nbsp;</td></tr>

    <!-- INFO SECTION -->
    <tr>
        <td colspan="2" class="bold">Kepada</td>
        <td colspan="3" class="bold" style="font-size: 11pt; text-transform: uppercase;">: {{ $invoice->nama_klien }}</td>
        <td colspan="2" class="bold text-right">No. Invoice</td>
        <td colspan="2" class="bold" style="font-size: 10.5pt;">: {{ $invoice->nomor_invoice }}</td>
    </tr>
    @if($invoice->customer && $invoice->customer->nomor_hp)
    <tr>
        <td colspan="2" class="bold">Telepon</td>
        <td colspan="3">: {{ $invoice->customer->nomor_hp }}</td>
        <td colspan="2" class="bold text-right">Tanggal</td>
        <td>: {{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->translatedFormat('d F Y') }}</td>
        <td>&nbsp;</td>
    </tr>
    @else
    <tr>
        <td colspan="5">&nbsp;</td>
        <td colspan="2" class="bold text-right">Tanggal</td>
        <td>: {{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->translatedFormat('d F Y') }}</td>
        <td>&nbsp;</td>
    </tr>
    @endif
    <tr>
        <td colspan="2" class="bold" style="vertical-align: top;">Alamat</td>
        <td colspan="3" style="font-size: 9.5pt; vertical-align: top;">: {{ $invoice->alamat_pengiriman ?? '-' }}</td>
        <td colspan="2" class="bold text-right">Jatuh Tempo</td>
        <td>: @if($invoice->tanggal_jatuh_tempo){{ \Carbon\Carbon::parse($invoice->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}@else{{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->addDays(30)->translatedFormat('d F Y') }}@endif</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
        <td colspan="2" class="bold text-right">Status</td>
        <td class="bold" style="text-transform: uppercase;">: {{ $invoice->status_pembayaran === 'lunas' ? 'LUNAS' : 'BELUM LUNAS' }}</td>
        <td>&nbsp;</td>
    </tr>

    <!-- SPACER -->
    <tr height="10"><td colspan="9">&nbsp;</td></tr>

    <!-- TABEL BARANG HEADER -->
    <tr>
        <th class="table-header">No</th>
        <th class="table-header">Kode Brg</th>
        <th class="table-header">Nama Barang / Jasa</th>
        <th class="table-header">Merek</th>
        <th class="table-header">Sat.</th>
        <th class="table-header">Kategori</th>
        <th class="table-header">Qty</th>
        <th class="table-header">Harga Satuan</th>
        <th class="table-header">Subtotal</th>
    </tr>

    <!-- TABEL BARANG DATA -->
    @foreach($invoice->invoiceItems as $index => $item)
    <tr>
        <td class="bordered text-center">{{ $index + 1 }}</td>
        <td class="bordered text-center" style="font-family: 'Courier New', Courier, monospace; font-size: 9.5pt;">{{ $item->product->sku ?? '-' }}</td>
        <td class="bordered text-left bold">{{ $item->product->nama_barang ?? 'Barang Dihapus' }}</td>
        <td class="bordered text-center" style="text-transform: uppercase; font-size: 9pt;">{{ $item->product->merk->nama_merk ?? '-' }}</td>
        <td class="bordered text-center" style="text-transform: uppercase;">{{ $item->product->satuan ?? 'PCS' }}</td>
        <td class="bordered text-center" style="font-size: 9pt;">{{ $item->product->category->nama_kategori ?? '-' }}</td>
        <td class="bordered qty-format bold">{{ $item->jumlah }}</td>
        <td class="bordered rp-format">{{ $item->harga_jual_snapshot }}</td>
        <td class="bordered rp-format bold">{{ $item->total_harga }}</td>
    </tr>
    @endforeach

    <!-- TOTALS -->
    <tr class="total-row">
        <td colspan="8" class="text-right bordered">Sub Total</td>
        <td class="bordered rp-format">{{ $invoice->sub_total }}</td>
    </tr>
    <tr class="total-row">
        <td colspan="8" class="text-right bordered">PPN ({{ $invoice->pajak_ppn > 0 ? '11%' : '0%' }})</td>
        <td class="bordered rp-format">{{ $invoice->pajak_ppn }}</td>
    </tr>
    <tr class="total-row">
        <td colspan="8" class="text-right bordered">Ongkos Kirim</td>
        <td class="bordered rp-format">{{ $invoice->ongkir ?? 0 }}</td>
    </tr>
    <tr>
        <td colspan="8" class="grand-total text-right">TOTAL TAGIHAN</td>
        <td class="grand-total rp-format">{{ $invoice->total_tagihan }}</td>
    </tr>
    <tr>
        <td colspan="9" class="terbilang">
            Terbilang : {{ \App\Helpers\TerbilangHelper::terbilang($invoice->total_tagihan) }} Rupiah
        </td>
    </tr>

    <!-- SPACER -->
    <tr height="15"><td colspan="9">&nbsp;</td></tr>

    <!-- SIGNATURES & PAYMENT BLOCK -->
    <tr>
        <td colspan="4" class="bank-header bold">INFORMASI PEMBAYARAN</td>
        <td>&nbsp;</td>
        <td colspan="2" class="ttd-header bold">Penerima / Klien</td>
        <td colspan="2" class="ttd-header bold">Hormat Kami</td>
    </tr>
    <tr height="22">
        <td class="bordered bold" style="border-bottom: none; border-right: none;">Bank</td>
        <td colspan="3" class="bordered bold" style="border-bottom: none; border-left: none; font-size: 11pt;">: BSI</td>
        <td>&nbsp;</td>
        <td colspan="2" class="ttd-side-border">&nbsp;</td>
        <td colspan="2" class="ttd-side-border">&nbsp;</td>
    </tr>
    <tr height="22">
        <td class="bordered bold" style="border-top: none; border-bottom: none; border-right: none;">No. Rek</td>
        <td colspan="3" class="bordered bold" style="border-top: none; border-bottom: none; border-left: none; font-size: 12.5pt; letter-spacing: 0.5px;">: 7343793687</td>
        <td>&nbsp;</td>
        <td colspan="2" class="ttd-side-border">&nbsp;</td>
        <td colspan="2" class="ttd-side-border">&nbsp;</td>
    </tr>
    <tr>
        <td class="bordered bold" style="border-top: none; border-right: none;">A/N</td>
        <td colspan="3" class="bordered bold" style="border-top: none; border-left: none;">: PT Utama Madani Raya</td>
        <td>&nbsp;</td>
        <td colspan="2" class="ttd-name">{{ $invoice->nama_klien }}</td>
        <td colspan="2" class="ttd-name">HJ. NORMAULIDA, S.H.</td>
    </tr>
    <tr>
        <td colspan="4" class="bordered italic" style="font-size: 8.5pt; border-top: none;">
            Pembayaran dapat dilakukan melalui transfer bank atau tunai.<br>
            Harap konfirmasi pembayaran ke: WA 0851-6665-7171
        </td>
        <td>&nbsp;</td>
        <td colspan="2" class="ttd-footer">(Tanda Tangan &amp; Cap)</td>
        <td colspan="2" class="ttd-footer">(Tanda Tangan &amp; Cap)</td>
    </tr>

    <!-- SPACER -->
    <tr height="15"><td colspan="9">&nbsp;</td></tr>

    <!-- FOOTER BAR -->
    <tr>
        <td colspan="9" class="footer-bar">
            PT. UTAMA MADANI RAYA &nbsp;|&nbsp; Jl. Panglima Batur, Banjarbaru Utara, Kalimantan Selatan &nbsp;|&nbsp; WA: 0851-6665-7171 &nbsp;|&nbsp; www.ptutamamadaniraya.com
        </td>
    </tr>
</table>

</body>
</html>
