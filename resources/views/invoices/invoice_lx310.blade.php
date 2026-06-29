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
           OPTIMIZED: Font besar, border tebal, padding lebar
           agar hasil cetak JELAS di dot matrix printer
           ============================================================ */

        @page {
            size: 24.5cm 28cm;
            margin-top: 0.3cm;
            margin-bottom: 0.3cm;
            margin-left: 0.8cm;
            margin-right: 0.5cm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11pt;
            color: #000;
            background: #fff;
            width: 23.2cm;
            max-width: 23.2cm;
            letter-spacing: 0.3px;
            line-height: 1.3;
        }

        /* TOMBOL LAYAR */
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
        .btn-mode  { background: #d97706; color: white; }
        @media print {
            .no-print { display: none !important; }
        }

        /* KOP SURAT */
        .kop {
            width: 100%;
            border-bottom: 3px solid #000;
            padding-bottom: 4px;
            margin-bottom: 4px;
        }
        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }
        .kop-nama {
            font-size: 15pt;
            font-weight: bold;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        .kop-sub {
            font-size: 10pt;
            margin-top: 1px;
            font-weight: bold;
        }
        .kop-alamat {
            font-size: 9pt;
            margin-top: 2px;
            line-height: 1.5;
        }

        /* JUDUL DOKUMEN */
        .judul-dok {
            text-align: center;
            margin: 5px 0 4px 0;
        }
        .judul-dok h2 {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
            border-bottom: 2px solid #000;
            display: inline-block;
            padding-bottom: 2px;
        }

        /* INFO HEADER */
        .info-box {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            font-size: 10pt;
        }
        .info-box td {
            padding: 2px 4px;
            vertical-align: top;
        }

        /* TABEL BARANG — OPTIMIZED UNTUK DOT MATRIX */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            margin-bottom: 4px;
        }
        .main-table th {
            border: 1.5px solid #000;
            padding: 4px 3px;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8.5pt;
            letter-spacing: 0.5px;
        }
        .main-table td {
            border: 1.5px solid #000;
            padding: 3.5px 4px;
            vertical-align: middle;
        }

        /* Kolom widths - mode Eksternal */
        .td-no     { width: 22px; text-align: center; }
        .td-sku    { width: 60px; text-align: center; font-size: 8.5pt; }
        .td-nama   { text-align: left; }
        .td-merek  { width: 65px; text-align: center; font-size: 8.5pt; }
        .td-sat    { width: 36px; text-align: center; }
        .td-qty    { width: 32px; text-align: center; font-weight: bold; }
        .td-hsat   { width: 90px; text-align: right; }
        .td-tot    { width: 95px; text-align: right; font-weight: bold; }
        .rp-num    { font-variant-numeric: tabular-nums; white-space: nowrap; }
        .nama-barang { font-weight: bold; }

        /* Kolom Internal (Modal & Keuntungan) */
        .td-modal  { width: 85px; text-align: right; font-size: 8.5pt; }
        .td-tmodal { width: 90px; text-align: right; font-size: 8.5pt; }
        .td-untung { width: 90px; text-align: right; font-weight: bold; font-size: 8.5pt; }
        .internal-header {
            border-bottom: 2px solid #000;
        }

        .empty-row td {
            height: 16px;
            border-left: 1.5px solid #000;
            border-right: 1.5px solid #000;
            border-top: none;
            border-bottom: none;
        }

        /* TOTAL BOX */
        .total-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
            margin-top: -1px;
        }
        .total-table td {
            border: 1.5px solid #000;
            padding: 3px 5px;
        }
        .total-label {
            text-align: right;
            font-weight: bold;
        }
        .total-val {
            text-align: right;
            width: 100px;
            white-space: nowrap;
            font-variant-numeric: tabular-nums;
        }
        /* TOTAL FINAL — tanpa background hitam, pakai border tebal + uppercase */
        .total-final {
            font-weight: bold;
            font-size: 11pt;
            border-top: 3px double #000 !important;
            border-bottom: 3px double #000 !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .terbilang-row td {
            font-style: italic;
            font-size: 9pt;
            border: 1.5px solid #000;
            padding: 3px 5px;
        }

        /* INFO BAYAR & TTD */
        .bayar-ttd {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            font-size: 9.5pt;
        }
        .bayar-ttd td {
            vertical-align: top;
            padding: 2px 4px;
        }
        .bank-table {
            border-collapse: collapse;
            font-size: 9.5pt;
            width: 100%;
        }
        .bank-table td {
            padding: 2px 3px;
        }

        /* TANDA TANGAN */
        .ttd-box {
            text-align: center;
            border: 1.5px solid #000;
            padding: 4px;
        }
        .ttd-label {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9pt;
            border-bottom: 1.5px solid #000;
            padding-bottom: 3px;
        }
        .ttd-space { height: 45px; display: block; }
        .ttd-nama {
            border-top: 1.5px solid #000;
            padding-top: 3px;
            font-size: 9.5pt;
            font-weight: bold;
        }

        /* FOOTER */
        .footer-bar {
            margin-top: 5px;
            border-top: 2px solid #000;
            padding-top: 3px;
            text-align: center;
            font-size: 8.5pt;
            letter-spacing: 0.3px;
            line-height: 1.5;
        }
    </style>
</head>
<body>

@php
    $isInternal = request()->has('mode') && request()->mode === 'internal';
@endphp

<!-- TOMBOL LAYAR -->
<div class="no-print">
    <div>
        <strong>🖨️ Cetak Invoice</strong>
        <span style="font-size:12px; opacity:0.8; margin-left:8px;">
            Epson LX-310 &bull; Continuous Form 9.5×11 inch &bull; 3-ply
            @if($isInternal)
                &bull; <span style="background:#d97706; padding:2px 8px; border-radius:3px; font-weight:bold;">MODE INTERNAL</span>
            @endif
        </span>
    </div>
    <div style="display:flex;gap:8px;">
        @if($isInternal)
            <a href="{{ route('invoices.invoice-lx310', $invoice->id) }}" class="btn btn-mode">📄 Mode Eksternal</a>
        @else
            <a href="{{ route('invoices.invoice-lx310', ['invoice' => $invoice->id, 'mode' => 'internal']) }}" class="btn btn-mode">🔒 Mode Internal</a>
        @endif
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
                <td style="vertical-align: top; width: 65%;">
                    <div class="kop-nama">PT. UTAMA MADANI RAYA</div>
                    <div class="kop-sub">Distributor &amp; Mitra Pengadaan Barang</div>
                    <div class="kop-alamat">
                        Jl. Panglima Batur, Banjarbaru Utara, Kota Banjarbaru, Kalimantan Selatan<br>
                        WA: 0851-6665-7171 &nbsp;|&nbsp; Web: www.ptutamamadaniraya.com
                    </div>
                </td>
                <td style="text-align:right; vertical-align:top; font-size:9pt;">
                    <div style="font-size:8pt; border:1.5px solid #000; padding:3px 6px; display:inline-block; text-align:center; font-weight:bold;">
                        {{ strtoupper($lembar) }}
                    </div>
                    <div style="font-size:10pt; font-weight:bold; margin-top:3px;">No. INVOICE</div>
                    <div style="font-size:11pt; font-weight:bold; border:1.5px solid #000; padding:3px 8px; margin-top:2px; display:inline-block; letter-spacing:0.5px;">
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
                <table style="border-collapse:collapse; font-size:10pt;">
                    <tr>
                        <td style="width:90px; padding:2px 3px; font-weight:bold;">Kepada</td>
                        <td style="padding:2px 0;">:</td>
                        <td style="padding:2px 5px; font-weight:bold; text-transform:uppercase; font-size:11pt;">{{ $invoice->nama_klien }}</td>
                    </tr>
                    @if($invoice->customer)
                    <tr>
                        <td style="padding:2px 3px; font-weight:bold;">Telepon</td>
                        <td style="padding:2px 0;">:</td>
                        <td style="padding:2px 5px;">{{ $invoice->customer->telepon ?? '-' }}</td>
                    </tr>
                    @endif
                    @if($invoice->alamat_pengiriman)
                    <tr>
                        <td style="padding:2px 3px; font-weight:bold; vertical-align:top;">Alamat</td>
                        <td style="padding:2px 0; vertical-align:top;">:</td>
                        <td style="padding:2px 5px; font-size:9pt; line-height:1.4;">{{ $invoice->alamat_pengiriman }}</td>
                    </tr>
                    @endif
                </table>
            </td>
            <td style="width:45%; text-align:right; vertical-align:top;">
                <table style="border-collapse:collapse; font-size:10pt; margin-left:auto;">
                    <tr>
                        <td style="padding:2px 4px; font-weight:bold;">Tanggal</td>
                        <td style="padding:2px 0;">:</td>
                        <td style="padding:2px 5px;">{{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td style="padding:2px 4px; font-weight:bold;">Jatuh Tempo</td>
                        <td style="padding:2px 0;">:</td>
                        <td style="padding:2px 5px;">
                            @if($invoice->tanggal_jatuh_tempo)
                                {{ \Carbon\Carbon::parse($invoice->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}
                            @else
                                {{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->addDays(30)->translatedFormat('d F Y') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:2px 4px; font-weight:bold;">Status</td>
                        <td style="padding:2px 0;">:</td>
                        <td style="padding:2px 5px; font-weight:bold; text-transform:uppercase; letter-spacing:1px;">
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
                @if($isInternal)
                <th class="td-modal internal-header">Modal/Sat</th>
                <th class="td-tmodal internal-header">Total Modal</th>
                <th class="td-untung internal-header">Keuntungan</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php $total_modal = 0; @endphp
            @foreach($invoice->invoiceItems as $index => $item)
            @php
                $modal_item = $item->harga_modal_snapshot * $item->jumlah;
                $total_modal += $modal_item;
                $keuntungan_item = $item->total_harga - $modal_item;
            @endphp
            <tr>
                <td class="td-no">{{ $index + 1 }}</td>
                <td class="td-sku">{{ $item->product->sku ?? '-' }}</td>
                <td class="td-nama"><span class="nama-barang">{{ $item->product->nama_barang ?? 'Barang Dihapus' }}</span></td>
                <td class="td-merek" style="text-transform:uppercase;">{{ $item->product->merk->nama_merk ?? '-' }}</td>
                <td class="td-sat" style="text-transform:uppercase;">{{ $item->product->satuan ?? 'PCS' }}</td>
                <td class="td-qty">{{ $item->jumlah }}</td>
                <td class="td-hsat rp-num">Rp {{ number_format($item->harga_jual_snapshot, 0, ',', '.') }}</td>
                <td class="td-tot rp-num">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                @if($isInternal)
                <td class="td-modal rp-num">Rp {{ number_format($item->harga_modal_snapshot, 0, ',', '.') }}</td>
                <td class="td-tmodal rp-num">Rp {{ number_format($modal_item, 0, ',', '.') }}</td>
                <td class="td-untung rp-num">Rp {{ number_format($keuntungan_item, 0, ',', '.') }}</td>
                @endif
            </tr>
            @endforeach

            @php $filled = count($invoice->invoiceItems); $minRows = 4; @endphp
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
                @if($isInternal)
                <td class="td-modal">&nbsp;</td>
                <td class="td-tmodal">&nbsp;</td>
                <td class="td-untung">&nbsp;</td>
                @endif
            </tr>
            @endfor
        </tbody>
    </table>

    <!-- TOTAL -->
    @php $totalCols = $isInternal ? 8 : 5; @endphp
    <table class="total-table">
        <tr>
            <td colspan="{{ $totalCols }}" class="total-label">Sub Total</td>
            <td class="total-val rp-num">Rp {{ number_format($invoice->sub_total, 0, ',', '.') }}</td>
            @if($isInternal)
            <td colspan="2" class="total-val rp-num" rowspan="3" style="vertical-align:middle; text-align:right; font-weight:bold;">
                Rp {{ number_format($total_modal, 0, ',', '.') }}
            </td>
            <td class="total-val rp-num" rowspan="3" style="vertical-align:middle; text-align:right; font-weight:bold; font-size:10pt;">
                Rp {{ number_format($invoice->sub_total - $total_modal, 0, ',', '.') }}
            </td>
            @endif
        </tr>
        <tr>
            <td colspan="{{ $totalCols }}" class="total-label">PPN ({{ $invoice->pajak_ppn > 0 ? '11%' : '0%' }})</td>
            <td class="total-val rp-num">Rp {{ number_format($invoice->pajak_ppn, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td colspan="{{ $totalCols }}" class="total-label">Ongkos Kirim</td>
            <td class="total-val rp-num">Rp {{ number_format($invoice->ongkir ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td colspan="{{ $totalCols }}" class="total-label total-final" style="border:1.5px solid #000; padding:4px 5px;">*** TOTAL TAGIHAN ***</td>
            <td class="total-val rp-num total-final" style="border:1.5px solid #000; padding:4px 5px;">Rp {{ number_format($invoice->total_tagihan, 0, ',', '.') }}</td>
            @if($isInternal)
            <td colspan="3" style="border:1.5px solid #000;">&nbsp;</td>
            @endif
        </tr>
        <tr class="terbilang-row">
            <td colspan="{{ $isInternal ? $totalCols + 4 : $totalCols + 1 }}" style="font-style:italic; font-size:9pt;">
                <strong>Terbilang :</strong>
                {{ \App\Helpers\TerbilangHelper::terbilang($invoice->total_tagihan) }} Rupiah
            </td>
        </tr>
    </table>

    <!-- INFO BAYAR & TTD -->
    <table class="bayar-ttd">
        <tr>
            <td style="width:50%; vertical-align:top;">
                <div style="font-size:9pt; font-weight:bold; margin-bottom:3px; border-bottom:1.5px solid #000; padding-bottom:2px;">INFORMASI PEMBAYARAN</div>
                <table class="bank-table">
                    <tr>
                        <td style="width:50px; font-weight:bold;">Bank</td>
                        <td style="width:10px;">:</td>
                        <td style="font-weight:bold; font-size:10pt;">BSI</td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;">No. Rek</td>
                        <td>:</td>
                        <td style="font-weight:bold; font-size:11pt; letter-spacing:1.5px;">7343793687</td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;">A/N</td>
                        <td>:</td>
                        <td>PT Utama Madani Raya</td>
                    </tr>
                </table>
                <div style="margin-top:4px; font-size:8.5pt; font-style:italic;">
                    Pembayaran dapat dilakukan melalui transfer bank atau tunai.<br>
                    Harap konfirmasi pembayaran ke: WA 0851-6665-7171
                </div>
            </td>
            <td style="width:25%; vertical-align:top; padding-left:6px;">
                <div class="ttd-box">
                    <div class="ttd-label">Penerima / Klien</div>
                    <span class="ttd-space"></span>
                    <div class="ttd-nama">{{ $invoice->nama_klien }}</div>
                    <div style="font-size:8pt;">(Tanda Tangan &amp; Cap)</div>
                </div>
            </td>
            <td style="width:25%; vertical-align:top; padding-left:4px;">
                <div class="ttd-box">
                    <div class="ttd-label">Hormat Kami</div>
                    <span class="ttd-space"></span>
                    <div class="ttd-nama">HJ. NORMAULIDA, S.H.</div>
                    <div style="font-size:8pt;">(Tanda Tangan &amp; Cap)</div>
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
