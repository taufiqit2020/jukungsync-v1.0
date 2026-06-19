<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::orderBy('nama_klien', 'asc');
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_klien', 'like', '%' . $search . '%')
                  ->orWhere('no_telp', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('npwp', 'like', '%' . $search . '%');
            });
        }
        
        $customers = $query->paginate(10)->withQueryString();
        
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_klien' => 'required|string|unique:customers,nama_klien|max:255',
            'no_telp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'npwp' => 'nullable|string|max:50',
            'tipe_customer' => 'required|string|in:Perorangan,Instansi',
            'alamat' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Data Customer berhasil ditambahkan.');
    }

    public function show(Customer $customer)
    {
        // Total transaksi sepanjang masa (completed invoices)
        $totalTransaksi = Invoice::completed()
            ->where(function($q) use ($customer) {
                $q->where('klien_id', $customer->id)
                  ->orWhere('nama_klien', $customer->nama_klien);
            })->sum('total_tagihan');

        // Outstanding (total tagihan yang masih belum lunas)
        $totalOutstanding = Invoice::completed()
            ->where('status_pembayaran', 'belum_lunas')
            ->where(function($q) use ($customer) {
                $q->where('klien_id', $customer->id)
                  ->orWhere('nama_klien', $customer->nama_klien);
            })->sum('total_tagihan');

        // Histori invoice
        $invoices = Invoice::where(function($q) use ($customer) {
                $q->where('klien_id', $customer->id)
                  ->orWhere('nama_klien', $customer->nama_klien);
            })
            ->latest('tanggal_invoice')
            ->latest('id')
            ->get();

        return view('customers.show', compact('customer', 'totalTransaksi', 'totalOutstanding', 'invoices'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'nama_klien' => 'required|string|max:255|unique:customers,nama_klien,' . $customer->id,
            'no_telp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'npwp' => 'nullable|string|max:50',
            'tipe_customer' => 'required|string|in:Perorangan,Instansi',
            'alamat' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Data Customer berhasil diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return redirect()->route('customers.index')->with('success', 'Data Customer berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus Customer: ' . $e->getMessage());
        }
    }
}
