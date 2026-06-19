<?php
$b64_index = base64_encode(<<<EOD
@extends('layouts.admin')
@section('title', 'Data Customer')
@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Daftar Customer / Klien</h2>
        <a href="{{ route('customers.create') }}" class="bg-tema-marun hover:bg-red-900 text-white font-medium py-2 px-4 rounded-md transition-colors shadow-sm flex items-center gap-2 hover:scale-105 duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Customer
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-800 p-4 rounded-md mb-6 border border-green-200">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 text-red-800 p-4 rounded-md mb-6 border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-md border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-tema-hitam">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Klien / Instansi</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No Telp</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse(\$customers as \$index => \$customer)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \$customers->firstItem() + \$index }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ \$customer->nama_klien }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \$customer->no_telp ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \$customer->email ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('customers.edit', \$customer->id) }}" class="inline-flex items-center px-2.5 py-1.5 bg-yellow-400 text-yellow-900 hover:bg-yellow-500 rounded text-xs font-bold transition-colors shadow-sm" title="Edit Customer">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit
                            </a>
                            <form action="{{ route('customers.destroy', \$customer->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data customer ini? Data yang dihapus tidak dapat dikembalikan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 bg-red-600 text-white hover:bg-red-700 rounded text-xs font-bold transition-colors shadow-sm" title="Hapus Customer">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada data customer yang ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ \$customers->links() }}
    </div>
</div>
@endsection
EOD);

// Fix controller
$b64_ctrl = base64_encode(<<<EOD
<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        \$customers = Customer::orderBy('nama_klien', 'asc')->paginate(10);
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request \$request)
    {
        \$request->validate([
            'nama_klien' => 'required|string|unique:customers,nama_klien|max:255',
            'no_telp' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'keterangan' => 'nullable|string'
        ]);

        Customer::create(\$request->all());

        return redirect()->route('customers.index')->with('success', 'Data Customer berhasil ditambahkan.');
    }

    public function edit(Customer \$customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request \$request, Customer \$customer)
    {
        \$request->validate([
            'nama_klien' => 'required|string|max:255|unique:customers,nama_klien,' . \$customer->id,
            'no_telp' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'keterangan' => 'nullable|string'
        ]);

        \$customer->update(\$request->all());

        return redirect()->route('customers.index')->with('success', 'Data Customer berhasil diperbarui.');
    }

    public function destroy(Customer \$customer)
    {
        try {
            \$customer->delete();
            return redirect()->route('customers.index')->with('success', 'Data Customer berhasil dihapus.');
        } catch (\Exception \$e) {
            return redirect()->route('customers.index')->with('error', 'Gagal menghapus! Data mungkin sedang digunakan di Invoice.');
        }
    }
}
EOD);

// Create V9 Installer
$php = "<?php\n";
$php .= "ini_set('display_errors', 1);\n";
$php .= "ini_set('display_startup_errors', 1);\n";
$php .= "error_reporting(E_ALL);\n\n";

$php .= "function findLaravelRoot(\$dir, \$depth = 0) {\n";
$php .= "    if (\$depth > 3) return null;\n";
$php .= "    if (!is_dir(\$dir)) return null;\n";
$php .= "    if (file_exists(\$dir . '/artisan') && file_exists(\$dir . '/bootstrap/app.php')) return \$dir;\n";
$php .= "    \$items = @scandir(\$dir);\n";
$php .= "    if (!\$items) return null;\n";
$php .= "    foreach (\$items as \$item) {\n";
$php .= "        if (\$item === '.' || \$item === '..') continue;\n";
$php .= "        \$path = \$dir . '/' . \$item;\n";
$php .= "        if (is_dir(\$path)) {\n";
$php .= "            \$found = findLaravelRoot(\$path, \$depth + 1);\n";
$php .= "            if (\$found) return \$found;\n";
$php .= "        }\n";
$php .= "    }\n";
$php .= "    return null;\n";
$php .= "}\n\n";

$php .= "\$baseSearch = dirname(__DIR__);\n";
$php .= "\$laravelRoot = findLaravelRoot(\$baseSearch);\n";
$php .= "if (!\$laravelRoot) {\n";
$php .= "    \$index = @file_get_contents(__DIR__ . '/index.php');\n";
$php .= "    if (\$index && preg_match('/require.*?__DIR__\s*\.\s*[\'\"](.*?)vendor\/autoload\.php[\'\"]/', \$index, \$m)) {\n";
$php .= "        \$rel = trim(\$m[1], '/');\n";
$php .= "        \$laravelRoot = \$rel === '..' ? realpath(__DIR__ . '/..') : realpath(__DIR__ . '/' . \$rel);\n";
$php .= "    }\n";
$php .= "}\n";
$php .= "if (!\$laravelRoot) \$laravelRoot = __DIR__;\n\n";

$php .= "try {\n";
$php .= "    file_put_contents(\$laravelRoot . '/resources/views/customers/index.blade.php', base64_decode('$b64_index'));\n";
$php .= "    file_put_contents(\$laravelRoot . '/app/Http/Controllers/CustomerController.php', base64_decode('$b64_ctrl'));\n";

$php .= "    echo \"<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>\";\n";
$php .= "    echo \"<h1 style='color:#16a34a;'>✅ Perbaikan Tampilan Selesai!</h1>\";\n";
$php .= "    echo \"<p style='color:#4b5563;'>Halaman Data Customer sudah diperbaiki dan tabel sudah sesuai dengan datanya.</p>\";\n";
$php .= "    echo \"<a href='/customers' style='display: inline-block; padding: 10px 20px; background: #991b1b; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px;'>Kembali ke Aplikasi</a>\";\n";
$php .= "    echo \"</div>\";\n\n";

$php .= "    @unlink(__FILE__);\n";
$php .= "} catch (\\Exception \$e) {\n";
$php .= "    echo \"<h1 style='color:red;'>Error Fatal:</h1><pre>\" . \$e->getMessage() . \"</pre>\";\n";
$php .= "}\n";

$md = "```php\n" . $php . "\n```";
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_customer_v9.md', $md);
