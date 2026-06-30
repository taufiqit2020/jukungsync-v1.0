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
<xx:Name>Slip Gaji {{ $slipGaji->nama_karyawan }}</xx:Name>
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
        font-size: 12pt;
        font-weight: bold;
        text-align: center;
        letter-spacing: 2px;
        border-top: 1.5px solid #000000;
        border-bottom: 1.5px solid #000000;
        padding: 5px 0;
    }
    .table-header {
        background-color: #e5e7eb;
        color: #1f2937;
        font-size: 9.5pt;
        font-weight: bold;
        text-transform: uppercase;
        text-align: center;
        border: 1px solid #000000;
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
    .ttd-header {
        font-weight: bold;
        text-align: center;
        text-transform: uppercase;
    }
    .ttd-name {
        font-weight: bold;
        text-align: center;
        text-decoration: underline;
    }
    .ttd-footer {
        font-size: 8.5pt;
        text-align: center;
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
        <col width="180" style="width: 180px;">
        <col width="120" style="width: 120px;">
        <col width="30" style="width: 30px;">
        <col width="180" style="width: 180px;">
        <col width="120" style="width: 120px;">
        <col width="30" style="width: 30px;">
    </colgroup>

    <!-- KOP SURAT -->
    <tr>
        <td colspan="6" class="header-title">PT. UTAMA MADANI RAYA</td>
    </tr>
    <tr>
        <td colspan="6" class="header-sub">Distributor &amp; Mitra Pengadaan Barang</td>
    </tr>
    <tr>
        <td colspan="6" class="header-addr">Jl. Panglima Batur, Banjarbaru Utara, Kota Banjarbaru, Kalimantan Selatan</td>
    </tr>
    <tr>
        <td colspan="6" class="header-addr">WA: 0851-6665-7171 | Web: www.ptutamamadaniraya.com</td>
    </tr>
    <tr>
        <td colspan="6" style="border-bottom: 3px solid #000000; height: 5px;">&nbsp;</td>
    </tr>

    <!-- SPACER -->
    <tr height="10"><td colspan="6">&nbsp;</td></tr>

    <!-- JUDUL -->
    <tr>
        <td colspan="6" class="title-banner">SLIP GAJI KARYAWAN</td>
    </tr>

    <!-- SPACER -->
    <tr height="10"><td colspan="6">&nbsp;</td></tr>

    <!-- INFO SECTION -->
    <tr>
        <td class="bold">No. Slip</td>
        <td colspan="2">: {{ $slipGaji->nomor_slip }}</td>
        <td class="bold">Nama Karyawan</td>
        <td colspan="2">: {{ $slipGaji->nama_karyawan }}</td>
    </tr>
    <tr>
        <td class="bold">Periode</td>
        <td colspan="2">: {{ $slipGaji->periode }}</td>
        <td class="bold">Jabatan</td>
        <td colspan="2">: {{ $slipGaji->jabatan ?? '-' }}</td>
    </tr>

    <!-- SPACER -->
    <tr height="10"><td colspan="6">&nbsp;</td></tr>

    <!-- TABLE HEADER -->
    <tr>
        <th colspan="2" class="table-header">I. PENDAPATAN (EARNINGS)</th>
        <th>&nbsp;</th>
        <th colspan="2" class="table-header">II. POTONGAN (DEDUCTIONS)</th>
        <th>&nbsp;</th>
    </tr>

    <!-- DATA ROW 1 -->
    <tr>
        <td class="bordered">Gaji Pokok</td>
        <td class="bordered rp-format">{{ $slipGaji->gaji_pokok }}</td>
        <td>&nbsp;</td>
        <td class="bordered">BPJS Kesehatan</td>
        <td class="bordered rp-format">{{ $slipGaji->bpjs_kesehatan }}</td>
        <td>&nbsp;</td>
    </tr>

    <!-- DATA ROW 2 -->
    <tr>
        <td class="bordered">Lembur</td>
        <td class="bordered rp-format">{{ $slipGaji->lembur }}</td>
        <td>&nbsp;</td>
        <td class="bordered">BPJS Ketenagakerjaan</td>
        <td class="bordered rp-format">{{ $slipGaji->bpjs_ketenagakerjaan }}</td>
        <td>&nbsp;</td>
    </tr>

    <!-- DATA ROW 3 -->
    <tr>
        <td class="bordered">Tunjangan / Bonus</td>
        <td class="bordered rp-format">{{ $slipGaji->tunjangan_bonus }}</td>
        <td>&nbsp;</td>
        <td class="bordered" style="color: #9ca3af;">-</td>
        <td class="bordered rp-format" style="color: #9ca3af;">0</td>
        <td>&nbsp;</td>
    </tr>

    <!-- SUB TOTALS -->
    @php
        $totalPendapatan = $slipGaji->gaji_pokok + $slipGaji->lembur + $slipGaji->tunjangan_bonus;
        $totalPotongan = $slipGaji->bpjs_kesehatan + $slipGaji->bpjs_ketenagakerjaan;
    @endphp
    <tr class="total-row">
        <td class="bordered">Total Pendapatan (A)</td>
        <td class="bordered rp-format">{{ $totalPendapatan }}</td>
        <td>&nbsp;</td>
        <td class="bordered">Total Potongan (B)</td>
        <td class="bordered rp-format">{{ $totalPotongan }}</td>
        <td>&nbsp;</td>
    </tr>

    <!-- GAJI BERSIH -->
    <tr>
        <td colspan="4" class="grand-total text-left">GAJI BERSIH DITERIMA (A - B)</td>
        <td class="grand-total rp-format">{{ $slipGaji->total_gaji }}</td>
        <td>&nbsp;</td>
    </tr>

    <!-- TERBILANG -->
    <tr>
        <td colspan="6" class="terbilang">
            Terbilang : {{ \App\Helpers\TerbilangHelper::terbilang($slipGaji->total_gaji) }} Rupiah
        </td>
    </tr>

    <!-- CATATAN -->
    @if($slipGaji->catatan)
    <tr>
        <td colspan="6" class="bordered italic" style="font-size: 9pt; padding: 6px;">
            <b>Catatan:</b> {{ $slipGaji->catatan }}
        </td>
    </tr>
    @endif

    <!-- SPACER -->
    <tr height="15"><td colspan="6">&nbsp;</td></tr>

    <!-- SIGNATURES -->
    <tr>
        <td colspan="2" class="ttd-header">Banjarbaru, {{ date('d F Y') }}<br>DIREKTUR</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="2" class="ttd-header">PENERIMA / KARYAWAN</td>
    </tr>
    <tr height="40">
        <td colspan="2">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" class="ttd-name">HJ. NORMAULIDA, S.H.</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="2" class="ttd-name">{{ $slipGaji->nama_karyawan }}</td>
    </tr>
    <tr>
        <td colspan="2" class="ttd-footer">(Tanda Tangan &amp; Cap)</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="2" class="ttd-footer">(Tanda Tangan &amp; Cap)</td>
    </tr>

    <!-- SPACER -->
    <tr height="15"><td colspan="6">&nbsp;</td></tr>

    <!-- FOOTER BAR -->
    <tr>
        <td colspan="6" class="footer-bar">
            PT. UTAMA MADANI RAYA &nbsp;|&nbsp; Jl. Panglima Batur, Banjarbaru Utara, Kalsel &nbsp;|&nbsp; WA: 0851-6665-7171 &nbsp;|&nbsp; www.ptutamamadaniraya.com
        </td>
    </tr>
</table>

</body>
</html>
