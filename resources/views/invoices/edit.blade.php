@extends('layouts.admin')
@section('title', 'Edit Invoice - Superadmin')
@section('content')

<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow rounded-2xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="bg-white bg-opacity-20 rounded-lg p-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Edit Invoice</h3>
                    <p class="text-yellow-100 text-xs">Akses khusus Superadmin</p>
                </div>
            </div>
            <a href="{{ route('invoices.index') }}" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-1.5 transition-all">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </a>
        </div>

        <!-- Body -->
        <div class="px-8 py-6">
            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded-md mb-5">
                    <ul class="text-sm text-red-700 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('invoices.update', $invoice->id) }}?from={{ request()->get('from') }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Info Faktur -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">No. Invoice *</label>
                        <input type="text" name="nomor_invoice" value="{{ old('nomor_invoice', $invoice->nomor_invoice) }}" class="w-full rounded-lg border-2 border-yellow-400 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-400 focus:ring-opacity-30 text-sm py-2.5 px-3 bg-white font-bold" required>
                    </div>
                    <div class="lg:col-span-2">
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Nama Klien / Instansi *</label>
                        <input type="text" name="nama_klien" list="customer-list" value="{{ old('nama_klien', $invoice->nama_klien) }}" class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2.5 px-3" required autocomplete="off" placeholder="Pilih atau Ketik Nama Klien Baru...">
                        <datalist id="customer-list">
                            @foreach($customers as $customer)
                                <option value="{{ $customer->nama_klien }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Tanggal Invoice *</label>
                        <input type="date" name="tanggal_invoice" value="{{ old('tanggal_invoice', $invoice->tanggal_invoice ? $invoice->tanggal_invoice->format('Y-m-d') : '') }}" class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2.5 px-3" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Tanggal Jatuh Tempo *</label>
                        <input type="date" name="tanggal_jatuh_tempo" value="{{ old('tanggal_jatuh_tempo', $invoice->tanggal_jatuh_tempo ? $invoice->tanggal_jatuh_tempo->format('Y-m-d') : '') }}" class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2.5 px-3" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Status Pembayaran *</label>
                        <select name="status_pembayaran" class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2.5 px-3">
                            <option value="belum_lunas" {{ old('status_pembayaran', $invoice->status_pembayaran) === 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                            <option value="lunas" {{ old('status_pembayaran', $invoice->status_pembayaran) === 'lunas' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Ongkos Kirim (Ongkir) *</label>
                        <input type="number" name="ongkir" min="0" value="{{ old('ongkir', (int)$invoice->ongkir) }}" class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2.5 px-3" required>
                    </div>
                </div>

                <!-- Ringkasan Item (Read-Only) -->
                <div class="mb-6">
                    <label class="block text-[11px] font-bold text-gray-500 mb-2 uppercase tracking-wider">Daftar Barang (Tidak Dapat Diubah)</label>
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <table class="w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-3 py-2 text-center text-[11px] font-bold text-gray-700 uppercase w-10">#</th>
                                    <th class="px-3 py-2 text-left text-[11px] font-bold text-gray-700 uppercase">Barang</th>
                                    <th class="px-3 py-2 text-right text-[11px] font-bold text-gray-700 uppercase">Harga Satuan</th>
                                    <th class="px-3 py-2 text-center text-[11px] font-bold text-gray-700 uppercase w-16">Qty</th>
                                    <th class="px-3 py-2 text-right text-[11px] font-bold text-gray-700 uppercase">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($invoice->invoiceItems as $idx => $item)
                                <tr>
                                    <td class="px-3 py-2.5 text-center text-gray-500 font-bold">{{ $idx + 1 }}</td>
                                    <td class="px-3 py-2.5 font-semibold">
                                        <span class="bg-tema-marun text-white px-1.5 py-0.5 rounded text-[10px] font-bold mr-1">{{ $item->product->sku ?? '-' }}</span>
                                        {{ $item->product->nama_barang ?? 'Barang Dihapus' }}
                                    </td>
                                    <td class="px-3 py-2.5 text-right">Rp {{ number_format($item->harga_jual_snapshot, 0, ',', '.') }}</td>
                                    <td class="px-3 py-2.5 text-center font-bold">{{ $item->jumlah }}</td>
                                    <td class="px-3 py-2.5 text-right font-bold">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 font-bold">
                                <tr>
                                    <td colspan="4" class="px-3 py-2.5 text-right text-xs uppercase text-gray-600">Sub Total</td>
                                    <td class="px-3 py-2.5 text-right">Rp {{ number_format($invoice->sub_total, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="px-3 py-2.5 text-right text-xs uppercase text-gray-600">PPN (11%)</td>
                                    <td class="px-3 py-2.5 text-right">Rp {{ number_format($invoice->pajak_ppn, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="px-3 py-2.5 text-right text-xs uppercase text-gray-600">Ongkos Kirim (Ongkir)</td>
                                    <td class="px-3 py-2.5 text-right">Rp {{ number_format($invoice->ongkir ?? 0, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="bg-red-50">
                                    <td colspan="4" class="px-3 py-2.5 text-right text-xs font-black uppercase text-red-900">Total Tagihan</td>
                                    <td class="px-3 py-2.5 text-right text-red-600 font-black text-base">Rp {{ number_format($invoice->total_tagihan, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    @php
                        $cancelUrl = route('invoices.index');
                        if (request()->get('from') === 'online-orders') {
                            $cancelUrl = route('online-orders.index');
                        } elseif (request()->get('from') === 'reports') {
                            $cancelUrl = route('reports.online-orders');
                        }
                    @endphp
                    <a href="{{ $cancelUrl }}" class="bg-white border border-gray-300 hover:bg-gray-100 text-gray-700 font-bold py-2.5 px-5 rounded-lg transition-colors text-sm shadow-sm">
                        Batal
                    </a>
                    <button type="submit" class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-tema-hitam font-bold py-2.5 px-6 rounded-lg transition-all shadow-md text-sm flex items-center gap-2 hover:scale-105 duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
