<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $invoice->nomor_invoice }}</title>
    <style>
        /* ============================================================
           EPSON LX-310 / DOT MATRIX - CONTINUOUS FORM
           Ukuran kertas: 24.5cm (lebar) x 28cm (panjang)
           Margin printable: kiri 1cm, kanan 0.5cm, atas 0.5cm, bawah 0.5cm
           ============================================================ */

        @page {
            size: 24.5cm 28cm;
            margin-top: 0.5cm;
            margin-bottom: 0.5cm;
            margin-left: 1cm;
            margin-right: 0.5cm;
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
            width: 23cm;
            max-width: 23cm;
        }

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
        .btn-back  { background: #6b7280; color: white; }
        @media print {
            .no-print { display: none !important; }
        }

        /* KOP */
        .kop {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 4px;
            margin-bottom: 4px;
        }
        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }
        .kop-nama {
            font-size: 14pt;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .kop-sub {
            font-size: 8.5pt;
            margin-top: 1px;
        }
        .kop-alamat {
            font-size: 7.5pt;
            margin-top: 1px;
            line-height: 1.4;
        }

        /* JUDUL */
        .judul-dok {
            text-align: center;
            margin: 5px 0 4px 0;
        }
        .judul-dok h2 {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 1.5px solid #000;
            display: inline-block;
            padding-bottom: 2px;
        }

        /* INFO HEADER */
        .info-box {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            font-size: 8.5pt;
        }
        .info-box td {
            padding: 1px 3px;
            vertical-align: top;
        }

        /* TABEL BARANG */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
            margin-bottom: 4px;
        }
        .main-table th {
            border: 1px solid #000;
            padding: 3px 2px;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 7.5pt;
            letter-spacing: 0.3px;
        }
        .main-table td {
            border: 1px solid #000;
            padding: 2.5px 3px;
            vertical-align: middle;
        }
        .td-no     { width: 20px; text-align: center; }
        .td-sku    { width: 58px; text-align: center; font-size: 7.5pt; }
        .td-nama   { min-width: 140px; text-align: left; }
        .td-merek  { width: 60px; text-align: center; font-size: 7.5pt; }
        .td-sat    { width: 32px; text-align: center; }
        .td-qty    { width: 28px; text-align: center; font-weight: bold; }
        .td-hsat   { width: 80px; text-align: right; }
        .td-tot    { width: 88px; text-align: right; font-weight: bold; }
        .rp-num    { font-variant-numeric: tabular-nums; white-space: nowrap; }
        .nama-barang { font-weight: bold; }

        .empty-row td {
            height: 14px;
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            border-top: none;
            border-bottom: none;
        }

        /* TOTAL BOX */
        .total-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5pt;
            margin-top: -1px;
        }
        .total-table td {
            border: 1px solid #000;
            padding: 2.5px 4px;
        }
        .total-label {
            text-align: right;
            font-weight: bold;
        }
        .total-val {
            text-align: right;
            width: 90px;
            white-space: nowrap;
            font-variant-numeric: tabular-nums;
        }
        .total-final {
            font-weight: bold;
            font-size: 9.5pt;
            background: #000;
            color: #fff;
        }
        .terbilang-row td {
            font-style: italic;
            font-size: 8pt;
            border: 1px solid #000;
            padding: 2px 4px;
        }

        /* INFO BAYAR & TTD */
        .bayar-ttd {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            font-size: 8.5pt;
        }
        .bayar-ttd td {
            vertical-align: top;
            padding: 2px 4px;
        }
        .bank-table {
            border-collapse: collapse;
            font-size: 8.5pt;
            width: 100%;
        }
        .bank-table td {
            padding: 1px 2px;
        }

        /* TANDA TANGAN */
        .ttd-box {
            text-align: center;
            border: 1px solid #000;
            padding: 3px;
        }
        .ttd-label {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8pt;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
        }
        .ttd-space { height: 50px; display: block; }
        .ttd-nama {
            border-top: 1px solid #000;
            padding-top: 2px;
            font-size: 8.5pt;
            font-weight: bold;
        }

        /* FOOTER */
        .footer-bar {
            margin-top: 5px;
            border-top: 1.5px solid #000;
            padding-top: 3px;
            text-align: center;
            font-size: 7.5pt;
            letter-spacing: 0.3px;
            line-height: 1.5;
        }

        .ply-divider {
            margin-top: 6px;
            border-top: 2px dashed #aaa;
            padding-top: 3px;
            text-align: center;
            font-size: 7pt;
            color: #555;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>

<!-- TOMBOL LAYAR -->
<div class="no-print">
    <div>
        <strong>🖨️ Cetak Invoice</strong>
        <span style="font-size:12px; opacity:0.8; margin-left:8px;">
            Epson LX-310 &bull; Continuous Form 9.5×11 inch &bull; 3-ply Paperline
        </span>
    </div>
    <div style="display:flex;gap:8px;">
        <a href="javascript:window.history.back()" class="btn btn-back">← Kembali</a>
        <button onclick="window.print()" class="btn btn-print">🖨️ Cetak (Ctrl+P)</button>
    </div>
</div>

@php $lembar = 'LEMBAR ASLI'; @endphp

<div style="page-break-inside: avoid;">

    <!-- KOP SURAT -->
    <div class="kop">
        <table class="kop-table">
            <tr>
                <td style="vertical-align: top; width: 68%;">
                    <div class="kop-nama">PT. UTAMA MADANI RAYA</div>
                    <div class="kop-sub">Distributor &amp; Mitra Pengadaan Barang</div>
                    <div class="kop-alamat">
                        Jl. Panglima Batur, Banjarbaru Utara, Kota Banjarbaru, Kalimantan Selatan<br>
                        WA: 0851-6665-7171 &nbsp;|&nbsp; Web: www.ptutamamadaniraya.com
                    </div>
                </td>
                <td style="text-align:right; vertical-align:top; font-size:8pt;">
                    <div style="font-size:6.5pt; border:1px solid #000; padding:2px 5px; display:inline-block; text-align:center;">
                        {{ strtoupper($lembar) }}
                    </div>
                    <div style="font-size:9.5pt; font-weight:bold; margin-top:3px;">No. INVOICE</div>
                    <div style="font-size:10pt; font-weight:bold; border:1px solid #000; padding:2px 5px; margin-top:1px; display:inline-block;">
                        {{ $invoice->nomor_invoice }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- JUDUL -->
    <div class="judul-dok">
        <h2>FAKTUR / INVOICE</h2>
    </div>

    <!-- INFO HEADER -->
    <table class="info-box">
        <tr>
            <td style="width:55%; vertical-align:top;">
                <table style="border-collapse:collapse; font-size:8.5pt;">
                    <tr>
                        <td style="width:85px; padding:1px 2px; font-weight:bold;">Kepada</td>
                        <td style="padding:1px 0;">:</td>
                        <td style="padding:1px 4px; font-weight:bold; text-transform:uppercase; font-size:9.5pt;">{{ $invoice->nama_klien }}</td>
                    </tr>
                    @if($invoice->customer)
                    <tr>
                        <td style="padding:1px 2px; font-weight:bold;">Telepon</td>
                        <td style="padding:1px 0;">:</td>
                        <td style="padding:1px 4px;">{{ $invoice->customer->telepon ?? '-' }}</td>
                    </tr>
                    @endif
                    @if($invoice->alamat_pengiriman)
                    <tr>
                        <td style="padding:1px 2px; font-weight:bold; vertical-align:top;">Alamat</td>
                        <td style="padding:1px 0; vertical-align:top;">:</td>
                        <td style="padding:1px 4px; font-size:7.5pt; line-height:1.3;">{{ $invoice->alamat_pengiriman }}</td>
                    </tr>
                    @endif
                </table>
            </td>
            <td style="width:45%; text-align:right; vertical-align:top;">
                <table style="border-collapse:collapse; font-size:8.5pt; margin-left:auto;">
                    <tr>
                        <td style="padding:1px 3px; font-weight:bold;">Tanggal</td>
                        <td style="padding:1px 0;">:</td>
                        <td style="padding:1px 4px;">{{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td style="padding:1px 3px; font-weight:bold;">Jatuh Tempo</td>
                        <td style="padding:1px 0;">:</td>
                        <td style="padding:1px 4px;">
                            @if($invoice->tanggal_jatuh_tempo)
                                {{ \Carbon\Carbon::parse($invoice->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}
                            @else
                                {{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->addDays(30)->translatedFormat('d F Y') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:1px 3px; font-weight:bold;">Status</td>
                        <td style="padding:1px 0;">:</td>
                        <td style="padding:1px 4px; font-weight:bold; text-transform:uppercase;">
                            {{ $invoice->status_pembayaran === 'lunas' ? 'LUNAS' : 'BELUM LUNAS' }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- TABEL BARANG -->
    <table class="main-table">
        <thead>
            <tr>
                <th class="td-no">No</th>
                <th class="td-sku">Kode Brg</th>
                <th class="td-nama">Nama Barang / Jasa</th>
                <th class="td-merek">Merek</th>
                <th class="td-sat">Sat</th>
                <th class="td-qty">Qty</th>
                <th class="td-hsat">Harga Satuan</th>
                <th class="td-tot">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->invoiceItems as $index => $item)
            <tr>
                <td class="td-no">{{ $index + 1 }}</td>
                <td class="td-sku">{{ $item->product->sku ?? '-' }}</td>
                <td class="td-nama"><span class="nama-barang">{{ $item->product->nama_barang ?? 'Barang Dihapus' }}</span></td>
                <td class="td-merek" style="font-size:7.5pt; text-transform:uppercase;">{{ $item->product->merk->nama_merk ?? '-' }}</td>
                <td class="td-sat" style="text-transform:uppercase;">{{ $item->product->satuan ?? 'PCS' }}</td>
                <td class="td-qty">{{ $item->jumlah }}</td>
                <td class="td-hsat rp-num">Rp {{ number_format($item->harga_jual_snapshot, 0, ',', '.') }}</td>
                <td class="td-tot rp-num">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach

            @php $filled = count($invoice->invoiceItems); $minRows = 6; @endphp
            @for($i = $filled; $i < $minRows; $i++)
            <tr class="empty-row">
                <td class="td-no">&nbsp;</td>
                <td class="td-sku">&nbsp;</td>
                <td class="td-nama">&nbsp;</td>
                <td class="td-merek">&nbsp;</td>
                <td class="td-sat">&nbsp;</td>
                <td class="td-qty">&nbsp;</td>
                <td class="td-hsat">&nbsp;</td>
                <td class="td-tot">&nbsp;</td>
            </tr>
            @endfor
        </tbody>
    </table>

    <!-- TOTAL -->
    <table class="total-table">
        <tr>
            <td colspan="5" class="total-label">Sub Total</td>
            <td class="total-val rp-num">Rp {{ number_format($invoice->sub_total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td colspan="5" class="total-label">PPN ({{ $invoice->pajak_ppn > 0 ? '11%' : '0%' }})</td>
            <td class="total-val rp-num">Rp {{ number_format($invoice->pajak_ppn, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td colspan="5" class="total-label">Ongkos Kirim</td>
            <td class="total-val rp-num">Rp {{ number_format($invoice->ongkir ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td colspan="5" class="total-label total-final" style="border:1px solid #000; background:#000; color:#fff; padding:3px 4px;">TOTAL TAGIHAN</td>
            <td class="total-val rp-num total-final" style="border:1px solid #000; background:#000; color:#fff; padding:3px 4px;">Rp {{ number_format($invoice->total_tagihan, 0, ',', '.') }}</td>
        </tr>
        <tr class="terbilang-row">
            <td colspan="6" style="font-style:italic; font-size:8pt;">
                <strong>Terbilang :</strong>
                {{ \App\Helpers\TerbilangHelper::terbilang($invoice->total_tagihan) }} Rupiah
            </td>
        </tr>
    </table>

    <!-- INFO BAYAR & TTD -->
    <table class="bayar-ttd">
        <tr>
            <td style="width:50%; vertical-align:top;">
                <div style="font-size:8pt; font-weight:bold; margin-bottom:2px; border-bottom:1px solid #000; padding-bottom:1px;">INFORMASI PEMBAYARAN</div>
                <table class="bank-table">
                    <tr>
                        <td style="width:45px; font-weight:bold;">Bank</td>
                        <td style="width:8px;">:</td>
                        <td style="font-weight:bold; font-size:9pt;">BSI</td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;">No. Rek</td>
                        <td>:</td>
                        <td style="font-weight:bold; font-size:10pt; letter-spacing:1px;">7343793687</td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;">A/N</td>
                        <td>:</td>
                        <td>PT Utama Madani Raya</td>
                    </tr>
                </table>
                <div style="margin-top:4px; font-size:7.5pt; font-style:italic;">
                    Pembayaran dapat dilakukan melalui transfer bank atau tunai.<br>
                    Harap konfirmasi pembayaran ke: WA 0851-6665-7171
                </div>
            </td>
            <td style="width:25%; vertical-align:top; padding-left:6px;">
                <div class="ttd-box">
                    <div class="ttd-label">Penerima / Klien</div>
                    <span class="ttd-space"></span>
                    <div class="ttd-nama">{{ $invoice->nama_klien }}</div>
                    <div style="font-size:7pt;">(Tanda Tangan &amp; Cap)</div>
                </div>
            </td>
            <td style="width:25%; vertical-align:top; padding-left:4px;">
                <div class="ttd-box">
                    <div class="ttd-label">Hormat Kami</div>
                    <span class="ttd-space"></span>
                    <div class="ttd-nama">HJ. NORMAULIDA, S.H.</div>
                    <div style="font-size:7pt;">(Tanda Tangan &amp; Cap)</div>
                </div>
            </td>
        </tr>
    </table>

    <!-- FOOTER -->
    <div class="footer-bar">
        PT. UTAMA MADANI RAYA &nbsp;|&nbsp; Jl. Panglima Batur, Banjarbaru Utara, Kalimantan Selatan &nbsp;|&nbsp; WA: 0851-6665-7171 &nbsp;|&nbsp; www.ptutamamadaniraya.com
    </div>

</div>

</body>
</html>
