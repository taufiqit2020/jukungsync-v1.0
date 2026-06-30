<?php

namespace App\Http\Controllers;

use App\Models\SlipGaji;
use Illuminate\Http\Request;

class SlipGajiController extends Controller
{
    public function index(Request $request)
    {
        $query = SlipGaji::query();

        // Search by Employee Name or Slip Number
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('nama_karyawan', 'like', "%{$search}%")
                  ->orWhere('nomor_slip', 'like', "%{$search}%");
            });
        }

        // Filter by Period
        if ($periode = $request->input('periode')) {
            $query->where('periode', $periode);
        }

        $slipGajis = $query->orderBy('created_at', 'desc')->paginate(15);
        $periodes = SlipGaji::select('periode')->distinct()->pluck('periode');

        return view('slip_gaji.index', compact('slipGajis', 'periodes'));
    }

    public function create()
    {
        $nomorSlip = SlipGaji::generateSlipNumber();
        return view('slip_gaji.create', compact('nomorSlip'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'periode' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric|min:0',
            'lembur' => 'nullable|numeric|min:0',
            'tunjangan_bonus' => 'nullable|numeric|min:0',
            'bpjs_kesehatan' => 'nullable|numeric|min:0',
            'bpjs_ketenagakerjaan' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['nomor_slip'] = SlipGaji::generateSlipNumber();

        SlipGaji::create($data);

        return redirect()->route('slip-gaji.index')->with('success', 'Slip Gaji berhasil dibuat.');
    }

    public function edit(SlipGaji $slipGaji)
    {
        return view('slip_gaji.edit', compact('slipGaji'));
    }

    public function update(Request $request, SlipGaji $slipGaji)
    {
        $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'periode' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric|min:0',
            'lembur' => 'nullable|numeric|min:0',
            'tunjangan_bonus' => 'nullable|numeric|min:0',
            'bpjs_kesehatan' => 'nullable|numeric|min:0',
            'bpjs_ketenagakerjaan' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        $slipGaji->update($request->all());

        return redirect()->route('slip-gaji.index')->with('success', 'Slip Gaji berhasil diperbarui.');
    }

    public function show(SlipGaji $slipGaji)
    {
        return view('slip_gaji.show', compact('slipGaji'));
    }

    public function destroy(SlipGaji $slipGaji)
    {
        $slipGaji->delete();
        return redirect()->route('slip-gaji.index')->with('success', 'Slip Gaji berhasil dihapus.');
    }

    public function exportExcel(SlipGaji $slipGaji)
    {
        $html = view('slip_gaji.excel', compact('slipGaji'))->render();
        $filename = 'Slip-Gaji-' . str_replace('/', '-', $slipGaji->nomor_slip) . '.xls';

        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Cache-Control', 'max-age=0');
    }
}
