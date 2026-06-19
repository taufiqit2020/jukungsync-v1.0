<?php
$file = 'app/Http/Controllers/InvoiceController.php';
$content = file_get_contents($file);

// Index
$searchIndex = <<<EOD
    public function index()
    {
        \$invoices = Invoice::with('invoiceItems.product')->orderBy('tanggal_invoice', 'desc')->orderBy('created_at', 'desc')->get();
        \$products = Product::with('category')->orderBy('sku', 'asc')->get();

        \$nomor_invoice = \$this->generateInvoiceNumber();

        return view('invoices.index', compact('invoices', 'products', 'nomor_invoice'));
    }
EOD;
$replaceIndex = <<<EOD
    public function index()
    {
        \$invoices = Invoice::with('invoiceItems.product')->orderBy('tanggal_invoice', 'desc')->orderBy('created_at', 'desc')->get();
        \$products = Product::with('category')->orderBy('sku', 'asc')->get();
        \$customers = \App\Models\Customer::orderBy('nama_klien', 'asc')->get();

        \$nomor_invoice = \$this->generateInvoiceNumber();

        return view('invoices.index', compact('invoices', 'products', 'nomor_invoice', 'customers'));
    }
EOD;
$content = str_replace($searchIndex, $replaceIndex, $content);

// Create
$searchCreate = <<<EOD
    public function create()
    {
        \$products = Product::orderBy('sku', 'asc')->get();
        \$nomor_invoice = \$this->generateInvoiceNumber();

        return view('invoices.create', compact('products', 'nomor_invoice'));
    }
EOD;
$replaceCreate = <<<EOD
    public function create()
    {
        \$products = Product::orderBy('sku', 'asc')->get();
        \$customers = \App\Models\Customer::orderBy('nama_klien', 'asc')->get();
        \$nomor_invoice = \$this->generateInvoiceNumber();

        return view('invoices.create', compact('products', 'nomor_invoice', 'customers'));
    }
EOD;
$content = str_replace($searchCreate, $replaceCreate, $content);

// Store
$searchStore = <<<EOD
                // Create temporary invoice to get ID
                \$invoice = Invoice::create([
                    'nomor_invoice' => \$request->nomor_invoice,
                    'nama_klien' => \$request->nama_klien,
                    'tanggal_invoice' => \$request->tanggal_invoice,
                    'tanggal_jatuh_tempo' => \$request->tanggal_jatuh_tempo,
                    'status' => 'selesai',
                    'sub_total' => 0,
                    'pajak_ppn' => 0,
                    'total_tagihan' => 0,
                    'status_pembayaran' => 'belum_lunas'
                ]);
EOD;
$replaceStore = <<<EOD
                // Save customer automatically if not exists
                \$klien = trim(\$request->nama_klien);
                if(!empty(\$klien)){
                    \App\Models\Customer::firstOrCreate(['nama_klien' => \$klien]);
                }

                // Create temporary invoice to get ID
                \$invoice = Invoice::create([
                    'nomor_invoice' => \$request->nomor_invoice,
                    'nama_klien' => \$klien,
                    'tanggal_invoice' => \$request->tanggal_invoice,
                    'tanggal_jatuh_tempo' => \$request->tanggal_jatuh_tempo,
                    'status' => 'selesai',
                    'sub_total' => 0,
                    'pajak_ppn' => 0,
                    'total_tagihan' => 0,
                    'status_pembayaran' => 'belum_lunas'
                ]);
EOD;
$content = str_replace($searchStore, $replaceStore, $content);

// Edit
$searchEdit = <<<EOD
    public function edit(Invoice \$invoice)
    {
        \$invoice->load('invoiceItems.product.category');
        \$products = Product::with('category')->orderBy('sku', 'asc')->get();
        return view('invoices.edit', compact('invoice', 'products'));
    }
EOD;
$replaceEdit = <<<EOD
    public function edit(Invoice \$invoice)
    {
        \$invoice->load('invoiceItems.product.category');
        \$products = Product::with('category')->orderBy('sku', 'asc')->get();
        \$customers = \App\Models\Customer::orderBy('nama_klien', 'asc')->get();
        return view('invoices.edit', compact('invoice', 'products', 'customers'));
    }
EOD;
$content = str_replace($searchEdit, $replaceEdit, $content);

// Update
$searchUpdateStore = <<<EOD
        \$invoice->update([
            'nomor_invoice' => \$request->nomor_invoice,
            'nama_klien' => \$request->nama_klien,
            'tanggal_invoice' => \$request->tanggal_invoice,
            'tanggal_jatuh_tempo' => \$request->tanggal_jatuh_tempo,
            'status_pembayaran' => \$request->status_pembayaran,
        ]);
EOD;
$replaceUpdateStore = <<<EOD
        \$klien = trim(\$request->nama_klien);
        if(!empty(\$klien)){
            \App\Models\Customer::firstOrCreate(['nama_klien' => \$klien]);
        }

        \$invoice->update([
            'nomor_invoice' => \$request->nomor_invoice,
            'nama_klien' => \$klien,
            'tanggal_invoice' => \$request->tanggal_invoice,
            'tanggal_jatuh_tempo' => \$request->tanggal_jatuh_tempo,
            'status_pembayaran' => \$request->status_pembayaran,
        ]);
EOD;
$content = str_replace($searchUpdateStore, $replaceUpdateStore, $content);

file_put_contents($file, $content);
echo "Invoice controller updated.\n";
