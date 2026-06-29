<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan - {{ $invoice->nomor_invoice }}</title>
    <style>
        /* ============================================================
           EPSON LX-310 / DOT MATRIX - CONTINUOUS FORM 9.5 x 11 INCH
           Paperline 3-ply (Original + 2 Tembusan)
           Ukuran kertas: 9.5in x 11in
           Printable area: ~8.8in x 10.6in
           ============================================================ */

        @page {
            size: 9.5in 11in;
            margin-top: 0.35in;
            margin-bottom: 0.35in;
            margin-left: 0.45in;
            margin-right: 0.35in;
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
            width: 8.7in;
            max-width: 8.7in;
        }

        /* Tombol kontrol layar - tidak dicetak */
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

        /* ---- HEADER ---- */
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
        .kop-right {
            text-align: right;
            vertical-align: top;
            font-size: 8pt;
        }

        /* ---- JUDUL ---- */
        .judul-dok {
            text-align: center;
            margin: 6px 0 4px 0;
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
        .judul-dok p {
            font-size: 8pt;
            margin-top: 2px;
            letter-spacing: 1px;
        }

        /* ---- INFO BOX ---- */
        .info-box {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
            font-size: 9pt;
        }
        .info-box td {
            padding: 2px 4px;
            vertical-align: top;
        }
        .info-left { width: 60%; }
        .info-right { width: 40%; text-align: right; vertical-align: top; }
        .info-label { font-weight: bold; }
        .info-val-box {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 120px;
            font-weight: bold;
            font-size: 9.5pt;
        }

        /* ---- MAIN TABLE ---- */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5pt;
            margin-bottom: 6px;
        }
        .main-table th {
            border: 1px solid #000;
            padding: 3px 3px;
            text-align: center;
            font-weight: bold;
            background: #fff;
            text-transform: uppercase;
            font-size: 7.5pt;
            letter-spacing: 0.3px;
        }
        .main-table td {
            border: 1px solid #000;
            padding: 3px 3px;
            font-size: 8.5pt;
            vertical-align: middle;
        }
        .td-no      { width: 22px; text-align: center; }
        .td-sku     { width: 68px; text-align: center; font-family: 'Courier New', monospace; font-size: 7.5pt; }
        .td-nama    { min-width: 180px; text-align: left; }
        .td-sat     { width: 38px; text-align: center; }
        .td-qty     { width: 35px; text-align: center; font-weight: bold; }
        .td-ket     { width: 80px; text-align: center; }
        .td-paraf   { width: 70px; text-align: center; }
        .nama-barang { font-weight: bold; }

        /* Baris kosong extra space untuk produk sedikit */
        .empty-row td {
            height: 15px;
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            border-top: none;
            border-bottom: none;
        }
        .empty-row-last td {
            height: 15px;
            border: 1px solid #000;
            border-top: none;
        }

        /* ---- CATATAN ---- */
        .catatan-box {
            border: 1px dashed #000;
            padding: 4px 6px;
            font-size: 8pt;
            margin-bottom: 6px;
        }

        /* ---- TANDA TANGAN ---- */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 8.5pt;
        }
        .ttd-table td {
            width: 25%;
            text-align: center;
            vertical-align: top;
            padding: 2px 4px;
            border: 1px solid #000;
        }
        .ttd-label {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8pt;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
            margin-bottom: 2px;
        }
        .ttd-space {
            height: 52px;
            display: block;
        }
        .ttd-nama {
            border-top: 1px solid #000;
            padding-top: 2px;
            font-size: 8pt;
        }
        .ttd-sub {
            font-size: 7pt;
            color: #333;
        }

        /* ---- FOOTER ---- */
        .footer-bar {
            margin-top: 6px;
            border-top: 1.5px solid #000;
            padding-top: 3px;
            text-align: center;
            font-size: 7.5pt;
            letter-spacing: 0.3px;
            line-height: 1.5;
        }

        /* ---- PEMISAH 3-PLY ---- */
        .ply-divider {
            margin-top: 8px;
            border-top: 2px dashed #aaa;
            padding-top: 4px;
            text-align: center;
            font-size: 7pt;
            color: #555;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>

<!-- ============================================================ -->
<!--   TOMBOL LAYAR (tidak dicetak)                               -->
<!-- ============================================================ -->
<div class="no-print">
    <div>
        <strong>🖨️ Cetak Surat Jalan &amp; Tanda Terima Barang</strong>
        <span style="font-size:12px; opacity:0.8; margin-left:8px;">
            Epson LX-310 &bull; Continuous Form 9.5×11 inch &bull; Paperline
        </span>
    </div>
    <div style="display:flex;gap:8px;">
        <a href="javascript:window.history.back()" class="btn btn-back">← Kembali</a>
        <button onclick="window.print()" class="btn btn-print">🖨️ Cetak (Ctrl+P)</button>
    </div>
</div>

@include('invoices._lx310_sj_body', ['invoice' => $invoice, 'lembar' => 'LEMBAR ASLI'])

</body>
</html>

