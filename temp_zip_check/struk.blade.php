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
            width: 80mm; /* Standar 80mm printer thermal */
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
        .divider-solid { border-top: 1px solid #000; margin: 10px 0; }
        
        table { width: 100%; border-collapse: collapse; }
        td { vertical-align: top; font-size: 12px; padding: 2px 0; }
        
        .item-name { display: block; max-width: 100%; word-wrap: break-word; }
        
        /* Hilangkan elemen yang tidak perlu saat di-print */
        @media print {
            body { background-color: #fff; padding: 0; display: block; }
            .struk-container { box-shadow: none; width: 100%; margin: 0; padding: 0; }
            .no-print { display: none !important; }
            @page { margin: 0; }
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
    </style>
</head>
<body>
    <a href="{{ route('invoices.index') }}" class="back-btn no-print">Kembali</a>
    <button onclick="window.print()" class="print-btn no-print">Cetak Struk (Ctrl+P)</button>

    <div class="struk-container">
        <!-- Header -->
        <div class="text-center mb-3">
            <h2 class="font-bold text-lg mb-1" style="margin:0;">PT. UTAMA MADANI RAYA</h2>
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
                <td style="width: 35%;">No Faktur</td>
                <td style="width: 5%;">:</td>
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
        <table>
            @foreach($invoice->invoiceItems as $item)
            <tr>
                <td colspan="3">
                    <span class="item-name font-bold">{{ $item->product->nama_barang }}</span>
                    @if(isset($item->product->merk))
                        <span class="text-[10px] text-gray-500 ml-1">({{ $item->product->merk->nama_merk }})</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="width: 25%;">{{ $item->jumlah }} x</td>
                <td style="width: 40%;">{{ number_format($item->harga_jual_snapshot, 0, ',', '.') }}</td>
                <td style="width: 35%; text-align: right;">{{ number_format($item->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </table>
        
        <div class="divider-solid"></div>
        
        <!-- Total -->
        <table>
            <tr>
                <td class="font-bold" style="width: 60%; text-align: right; padding-right: 10px;">Sub Total :</td>
                <td style="width: 40%; text-align: right;">{{ number_format($invoice->sub_total, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="font-bold" style="text-align: right; padding-right: 10px;">PPN (11%) :</td>
                <td style="text-align: right;">{{ number_format($invoice->pajak_ppn, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="font-bold text-lg mt-2" style="text-align: right; padding-right: 10px; padding-top: 5px;">TOTAL :</td>
                <td class="font-bold text-lg mt-2" style="text-align: right; padding-top: 5px;">Rp {{ number_format($invoice->total_tagihan, 0, ',', '.') }}</td>
            </tr>
        </table>
        
        <div class="divider"></div>
        
        <!-- Footer -->
        <div class="text-center text-xs mt-3">
            <p class="mb-1 font-bold">TERIMA KASIH</p>
            <p>Barang yang sudah dibeli<br>tidak dapat dikembalikan</p>
        </div>
    </div>
</body>
</html>
