<html xmlns:xx="urn:schemas-microsoft-com:office:excel"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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

@php
    $isFarma = ($perusahaan === 'PT. NUR MADANI FARMA');
    $companyName = $perusahaan ?? 'LAPORAN GAJI KARYAWAN';
@endphp

<table border="0" cellpadding="0" cellspacing="0">
    <!-- Company Header -->
    <tr height="24">
        <td colspan="9" class="bold text-left" style="font-size: 13pt; color: {{ $isFarma ? '#064e3b' : '#1e3a8a' }};">
            {{ $companyName }}
        </td>
    </tr>
    <tr height="18">
        <td colspan="9" class="text-left" style="font-size: 9pt; color: #4b5563;">
            @if($isFarma)
                Distributor & Mitra Pengadaan Alat Kesehatan & Farmasi | WA: 0851-6665-7070
            @else
                Distributor & Mitra Pengadaan Barang | WA: 0851-6665-7171
            @endif
        </td>
    </tr>
    <tr height="18">
        <td colspan="9" class="text-left" style="font-size: 9pt; color: #4b5563;">
            @if($isFarma)
                Alamat: Jl. Panglima Batur No. 16, Kel. Komet, Kec. Banjarbaru Utara, Kota Banjarbaru, Kalsel 70714
            @else
                Alamat: Jl. Panglima Batur, Banjarbaru Utara, Kalimantan Selatan
            @endif
        </td>
    </tr>
    <tr height="20">
        <td colspan="9" class="bold text-left" style="font-size: 11pt; border-bottom: 2px solid #000000; padding-bottom: 5px;">
            LAPORAN GAJI KARYAWAN
        </td>
    </tr>
    <tr height="18">
        <td colspan="9" class="text-left" style="font-size: 9pt; color: #374151;">
            Periode: {{ $periode ?? 'Semua Periode' }}
        </td>
    </tr>
    
    <!-- Spacing -->
    <tr height="10">
        <td colspan="9"></td>
    </tr>

    <!-- Table Header -->
    <tr>
        <td class="bordered bold text-center" style="background-color: #f3f4f6;">No</td>
        <td class="bordered bold text-center" style="background-color: #f3f4f6;">Nomor Slip</td>
        <td class="bordered bold" style="background-color: #f3f4f6;">Perusahaan</td>
        <td class="bordered bold" style="background-color: #f3f4f6;">Nama Karyawan</td>
        <td class="bordered bold" style="background-color: #f3f4f6;">Jabatan</td>
        <td class="bordered bold text-center" style="background-color: #f3f4f6;">Periode</td>
        <td class="bordered bold text-center" style="background-color: #f3f4f6;">Pendapatan (A)</td>
        <td class="bordered bold text-center" style="background-color: #f3f4f6;">Potongan (B)</td>
        <td class="bordered bold text-center" style="background-color: #f3f4f6;">Gaji Bersih</td>
    </tr>

    <!-- Table Body -->
    @php
        $totalGaji = 0;
        $totalPendapatan = 0;
        $totalPotongan = 0;
    @endphp

    @forelse($slipGajis as $idx => $slip)
    @php
        $gapok = $slip->gaji_pokok;
        $lembur = $slip->lembur;
        $tunjangan = $slip->tunjangan_bonus;
        $bpjsKes = $slip->bpjs_kesehatan;
        $bpjsKet = $slip->bpjs_ketenagakerjaan;
        
        $pendapatan = $gapok + $lembur + $tunjangan;
        $potongan = $bpjsKes + $bpjsKet;
        
        $totalPendapatan += $pendapatan;
        $totalPotongan += $potongan;
        $totalGaji += $slip->total_gaji;
    @endphp
    <tr>
        <td class="bordered text-center">{{ $idx + 1 }}</td>
        <td class="bordered text-center" style="font-family: monospace;">{{ $slip->nomor_slip }}</td>
        <td class="bordered">{{ $slip->perusahaan ?? 'PT. UTAMA MADANI RAYA' }}</td>
        <td class="bordered bold">{{ $slip->nama_karyawan }}</td>
        <td class="bordered">{{ $slip->jabatan ?? '-' }}</td>
        <td class="bordered text-center">{{ $slip->periode }}</td>
        <td class="bordered number-format">{{ $pendapatan }}</td>
        <td class="bordered number-format" style="color: #dc2626;">{{ $potongan }}</td>
        <td class="bordered bold number-format" style="color: #059669;">{{ $slip->total_gaji }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="9" class="bordered text-center" style="padding: 10px;">Belum ada data slip gaji pada periode ini.</td>
    </tr>
    @endforelse

    @if($slipGajis->count() > 0)
    <!-- Total Row -->
    <tr style="background-color: #f9fafb;">
        <td colspan="6" class="bordered bold text-right">TOTAL KESELURUHAN</td>
        <td class="bordered bold number-format">{{ $totalPendapatan }}</td>
        <td class="bordered bold number-format" style="color: #dc2626;">{{ $totalPotongan }}</td>
        <td class="bordered bold number-format" style="color: #059669;">{{ $totalGaji }}</td>
    </tr>
    @endif
</table>

</body>
</html>
