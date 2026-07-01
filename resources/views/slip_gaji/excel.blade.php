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
    .company-title {
        font-size: 12pt;
        font-weight: bold;
        color: #1e3a8a;
    }
</style>
</head>
<body>

@php
    $isFarma = (isset($slipGaji->perusahaan) && $slipGaji->perusahaan === 'PT. NUR MADANI FARMA');
    $companyName = $slipGaji->perusahaan ?? 'PT. UTAMA MADANI RAYA';
@endphp

<table border="0" cellpadding="0" cellspacing="0">
    <colgroup>
        <col width="220" style="width: 220px;">
        <col width="150" style="width: 150px;">
    </colgroup>

    <!-- Company Header -->
    <tr height="24">
        <td colspan="2" class="bold text-left" style="font-size: 13pt; color: {{ $isFarma ? '#064e3b' : '#1e3a8a' }};">{{ $companyName }}</td>
    </tr>
    <tr height="18">
        <td colspan="2" class="text-left" style="font-size: 8pt; color: #4b5563;">
            @if($isFarma)
                Distributor & Mitra Pengadaan Alat Kesehatan & Farmasi | Telp: 0851-6665-7171
            @else
                Distributor & Mitra Pengadaan Barang | Telp: 0851-6665-7171
            @endif
        </td>
    </tr>
    <tr height="20">
        <td colspan="2" class="bold text-left" style="font-size: 11pt; border-bottom: 2px solid #000000; padding-bottom: 5px;">SLIP GAJI KARYAWAN</td>
    </tr>
    
    <!-- Spacing -->
    <tr height="10">
        <td></td><td></td>
    </tr>

    <!-- Info Detail -->
    <tr>
        <td class="bold">No. Slip: <span style="font-weight: normal;">{{ $slipGaji->nomor_slip }}</span></td>
        <td class="bold">Nama: <span style="font-weight: normal;">{{ $slipGaji->nama_karyawan }}</span></td>
    </tr>
    <tr>
        <td class="bold">Periode: <span style="font-weight: normal;">{{ $slipGaji->periode }}</span></td>
        <td class="bold">Jabatan: <span style="font-weight: normal;">{{ $slipGaji->jabatan ?? '-' }}</span></td>
    </tr>
    
    <!-- Spacing -->
    <tr height="15">
        <td></td><td></td>
    </tr>

    <!-- Row 7: Header Pendapatan -->
    <tr>
        <td class="bordered bold" style="background-color: #f3f4f6;">I. Pendapatan (Earnings)</td>
        <td class="bordered bold text-center" style="background-color: #f3f4f6;">Jumlah</td>
    </tr>

    <!-- Row 8: Gaji Pokok -->
    <tr>
        <td class="bordered">Gaji Pokok</td>
        <td class="bordered bold number-format">{{ $slipGaji->gaji_pokok }}</td>
    </tr>

    <!-- Row 9: Lembur -->
    <tr>
        <td class="bordered">Lembur</td>
        <td class="bordered bold number-format">{{ $slipGaji->lembur }}</td>
    </tr>

    <!-- Row 10: Tunjangan / Bonus -->
    <tr>
        <td class="bordered">Tunjangan / Bonus</td>
        <td class="bordered bold number-format">{{ $slipGaji->tunjangan_bonus }}</td>
    </tr>

    <!-- Row 11: Total Pendapatan (A) -->
    @php
        $totalPendapatan = $slipGaji->gaji_pokok + $slipGaji->lembur + $slipGaji->tunjangan_bonus;
    @endphp
    <tr>
        <td class="bordered bold" style="background-color: #f9fafb;">Total Pendapatan (A)</td>
        <td class="bordered bold number-format" style="background-color: #f9fafb;">{{ $totalPendapatan }}</td>
    </tr>

    <!-- Row 12: Header Potongan -->
    <tr>
        <td class="bordered bold" style="background-color: #f3f4f6;">II. Potongan (Deductions)</td>
        <td class="bordered bold text-center" style="background-color: #f3f4f6;">Jumlah</td>
    </tr>

    <!-- Row 13: BPJS Kesehatan -->
    <tr>
        <td class="bordered">BPJS Kesehatan</td>
        <td class="bordered bold number-format">{{ $slipGaji->bpjs_kesehatan }}</td>
    </tr>

    <!-- Row 14: BPJS Ketenagakerjaan -->
    <tr>
        <td class="bordered">BPJS Ketenagakerjaan</td>
        <td class="bordered bold number-format">{{ $slipGaji->bpjs_ketenagakerjaan }}</td>
    </tr>

    <!-- Row 15: Total Potongan (B) -->
    @php
        $totalPotongan = $slipGaji->bpjs_kesehatan + $slipGaji->bpjs_ketenagakerjaan;
    @endphp
    <tr>
        <td class="bordered bold" style="background-color: #f9fafb;">Total Potongan (B)</td>
        <td class="bordered bold number-format" style="background-color: #f9fafb;">{{ $totalPotongan }}</td>
    </tr>

    <!-- Spacing -->
    <tr height="10">
        <td></td><td></td>
    </tr>

    <!-- Gaji Bersih -->
    @php
        $totalGaji = $totalPendapatan - $totalPotongan;
    @endphp
    <tr>
        <td class="bordered bold text-white" style="background-color: {{ $isFarma ? '#064e3b' : '#111827' }};">Gaji Bersih Diterima (Net Salary)</td>
        <td class="bordered bold text-white number-format" style="background-color: {{ $isFarma ? '#064e3b' : '#111827' }};">{{ $totalGaji }}</td>
    </tr>
</table>

</body>
</html>
