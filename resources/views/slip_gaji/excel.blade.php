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
    .bordered {
        border: 1px solid #000000;
    }
    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .text-left { text-align: left; }
    .bold { font-weight: bold; }
    .number-format {
        mso-number-format: '\#\,\#\#0';
        text-align: right;
    }
</style>
</head>
<body>

<table border="0" cellpadding="0" cellspacing="0">
    <colgroup>
        <col width="30" style="width: 30px;">
        <col width="30" style="width: 30px;">
        <col width="30" style="width: 30px;">
        <col width="30" style="width: 30px;">
        <col width="30" style="width: 30px;">
        <col width="220" style="width: 220px;">
        <col width="150" style="width: 150px;">
    </colgroup>

    <!-- Row 1-6 are empty -->
    <tr height="20">
        <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    </tr>
    <tr height="20">
        <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    </tr>
    <tr height="20">
        <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    </tr>
    <tr height="20">
        <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    </tr>
    <tr height="20">
        <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    </tr>
    <tr height="20">
        <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    </tr>

    <!-- Row 7: Header Pendapatan -->
    <tr>
        <td></td><td></td><td></td><td></td><td></td>
        <td class="bordered bold">I. Pendapatan (Earnings)</td>
        <td class="bordered bold text-center">Jumlah (Rp)</td>
    </tr>

    <!-- Row 8: Gaji Pokok -->
    <tr>
        <td></td><td></td><td></td><td></td><td></td>
        <td class="bordered">Gaji Pokok</td>
        <td class="bordered bold number-format">{{ $slipGaji->gaji_pokok }}</td>
    </tr>

    <!-- Row 9: Lembur -->
    <tr>
        <td></td><td></td><td></td><td></td><td></td>
        <td class="bordered">Lembur</td>
        <td class="bordered bold number-format">{{ $slipGaji->lembur }}</td>
    </tr>

    <!-- Row 10: Tunjangan / Bonus -->
    <tr>
        <td></td><td></td><td></td><td></td><td></td>
        <td class="bordered">Tunjangan / Bonus</td>
        <td class="bordered bold number-format">{{ $slipGaji->tunjangan_bonus }}</td>
    </tr>

    <!-- Row 11: Total Pendapatan (A) -->
    @php
        $totalPendapatan = $slipGaji->gaji_pokok + $slipGaji->lembur + $slipGaji->tunjangan_bonus;
    @endphp
    <tr>
        <td></td><td></td><td></td><td></td><td></td>
        <td class="bordered bold">Total Pendapatan (A)</td>
        <td class="bordered bold number-format">{{ $totalPendapatan }}</td>
    </tr>

    <!-- Row 12: Header Potongan -->
    <tr>
        <td></td><td></td><td></td><td></td><td></td>
        <td class="bordered bold">II. Potongan (Deductions)</td>
        <td class="bordered bold text-center">Jumlah (Rp)</td>
    </tr>

    <!-- Row 13: BPJS Kesehatan -->
    <tr>
        <td></td><td></td><td></td><td></td><td></td>
        <td class="bordered">BPJS Kesehatan</td>
        <td class="bordered bold number-format">{{ $slipGaji->bpjs_kesehatan }}</td>
    </tr>

    <!-- Row 14: BPJS Ketenagakerjaan -->
    <tr>
        <td></td><td></td><td></td><td></td><td></td>
        <td class="bordered">BPJS Ketenagakerjaan</td>
        <td class="bordered bold number-format">{{ $slipGaji->bpjs_ketenagakerjaan }}</td>
    </tr>

    <!-- Row 15: - -->
    <tr>
        <td></td><td></td><td></td><td></td><td></td>
        <td class="bordered">-</td>
        <td class="bordered bold number-format">0</td>
    </tr>

    <!-- Row 16: Total Potongan (B) -->
    @php
        $totalPotongan = $slipGaji->bpjs_kesehatan + $slipGaji->bpjs_ketenagakerjaan;
    @endphp
    <tr>
        <td></td><td></td><td></td><td></td><td></td>
        <td class="bordered bold">Total Potongan (B)</td>
        <td class="bordered bold number-format">{{ $totalPotongan }}</td>
    </tr>
</table>

</body>
</html>
