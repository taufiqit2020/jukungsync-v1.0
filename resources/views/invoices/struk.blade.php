<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - {{ $invoice->nomor_invoice }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&display=swap');
        body {
            font-family: 'Courier Prime', monospace;
            background-color: #f3f4f6;
            color: #000;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
        }
        .struk-container {
            background-color: #fff;
            width: 80mm;
            padding: 15px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .mb-1 { margin-bottom: 5px; }
        .mb-2 { margin-bottom: 10px; }
        .mb-3 { margin-bottom: 15px; }
        .mt-2 { margin-top: 10px; }
        .mt-3 { margin-top: 15px; }
        .text-sm { font-size: 12px; }
        .text-xs { font-size: 10px; }
        .text-lg { font-size: 16px; }
        .divider { border-top: 1px dashed #000; margin: 10px 0; }
        .divider-solid { border-top: 2px solid #000; margin: 10px 0; }
        
        table { width: 100%; border-collapse: collapse; }
        td { vertical-align: top; font-size: 12px; padding: 2px 0; }
        
        .item-name { display: block; max-width: 100%; word-wrap: break-word; font-weight: bold; }
        .item-brand { display: block; font-size: 10px; font-style: italic; }
        
        /* Kolom Nominal Rapi */
        .col-num { 
            text-align: right; 
            font-variant-numeric: tabular-nums;
            white-space: nowrap; 
        }
        .col-qty { text-align: left; }
        .col-price { text-align: left; font-variant-numeric: tabular-nums; }

        /* Hilangkan elemen yang tidak perlu saat di-print */
        @media print {
            body { background-color: #fff; padding: 0; display: block; }
            .struk-container { box-shadow: none; width: 100%; margin: 0; padding: 5px; }
            .no-print { display: none !important; }
            @page { margin: 5mm 3mm; size: 80mm auto; }
        }
        
        /* Tombol print */
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .print-btn:hover { background-color: #1d4ed8; }
        
        .back-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: #4b5563;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .back-btn:hover { background-color: #374151; }

        .total-row td { font-size: 13px; font-weight: bold; padding-top: 4px; }
        .footer-msg { font-size: 11px; text-align: center; margin-top: 12px; }
    </style>
</head>
<body>
    <a href="{{ route('invoices.index') }}" class="back-btn no-print">Kembali</a>
    <button onclick="window.print()" class="print-btn no-print">Cetak Struk (Ctrl+P)</button>

    <div class="struk-container">
        <!-- Header -->
        <div class="text-center mb-3">
            <h2 class="font-bold text-lg mb-1" style="margin:0; letter-spacing:1px;">PT. UTAMA MADANI RAYA</h2>
            <div class="text-xs">
                Jl. Panglima Batur Banjarbaru Utara<br>
                Banjarbaru, Kalimantan Selatan<br>
                Telp: 0851-6665-7171
            </div>
        </div>
        
        <div class="divider"></div>
        
        <!-- Info Transaksi -->
        <table class="mb-2">
            <tr>
                <td style="width: 38%;">No Faktur</td>
                <td style="width: 4%;">:</td>
                <td class="font-bold">{{ $invoice->nomor_invoice }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td>Pelanggan</td>
                <td>:</td>
                <td class="font-bold">{{ strtoupper($invoice->nama_klien) }}</td>
            </tr>
        </table>
        
        <div class="divider-solid"></div>
        
        <!-- Rincian Item -->
        @foreach($invoice->invoiceItems as $item)
        <table style="margin-bottom: 6px;">
            <tr>
                <td colspan="3">
                    <span class="item-name">{{ $item->product->nama_barang }}</span>
                    @if(isset($item->product->merk))
                        <span class="item-brand">({{ $item->product->merk->nama_merk }})</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="col-qty" style="width: 22%;">{{ $item->jumlah }} x</td>
                <td class="col-price" style="width: 42%;">Rp {{ number_format($item->harga_jual_snapshot, 0, ',', '.') }}</td>
                <td class="col-num" style="width: 36%;">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
            </tr>
        </table>
        @endforeach
        
        <div class="divider-solid"></div>
        
        <!-- Total -->
        <table>
            <tr>
                <td style="width: 55%; text-align: right; padding-right: 6px;">Sub Total :</td>
                <td class="col-num" style="width: 45%;">{{ number_format($invoice->sub_total, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="text-align: right; padding-right: 6px;">PPN (11%) :</td>
                <td class="col-num">{{ number_format($invoice->pajak_ppn, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="text-align: right; padding-right: 6px;">Ongkir :</td>
                <td class="col-num">{{ number_format($invoice->ongkir ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td style="text-align: right; padding-right: 6px; padding-top: 6px; border-top: 1px dashed #000;">TOTAL :</td>
                <td class="col-num" style="border-top: 1px dashed #000; padding-top: 6px;">Rp {{ number_format($invoice->total_tagihan, 0, ',', '.') }}</td>
            </tr>
        </table>
        
        <div class="divider"></div>
        
        <!-- Footer -->
        <div class="footer-msg mt-3">
            <p class="mb-1 font-bold">*** TERIMA KASIH ***</p>
            <p class="mb-2">Barang yang sudah dibeli<br>tidak dapat dikembalikan</p>
            <div class="divider" style="margin: 5px 0;"></div>
            <div class="text-xs" style="line-height: 1.4; font-size: 9px; color: #000;">
                WA: 0851-6665-7171 | IG: @pt_umar<br>
                Web: www.ptutamamadaniraya.com
            </div>
        </div>
    </div>
</body>
</html>
