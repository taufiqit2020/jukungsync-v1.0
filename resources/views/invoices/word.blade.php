<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"
xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=ProgId content=Word.Document>
<meta name=Generator content="Microsoft Word 15">
<meta name=Originator content="Microsoft Word 15">
<style>
@page WordSection1 {
    size: 595.3pt 841.9pt;
    margin: 28.3pt 28.3pt 56.7pt 28.3pt;
    mso-header-margin: 35.4pt;
    mso-footer-margin: 35.4pt;
    mso-paper-source: 0;
}
div.WordSection1 { page: WordSection1; }
table { border-collapse: collapse; width: 100%; font-family: 'Arial', sans-serif; font-size: 11px; }
td, th { padding: 4px; }
.my-table th { background-color: #1f2937; color: white; font-size: 10px; text-transform: uppercase; border: 1px solid #374151; }
.my-table td { border: 1px solid #374151; font-size: 11px; }
.header-bg { background-color: #111827; color: white; }
</style>
</head>
<body style="font-family: 'Arial', sans-serif; font-size: 11px; color: black;">
<div class="WordSection1">

    <!-- Header Image -->
    @php
        $path = public_path('img/invoice-header.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_exists($path) ? file_get_contents($path) : '';
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    @endphp
    <p style="margin-bottom: 20px;"><img src="{{ $base64 }}" width="100%" alt="Kop Surat PT UMAR"></p>

    <!-- Info Section -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 20px; font-family: 'Arial', sans-serif;">
        <tr>
            <td width="50%" valign="top">
                <p style="margin:0; font-weight: bold; border-bottom: 1px solid black; display: inline-block; padding-bottom: 2px;">KEPADA :</p>
                <h3 style="margin: 5px 0 0 0; font-weight: bold; font-size: 16px; text-transform: uppercase;">{{ $invoice->nama_klien }}</h3>
            </td>
            <td width="50%" valign="top" align="right">
                <h3 style="margin: 0 0 10px 0; font-weight: bold; font-size: 16px;">No. Invoice : {{ $invoice->nomor_invoice }}</h3>
                <table border="0" cellpadding="2" cellspacing="0" width="100%" style="text-align: right; font-size: 11px;">
                    <tr>
                        <td align="right" style="padding-right: 10px;">Tanggal:</td>
                        <td align="right" style="font-weight: bold;">{{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td align="right" style="padding-right: 10px;">Jatuh Tempo:</td>
                        <td align="right" style="font-weight: bold;">
                            @if($invoice->tanggal_jatuh_tempo)
                                {{ \Carbon\Carbon::parse($invoice->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}
                            @else
                                {{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->addDays(30)->translatedFormat('d F Y') }}
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Main Table -->
    <table class="my-table" border="1" cellpadding="4" cellspacing="0" width="100%" style="border: 1px solid #374151; margin-bottom: 20px;">
        <thead>
            <tr style="background-color: #1f2937; color: white;">
                <th width="4%" style="background-color: #1f2937; color: white;">No</th>
                <th width="10%" style="background-color: #1f2937; color: white;">Kode Barang</th>
                <th width="30%" style="background-color: #1f2937; color: white;">Nama Barang / Jasa</th>
                <th width="10%" style="background-color: #1f2937; color: white;">Merek</th>
                <th width="6%" style="background-color: #1f2937; color: white;">Sat.</th>
                <th width="10%" style="background-color: #1f2937; color: white;">Kategori</th>
                <th width="5%" style="background-color: #1f2937; color: white;">Jml</th>
                <th width="12%" style="background-color: #1f2937; color: white;">Harga Satuan</th>
                <th width="13%" style="background-color: #1f2937; color: white;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->invoiceItems as $index => $item)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td align="center" style="font-size: 9px; font-family: 'Courier New', Courier, monospace;">{{ $item->product->sku ?? '-' }}</td>
                <td><b>{{ $item->product->nama_barang ?? 'Barang Dihapus' }}</b></td>
                <td align="center" style="font-size: 9px; text-transform: uppercase;">{{ $item->product->merk->nama_merk ?? '-' }}</td>
                <td align="center" style="text-transform: uppercase;">PCS</td>
                <td align="center" style="font-size: 9px;">{{ $item->product->category->nama_kategori ?? '-' }}</td>
                <td align="center"><b>{{ $item->jumlah }}</b></td>
                <td align="right">Rp {{ number_format($item->harga_jual_snapshot, 0, ',', '.') }}</td>
                <td align="right"><b>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</b></td>
            </tr>
            @endforeach
            <!-- TOTALS -->
            <tr style="font-weight: bold; border-top: 2px solid #1f2937;">
                <td colspan="8" align="right" style="border-right: 1px solid #374151;">Sub Total</td>
                <td align="right">Rp {{ number_format($invoice->sub_total, 0, ',', '.') }}</td>
            </tr>
            <tr style="font-weight: bold;">
                <td colspan="8" align="right" style="border-right: 1px solid #374151;">Pajak (PPN)</td>
                <td align="right">Rp {{ number_format($invoice->pajak_ppn, 0, ',', '.') }}</td>
            </tr>
            <tr style="font-weight: bold;">
                <td colspan="8" align="right" style="border-right: 1px solid #374151;">Ongkos Kirim (Ongkir)</td>
                <td align="right">Rp {{ number_format($invoice->ongkir ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr style="font-weight: bold; background-color: #1f2937; color: white;">
                <td colspan="8" align="right" style="background-color: #1f2937; color: white;">Total Tagihan</td>
                <td align="right" style="background-color: #1f2937; color: white;">Rp {{ number_format($invoice->total_tagihan, 0, ',', '.') }}</td>
            </tr>
            <tr style="font-style: italic; font-weight: bold;">
                <td colspan="9">
                    <span>Terbilang :</span> 
                    {{ \App\Helpers\TerbilangHelper::terbilang($invoice->total_tagihan) }} Rupiah
                </td>
            </tr>
        </tbody>
    </table>

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td width="60%" valign="top">
                <p style="margin-bottom: 5px;">Pembayaran dapat dilakukan Cash atau Transfer melalui rekening :</p>
                <table border="0" cellpadding="2" cellspacing="0" width="100%">
                    <tr>
                        <td width="20%">Bank</td>
                        <td style="font-weight: bold;">: BSI</td>
                    </tr>
                    <tr>
                        <td>No. Rek</td>
                        <td style="font-weight: bold; font-size: 14px;">: 7343793687</td>
                    </tr>
                    <tr>
                        <td>A/N</td>
                        <td style="font-weight: bold;">: PT Utama Madani Raya</td>
                    </tr>
                </table>
            </td>
            <td width="40%" align="center" valign="top">
                <p style="font-weight: bold; text-transform: uppercase; margin-bottom: 60px;">OWNER</p>
                <p style="font-weight: bold; text-transform: uppercase; border-bottom: 1px solid black; display: inline-block;">HJ. NORMAULIDA, S.H.</p>
            </td>
        </tr>
    </table>

    <div style="background-color: #111827; color: white; text-align: center; padding: 10px; border-radius: 4px; margin-top: 30px; font-weight: bold; font-size: 11px;">
        <p style="margin: 0;">Alamat Kantor : Jl. Panglima Batur Banjarbaru Utara, Banjarbaru Kalimantan Selatan</p>
        <p style="margin: 5px 0 0 0; color: #d1d5db; font-size: 10px;">
            WhatsApp: 0851-6665-7171 &nbsp;|&nbsp; Instagram: @pt_umar &nbsp;|&nbsp; Website: www.ptutamamadaniraya.com
        </p>
    </div>

</div>
</body>
</html>
