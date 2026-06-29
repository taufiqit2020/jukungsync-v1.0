{{-- ============================================================
     PARTIAL: Body Surat Jalan LX-310 (1 lembar dari 3-ply)
     Digunakan oleh surat_jalan_lx310.blade.php
     Variable: $invoice, $lembar (string label lembar)
     ============================================================ --}}
<div style="page-break-inside: avoid;">

    <!-- KOP SURAT -->
    <div class="kop">
        <table class="kop-table">
            <tr>
                <td style="vertical-align: top; width: 70%;">
                    <div class="kop-nama">PT. UTAMA MADANI RAYA</div>
                    <div class="kop-sub">Distributor &amp; Mitra Pengadaan Barang</div>
                    <div class="kop-alamat">
                        Jl. Panglima Batur, Banjarbaru Utara, Kota Banjarbaru, Kalimantan Selatan<br>
                        WA: 0851-6665-7171 &nbsp;|&nbsp; Web: www.ptutamamadaniraya.com
                    </div>
                </td>
                <td class="kop-right">
                    <div style="font-size:7pt; border: 1px solid #000; padding: 3px 5px; display:inline-block; text-align:center;">
                        <div style="font-size:6pt; letter-spacing:1px;">{{ strtoupper($lembar) }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- JUDUL DOKUMEN -->
    <div class="judul-dok">
        <h2>SURAT JALAN / TANDA TERIMA BARANG</h2>
    </div>

    <!-- INFO HEADER -->
    <table class="info-box">
        <tr>
            <td class="info-left">
                <table style="border-collapse:collapse; font-size:8.5pt; width:100%;">
                    <tr>
                        <td style="width:90px; padding:1px 3px; font-weight:bold;">Kepada Yth.</td>
                        <td style="padding:1px 0;">:</td>
                        <td style="padding:1px 4px; font-weight:bold; text-transform:uppercase; font-size:9.5pt;">{{ $invoice->nama_klien }}</td>
                    </tr>
                    @if($invoice->alamat_pengiriman)
                    <tr>
                        <td style="padding:1px 3px; font-weight:bold; vertical-align:top;">Alamat Kirim</td>
                        <td style="padding:1px 0; vertical-align:top;">:</td>
                        <td style="padding:1px 4px; font-size:8pt; line-height:1.3;">{{ $invoice->alamat_pengiriman }}</td>
                    </tr>
                    @endif
                    @if($invoice->ekspedisi)
                    <tr>
                        <td style="padding:1px 3px; font-weight:bold;">Ekspedisi</td>
                        <td style="padding:1px 0;">:</td>
                        <td style="padding:1px 4px; text-transform:uppercase;">{{ $invoice->ekspedisi }}</td>
                    </tr>
                    @endif
                </table>
            </td>
            <td class="info-right">
                <table style="border-collapse:collapse; font-size:8.5pt; width:100%;">
                    <tr>
                        <td style="padding:1px 3px; text-align:right; font-weight:bold;">No. Surat Jalan</td>
                        <td style="padding:1px 0; text-align:right;">:</td>
                        <td style="padding:1px 4px; text-align:right; font-weight:bold; white-space:nowrap;">SJ/{{ $invoice->nomor_invoice }}</td>
                    </tr>
                    <tr>
                        <td style="padding:1px 3px; text-align:right; font-weight:bold;">No. Invoice</td>
                        <td style="padding:1px 0; text-align:right;">:</td>
                        <td style="padding:1px 4px; text-align:right; font-weight:bold;">{{ $invoice->nomor_invoice }}</td>
                    </tr>
                    <tr>
                        <td style="padding:1px 3px; text-align:right; font-weight:bold;">Tgl. Kirim</td>
                        <td style="padding:1px 0; text-align:right;">:</td>
                        <td style="padding:1px 4px; text-align:right;">{{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td style="padding:1px 3px; text-align:right; font-weight:bold;">Halaman</td>
                        <td style="padding:1px 0; text-align:right;">:</td>
                        <td style="padding:1px 4px; text-align:right;">1 / 1</td>
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
                <th class="td-sat">Satuan</th>
                <th class="td-qty">Jml</th>
                <th class="td-ket">Kondisi Barang</th>
                <th class="td-paraf">Paraf Cek</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->invoiceItems as $index => $item)
            <tr>
                <td class="td-no">{{ $index + 1 }}</td>
                <td class="td-sku">{{ $item->product->sku ?? '-' }}</td>
                <td class="td-nama">
                    <span class="nama-barang">{{ $item->product->nama_barang ?? 'Barang Dihapus' }}</span>
                    @if($item->product && $item->product->merk)
                        <span style="font-size:7.5pt; color:#333;"> ({{ $item->product->merk->nama_merk }})</span>
                    @endif
                </td>
                <td class="td-sat">{{ $item->product->satuan ?? 'PCS' }}</td>
                <td class="td-qty">{{ $item->jumlah }}</td>
                <td class="td-ket"></td>
                <td class="td-paraf"></td>
            </tr>
            @endforeach

            {{-- Tambah baris kosong agar total baris minimal 8 --}}
            @php $filled = count($invoice->invoiceItems); $minRows = 8; @endphp
            @for($i = $filled; $i < $minRows; $i++)
            <tr class="{{ $i === $minRows - 1 ? 'empty-row-last' : 'empty-row' }}">
                <td class="td-no">&nbsp;</td>
                <td class="td-sku">&nbsp;</td>
                <td class="td-nama">&nbsp;</td>
                <td class="td-sat">&nbsp;</td>
                <td class="td-qty">&nbsp;</td>
                <td class="td-ket">&nbsp;</td>
                <td class="td-paraf">&nbsp;</td>
            </tr>
            @endfor

            <!-- Baris total jumlah item -->
            <tr>
                <td colspan="4" style="text-align:right; font-weight:bold; padding: 3px 4px; border:1px solid #000; font-size:8.5pt;">
                    Total Item Barang :
                </td>
                <td class="td-qty" style="font-weight:bold; font-size:10pt; border:1px solid #000; text-align:center;">
                    {{ $invoice->invoiceItems->sum('jumlah') }}
                </td>
                <td colspan="2" style="border:1px solid #000; text-align:center; font-size:8pt; font-style:italic;">
                    Satuan Barang Keseluruhan
                </td>
            </tr>
        </tbody>
    </table>

    <!-- CATATAN PENGIRIMAN -->
    @if($invoice->catatan_pengiriman)
    <div class="catatan-box">
        <strong>Catatan :</strong> {{ $invoice->catatan_pengiriman }}
    </div>
    @endif

    <!-- KOLOM TANDA TANGAN (4 kolom) -->
    <table class="ttd-table">
        <tr>
            <td>
                <div class="ttd-label">Penerima / Klien</div>
                <span class="ttd-space"></span>
                <div class="ttd-nama">{{ $invoice->nama_klien }}</div>
                <div class="ttd-sub">(Tanda Tangan &amp; Cap)</div>
            </td>
            <td>
                <div class="ttd-label">Sopir / Ekspedisi</div>
                <span class="ttd-space"></span>
                <div class="ttd-nama">&nbsp;</div>
                <div class="ttd-sub">(Nama Jelas)</div>
            </td>
            <td>
                <div class="ttd-label">Warehouse / Gudang</div>
                <span class="ttd-space"></span>
                <div class="ttd-nama">&nbsp;</div>
                <div class="ttd-sub">(Nama Jelas)</div>
            </td>
            <td>
                <div class="ttd-label">Mengetahui (Owner)</div>
                <span class="ttd-space"></span>
                <div class="ttd-nama">HJ. NORMAULIDA, S.H.</div>
                <div class="ttd-sub">(Tanda Tangan &amp; Cap)</div>
            </td>
        </tr>
    </table>

    <!-- FOOTER -->
    <div class="footer-bar">
        PT. UTAMA MADANI RAYA &nbsp;|&nbsp; Jl. Panglima Batur, Banjarbaru Utara, Kalimantan Selatan &nbsp;|&nbsp; WA: 0851-6665-7171
    </div>

</div>
