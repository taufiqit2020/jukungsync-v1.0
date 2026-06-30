<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $slipGaji->nomor_slip }}</title>
    <style>
        @page {
            size: A5 landscape;
            margin: 0.5cm;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 10pt;
            color: #000;
            background: #fff;
            padding: 10px;
            line-height: 1.3;
        }
        /* SCREEN LAYOUT CONTROLS */
        .no-print {
            background: #1e40af;
            color: white;
            padding: 12px 20px;
            margin-bottom: 16px;
            border-radius: 6px;
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: space-between;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-print { background: #16a34a; color: white; }
        .btn-excel { background: #10b981; color: white; }
        .btn-back  { background: #6b7280; color: white; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
        }

        /* KOP SURAT */
        .kop {
            width: 100%;
            border-bottom: 2px double #000;
            padding-bottom: 6px;
            margin-bottom: 8px;
        }
        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }
        .kop-nama {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .kop-sub {
            font-size: 9pt;
            font-weight: bold;
        }
        .kop-alamat {
            font-size: 8pt;
        }

        /* JUDUL DOKUMEN */
        .judul-dok {
            text-align: center;
            margin: 5px 0 8px 0;
        }
        .judul-dok h2 {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 1px solid #000;
            display: inline-block;
            padding-bottom: 1px;
        }

        /* INFO HEADER */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 9.5pt;
        }
        .info-table td {
            padding: 2px 4px;
            vertical-align: top;
        }

        /* DETAIL GAJI SIDE BY SIDE */
        .details-container {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 8px;
        }
        .details-box {
            width: 48%;
            border: 1px solid #000;
            padding: 6px;
        }
        .details-title {
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
            margin-bottom: 6px;
            font-size: 9pt;
        }
        .item-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        .item-table td {
            padding: 2.5px 2px;
        }
        .item-label {
            text-align: left;
        }
        .item-val {
            text-align: right;
            font-weight: bold;
        }
        .total-subbox {
            border-top: 1px dashed #000;
            margin-top: 5px;
            padding-top: 4px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            font-size: 9pt;
        }

        /* TOTAL GAJI BERSIH */
        .total-final-box {
            border: 1.5px solid #000;
            padding: 6px 10px;
            margin-top: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
            font-size: 11pt;
            text-transform: uppercase;
        }
        .terbilang-box {
            font-style: italic;
            font-size: 8.5pt;
            margin-top: 3px;
            padding: 2px 4px;
            border-bottom: 1px dashed #000;
        }

        /* SIGNATURE SECTION */
        .sig-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            font-size: 9pt;
        }
        .sig-table td {
            text-align: center;
            width: 33%;
            vertical-align: top;
        }
        .sig-space {
            height: 40px;
            display: block;
        }
        .sig-name {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- SCREEN BUTTONS -->
<div class="no-print">
    <div>
        <strong>Slip Gaji Karyawan</strong>
        <span style="font-size:12px; opacity:0.8; margin-left:8px;">
            Nomor: {{ $slipGaji->nomor_slip }} &bull; Periode: {{ $slipGaji->periode }}
        </span>
    </div>
    <div style="display:flex;gap:8px;">
        <a href="{{ route('slip-gaji.excel', $slipGaji->id) }}" class="btn btn-excel">📊 Download Excel</a>
        <a href="{{ route('slip-gaji.index') }}" class="btn btn-back">← Kembali</a>
        <button onclick="window.print()" class="btn btn-print">🖨️ Cetak (Ctrl+P)</button>
    </div>
</div>

<!-- PRINT CONTAINER -->
<div style="border: 1px solid #aaa; padding: 15px; border-radius: 4px; max-width: 21cm; margin: 0 auto; background: white;">

    <!-- KOP SURAT -->
    <div class="kop">
        <table class="kop-table">
            <tr>
                <td style="width: 70%;">
                    <div class="kop-nama">PT. UTAMA MADANI RAYA</div>
                    <div class="kop-sub">Distributor &amp; Mitra Pengadaan Barang</div>
                    <div class="kop-alamat">Jl. Panglima Batur, Banjarbaru Utara, Kota Banjarbaru, Kalsel</div>
                </td>
                <td style="width: 30%; text-align: right; font-size: 8pt; vertical-align: top;">
                    <div>Telp: 0851-6665-7171</div>
                    <div>www.ptutamamadaniraya.com</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- JUDUL DOKUMEN -->
    <div class="judul-dok">
        <h2>SLIP GAJI KARYAWAN</h2>
    </div>

    <!-- INFO HEADER -->
    <table class="info-table">
        <tr>
            <td style="width: 15%; font-weight: bold;">No. Slip</td>
            <td style="width: 35%;">: <b>{{ $slipGaji->nomor_slip }}</b></td>
            <td style="width: 15%; font-weight: bold;">Nama Karyawan</td>
            <td style="width: 35%;">: <b>{{ $slipGaji->nama_karyawan }}</b></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Periode</td>
            <td>: {{ $slipGaji->periode }}</td>
            <td style="font-weight: bold;">Jabatan</td>
            <td>: {{ $slipGaji->jabatan ?? '-' }}</td>
        </tr>
    </table>

    <!-- DETAILS SIDE-BY-SIDE -->
    <div class="details-container">
        <!-- Pendapatan -->
        <div class="details-box">
            <div class="details-title">I. Pendapatan (Earnings)</div>
            <table class="item-table">
                <tr>
                    <td class="item-label">Gaji Pokok</td>
                    <td class="item-val">Rp {{ number_format($slipGaji->gaji_pokok, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="item-label">Lembur</td>
                    <td class="item-val">Rp {{ number_format($slipGaji->lembur, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="item-label">Tunjangan / Bonus</td>
                    <td class="item-val">Rp {{ number_format($slipGaji->tunjangan_bonus, 0, ',', '.') }}</td>
                </tr>
            </table>
            @php
                $totalPendapatan = $slipGaji->gaji_pokok + $slipGaji->lembur + $slipGaji->tunjangan_bonus;
            @endphp
            <div class="total-subbox">
                <span>Total Pendapatan (A)</span>
                <span>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Potongan -->
        <div class="details-box">
            <div class="details-title">II. Potongan (Deductions)</div>
            <table class="item-table">
                <tr>
                    <td class="item-label">BPJS Kesehatan</td>
                    <td class="item-val">Rp {{ number_format($slipGaji->bpjs_kesehatan, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="item-label">BPJS Ketenagakerjaan</td>
                    <td class="item-val">Rp {{ number_format($slipGaji->bpjs_ketenagakerjaan, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="item-label">&nbsp;</td>
                    <td class="item-val">&nbsp;</td>
                </tr>
            </table>
            @php
                $totalPotongan = $slipGaji->bpjs_kesehatan + $slipGaji->bpjs_ketenagakerjaan;
            @endphp
            <div class="total-subbox">
                <span>Total Potongan (B)</span>
                <span>Rp {{ number_format($totalPotongan, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- GAJI BERSIH -->
    <div class="total-final-box">
        <span>Gaji Bersih Diterima (A - B)</span>
        <span>Rp {{ number_format($slipGaji->total_gaji, 0, ',', '.') }}</span>
    </div>

    <!-- TERBILANG -->
    <div class="terbilang-box">
        Terbilang: <b>{{ \App\Helpers\TerbilangHelper::terbilang($slipGaji->total_gaji) }} Rupiah</b>
    </div>

    @if($slipGaji->catatan)
    <div style="margin-top: 8px; font-size: 8.5pt; border: 1px dashed #777; padding: 4px 6px;">
        <b>Catatan:</b> {{ $slipGaji->catatan }}
    </div>
    @endif

    <!-- SIGNATURES -->
    <table class="sig-table">
        <tr>
            <td>
                <div>Penerima / Karyawan</div>
                <span class="sig-space"></span>
                <div class="sig-name">{{ $slipGaji->nama_karyawan }}</div>
            </td>
            <td>&nbsp;</td>
            <td>
                <div>Banjarbaru, {{ date('d F Y') }}<br>Hormat Kami,</div>
                <span class="sig-space"></span>
                <div class="sig-name">HJ. NORMAULIDA, S.H.</div>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
