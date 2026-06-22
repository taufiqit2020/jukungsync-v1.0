<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan - {{ $online_order->nomor_invoice }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000;
            background: #fff;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* ====== Halaman pilih staf (sebelum print) ====== */
        #pick-panel {
            max-width: 700px;
            margin: 40px auto;
            padding: 32px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            font-family: 'Segoe UI', sans-serif;
        }
        #pick-panel h2 {
            font-size: 20px;
            font-weight: 800;
            color: #111;
            margin-bottom: 8px;
        }
        #pick-panel p.sub { color: #555; font-size: 13px; margin-bottom: 24px; }
        .pick-group { margin-bottom: 20px; }
        .pick-group label { display: block; font-size: 12px; font-weight: 700; color: #444; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
        .pick-group select {
            width: 100%;
            padding: 10px 14px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            font-size: 14px;
            background: #fff;
            color: #111;
            appearance: none;
            cursor: pointer;
        }
        .pick-group select:focus { outline: none; border-color: #7f1d1d; }
        .btn-print {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            background: #111827;
            color: #FBBF24;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-print:hover { background: #000; }
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 12px 20px;
            background: #e5e7eb;
            color: #374151;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            margin-right: 10px;
        }
        .btn-back:hover { background: #d1d5db; }
        .btn-row { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

        /* ====== Dokumen Surat Jalan (untuk print) ====== */
        #surat-jalan {
            display: none;
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 15mm 20mm;
            background: #fff;
            position: relative;
        }

        /* Watermark image */
        .watermark-bg {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.08;
            z-index: 0;
            width: 65%;
            max-width: 550px;
            pointer-events: none;
        }

        .sj-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 12px;
            border-bottom: 3px solid #000;
            margin-bottom: 16px;
        }
        .sj-logo { display: flex; align-items: center; gap: 12px; }
        .sj-logo img { height: 60px; object-fit: contain; }
        .sj-perusahaan { }
        .sj-perusahaan .nama { font-size: 16pt; font-weight: 900; color: #7f1d1d; }
        .sj-perusahaan .alamat { font-size: 9pt; color: #555; line-height: 1.5; margin-top: 2px; }
        .sj-title-block { text-align: right; }
        .sj-title-block .judul { font-size: 18pt; font-weight: 900; letter-spacing: 2px; text-transform: uppercase; }
        .sj-title-block .nomor { font-size: 9pt; color: #555; margin-top: 4px; }
        .sj-title-block .tanggal { font-size: 9pt; color: #555; }

        .sj-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            border: 1px solid #000;
            margin-bottom: 16px;
        }
        .sj-info-cell {
            padding: 8px 12px;
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
        }
        .sj-info-cell:nth-child(even) { border-right: none; }
        .sj-info-cell:nth-last-child(-n+2) { border-bottom: none; }
        .sj-info-cell .label { font-size: 8pt; font-weight: 700; text-transform: uppercase; color: #555; margin-bottom: 2px; }
        .sj-info-cell .value { font-size: 10pt; font-weight: 600; }
        .sj-info-cell.full { grid-column: span 2; border-right: none; }

        table.sj-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10pt;
        }
        table.sj-table thead tr {
            background: #111827;
            color: #fff;
        }
        table.sj-table th {
            padding: 8px 10px;
            text-align: left;
            font-weight: 700;
            font-size: 9pt;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        table.sj-table th:nth-child(2),
        table.sj-table th:nth-child(4),
        table.sj-table th:nth-child(5) { text-align: center; }
        table.sj-table th:nth-child(6),
        table.sj-table th:last-child { text-align: right; }
        table.sj-table td { padding: 7px 10px; border-bottom: 1px solid #ddd; }
        table.sj-table td:nth-child(2),
        table.sj-table td:nth-child(4),
        table.sj-table td:nth-child(5) { text-align: center; }
        table.sj-table td:nth-child(6),
        table.sj-table td:last-child { text-align: right; font-weight: 700; }
        table.sj-table tbody tr:nth-child(even) { background: #f9f9f9; }
        table.sj-table tfoot td {
            padding: 8px 10px;
            font-weight: 900;
            border-top: 2px solid #000;
            background: #f3f4f6;
        }
        table.sj-table tfoot td:last-child { text-align: right; color: #7f1d1d; font-size: 12pt; }

        .sj-catatan {
            padding: 10px 14px;
            border: 1px dashed #999;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 9pt;
            color: #555;
            background: #fafafa;
        }
        .sj-catatan strong { color: #111; }

        /* Tanda tangan */
        .sj-ttd {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            margin-top: 24px;
            padding-top: 12px;
            border-top: 2px solid #000;
        }
        .ttd-box { text-align: center; }
        .ttd-box .ttd-title { font-size: 9pt; font-weight: 700; text-transform: uppercase; margin-bottom: 4px; }
        .ttd-box .ttd-jabatan { font-size: 8pt; color: #555; margin-bottom: 60px; }
        .ttd-box .ttd-line { border-bottom: 1px solid #000; margin: 0 10px; }
        .ttd-box .ttd-nama { font-size: 9pt; font-weight: 900; margin-top: 6px; }
        .ttd-box .ttd-sub { font-size: 8pt; color: #666; margin-top: 2px; }

        .sj-footer {
            margin-top: 30px;
            padding: 16px;
            text-align: center;
            background-color: #111827 !important;
            color: white !important;
            border-radius: 8px;
            line-height: 1.6;
        }
        .sj-footer .alamat {
            font-size: 12pt;
            font-weight: 600;
            font-family: 'Segoe UI', sans-serif;
            margin-bottom: 6px;
        }
        .sj-footer .contact {
            color: #d1d5db !important;
            font-size: 10pt;
            font-family: 'Segoe UI', sans-serif;
        }

        /* ====== Print mode ====== */
        @media print {
            #pick-panel { display: none !important; }
            #surat-jalan { display: block !important; width: 100%; margin: 0; padding: 12mm 16mm; }
            body { 
                background: white; 
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            @page { size: A4; margin: 0; }
            .sj-footer {
                position: fixed !important;
                bottom: 12mm !important;
                left: 16mm !important;
                right: 16mm !important;
                width: calc(100% - 32mm) !important;
                margin-top: 0 !important;
            }
        }
    </style>
</head>
<body>

    {{-- ===== PANEL PILIH STAF (Layar, sebelum print) ===== --}}
    <div id="pick-panel">
        <h2>🖨️ Cetak Surat Jalan</h2>
        <p class="sub">Pesanan: <strong>{{ $online_order->nomor_invoice }}</strong> – {{ $online_order->nama_klien }}</p>

        <div class="pick-group">
            <label>Pengantar Barang (Staf yang berangkat ke lokasi)</label>
            <select id="selectPengantar">
                <option value="">-- Pilih Pengantar --</option>
                @foreach($stafList as $staf)
                <option value="{{ $staf['nama'] }}" data-jabatan="{{ $staf['jabatan'] }}"
                    {{ $selectedPengantar && $selectedPengantar['nama'] === $staf['nama'] ? 'selected' : '' }}>
                    {{ $staf['jabatan'] }} – {{ $staf['nama'] }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="pick-group">
            <label>Tanda Terima / Penerima (Penandatangan tanda terima)</label>
            <select id="selectPenerima">
                <option value="">-- Pilih Penerima / Tanda Tangan --</option>
                @foreach($stafList as $staf)
                <option value="{{ $staf['nama'] }}" data-jabatan="{{ $staf['jabatan'] }}"
                    {{ $selectedPenerima && $selectedPenerima['nama'] === $staf['nama'] ? 'selected' : '' }}>
                    {{ $staf['jabatan'] }} – {{ $staf['nama'] }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="btn-row">
            <a href="{{ route('online-orders.show', $online_order->id) }}" class="btn-back">
                ← Kembali
            </a>
            <button class="btn-print" onclick="applyAndPrint()">
                🖨️ Cetak Surat Jalan
            </button>
        </div>
    </div>

    {{-- ===== DOKUMEN SURAT JALAN ===== --}}
    <div id="surat-jalan">
        <img src="{{ asset('img/invoice-watermark.png') }}" alt="Watermark" class="watermark-bg">

        @php
            $parts = explode('/', $online_order->nomor_invoice);
            $inv_seq = isset($parts[0]) ? (int) $parts[0] : 1;
            // Jika invoice 17, kita ingin SJ 002. Jadi dikurangi 15.
            $sj_seq = max(1, $inv_seq - 15);
            $sj_number = sprintf("%03d/SJ-UMAR/%s/%s", $sj_seq, $parts[2] ?? 'VI', $parts[3] ?? date('Y'));
        @endphp

        {{-- Header --}}
        <div class="sj-header">
            <div class="sj-logo">
                <img src="{{ asset('img/invoice-watermark.png') }}" alt="Logo PT UMAR">
                <div class="sj-perusahaan">
                    <div class="nama">PT. UTAMA MADANI RAYA</div>
                    <div class="alamat">
                        Jl. Panglima Batur, Kel. Loktabat Utara, Kec. Banjarbaru Utara<br>
                        Kota Banjarbaru, Kalimantan Selatan<br>
                        Telp/WA: 0851-6665-7171 &bull; Email: ptutamamadaniraya@gmail.com
                    </div>
                </div>
            </div>
            <div class="sj-title-block">
                <div class="judul">Surat Jalan</div>
                <div class="nomor">No: {{ $sj_number }}</div>
                <div class="tanggal">Tanggal: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
            </div>
        </div>

        {{-- Info Pengiriman --}}
        <div class="sj-info">
            <div class="sj-info-cell">
                <div class="label">Kepada / Penerima</div>
                <div class="value">{{ \App\Models\User::find($online_order->klien_id)->name ?? $online_order->nama_klien }}</div>
            </div>
            <div class="sj-info-cell">
                <div class="label">Tanggal Pesanan</div>
                <div class="value">{{ \Carbon\Carbon::parse($online_order->tanggal_invoice)->translatedFormat('d F Y') }}</div>
            </div>
            <div class="sj-info-cell full">
                <div class="label">Alamat Tujuan Pengiriman</div>
                <div class="value">{{ $online_order->alamat_pengiriman ?: '-' }}</div>
            </div>
            <div class="sj-info-cell">
                <div class="label">Metode Pengiriman</div>
                <div class="value">{{ $online_order->ekspedisi ?: 'Armada PT UMAR' }}</div>
            </div>
            <div class="sj-info-cell">
                <div class="label">Metode Pembayaran</div>
                <div class="value">{{ str_contains(strtolower($online_order->metode_pembayaran), 'invoice') ? 'Invoice' : ucwords(str_replace('_', ' ', $online_order->metode_pembayaran)) }}</div>
            </div>
            @if($online_order->catatan_pengiriman)
            <div class="sj-info-cell full">
                <div class="label">Catatan Pengiriman</div>
                <div class="value" style="font-style:italic;">{{ $online_order->catatan_pengiriman }}</div>
            </div>
            @endif
        </div>

        {{-- Tabel Barang --}}
        <table class="sj-table">
            <thead>
                <tr>
                    <th style="width:5%">No.</th>
                    <th style="width:12%">SKU</th>
                    <th>Nama Barang</th>
                    <th style="width:10%">Satuan</th>
                    <th style="width:8%">Jumlah</th>
                    <th style="width:15%">Harga</th>
                    <th style="width:18%">Jumlah Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($online_order->invoiceItems as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->product->sku ?? '-' }}</td>
                    <td>{{ $item->product->nama_barang ?? '-' }}</td>
                    <td>{{ $item->product->satuan ?? 'pcs' }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp {{ number_format($item->harga_jual_snapshot, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align:right; font-size:9pt;">TOTAL ITEM & TOTAL HARGA:</td>
                    <td style="text-align:center; color:#7f1d1d; font-size:12pt;">
                        {{ $online_order->invoiceItems->sum('jumlah') }}
                    </td>
                    <td></td>
                    <td style="text-align:right; color:#7f1d1d; font-size:12pt;">
                        Rp {{ number_format($online_order->total_tagihan, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>

        {{-- Catatan --}}
        <div class="sj-catatan">
            <strong>Catatan:</strong>
            Mohon periksa barang sebelum penandatanganan. Surat jalan ini merupakan bukti sah pengiriman barang dari
            PT. Utama Madani Raya kepada penerima yang tercantum di atas. Barang yang telah diterima tidak dapat dikembalikan
            tanpa pemberitahuan sebelumnya.
        </div>

        {{-- Tanda Tangan --}}
        <div class="sj-ttd">
            {{-- Pengirim / Pengantar --}}
            <div class="ttd-box">
                <div class="ttd-title">Yang Mengantarkan</div>
                <div class="ttd-jabatan" id="sj-jabatan-pengantar">
                    @if($selectedPengantar){{ $selectedPengantar['jabatan'] }}@else&nbsp;@endif
                </div>
                <div class="ttd-line"></div>
                <div class="ttd-nama" id="sj-nama-pengantar">
                    @if($selectedPengantar){{ $selectedPengantar['nama'] }}@else&nbsp;@endif
                </div>
                <div class="ttd-sub">PT. Utama Madani Raya</div>
            </div>

            {{-- Penerima (Customer) --}}
            <div class="ttd-box">
                <div class="ttd-title">Yang Menerima</div>
                <div class="ttd-jabatan">&nbsp;</div>
                <div class="ttd-line"></div>
                <div class="ttd-nama">{{ \App\Models\User::find($online_order->klien_id)->name ?? $online_order->nama_klien }}</div>
                <div class="ttd-sub">Customer / Klien</div>
            </div>

            {{-- Tanda Terima / Staf --}}
            <div class="ttd-box">
                <div class="ttd-title">Tanda Terima</div>
                <div class="ttd-jabatan" id="sj-jabatan-penerima">
                    @if($selectedPenerima){{ $selectedPenerima['jabatan'] }}@else&nbsp;@endif
                </div>
                <div class="ttd-line"></div>
                <div class="ttd-nama" id="sj-nama-penerima">
                    @if($selectedPenerima){{ $selectedPenerima['nama'] }}@else&nbsp;@endif
                </div>
                <div class="ttd-sub">PT. Utama Madani Raya</div>
            </div>
        </div>

        <div class="sj-footer">
            <div class="alamat">Alamat Kantor : Jl. Panglima Batur Banjarbaru Utara, Banjarbaru Kalimantan Selatan</div>
            <div class="contact">
                WhatsApp: 0851-6665-7171 &nbsp;|&nbsp; Instagram: @pt_umar &nbsp;|&nbsp; Website: www.ptutamamadaniraya.com
            </div>
        </div>
    </div>

    <script>
    const stafData = @json($stafList);

    function getStafByNama(nama) {
        return stafData.find(s => s.nama === nama) || null;
    }

    function applyAndPrint() {
        const pengantar = document.getElementById('selectPengantar');
        const penerima  = document.getElementById('selectPenerima');

        if (!pengantar.value || !penerima.value) {
            alert('⚠️ Harap pilih nama Pengantar dan Tanda Terima terlebih dahulu sebelum mencetak.');
            return;
        }

        const stafPengantar = getStafByNama(pengantar.value);
        const stafPenerima  = getStafByNama(penerima.value);

        if (stafPengantar) {
            document.getElementById('sj-nama-pengantar').textContent    = stafPengantar.nama;
            document.getElementById('sj-jabatan-pengantar').textContent = stafPengantar.jabatan;
        }
        if (stafPenerima) {
            document.getElementById('sj-nama-penerima').textContent    = stafPenerima.nama;
            document.getElementById('sj-jabatan-penerima').textContent = stafPenerima.jabatan;
        }

        // Tunda sedikit agar DOM terupdate, lalu print
        setTimeout(() => window.print(), 200);
    }
    </script>
</body>
</html>
