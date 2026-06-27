<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryMovementController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OnlineOrderController;
use App\Http\Controllers\PaymentController;

// Rute serving file storage (Bypass symlink untuk hosting seperti Hostinger)
Route::get('media/{path}', [\App\Http\Controllers\StorageController::class, 'serve'])->where('path', '.*');
Route::get('storage/{path}', [\App\Http\Controllers\StorageController::class, 'serve'])->where('path', '.*');

// Rute Bantuan Otomatis (Hanya dipakai sekali)
Route::get('/jalankan-otomatis', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        return "BERHASIL! Database telah di-update secara otomatis. Cache telah dibersihkan. Silakan kembali ke website Anda.";
    } catch (\Exception $e) {
        return "Terjadi Kesalahan: " . $e->getMessage();
    }
});

Route::get('/test-checkout-debug', function() {
    try {
        $user = \App\Models\User::where('role', 'customer')->first();
        if (!$user) {
            $user = auth()->user();
        }
        if (!$user) {
            return "Silakan login terlebih dahulu atau pastikan ada data customer di database.";
        }
        $invoiceBlocked = $user->canUseInvoice30() && $user->hasBlockedInvoice();
        return response()->json([
            'status' => 'success',
            'user' => $user->email,
            'role' => $user->role,
            'tipe_pelanggan' => $user->tipe_pelanggan,
            'invoiceBlocked' => $invoiceBlocked
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => explode("\n", $e->getTraceAsString())
        ]);
    }
});

// Root Landing Page (Publik - tampilkan produk tanpa login)
Route::get('/', function () {
    $products = \App\Models\Product::with(['category', 'merk'])
        ->orderBy('nama_barang', 'asc')
        ->get();

    $groupedProducts = $products->groupBy(function ($product) {
        return $product->category ? $product->category->nama_kategori : 'Tanpa Kategori';
    })->sortBy(function ($items, $key) {
        return $key === 'Tanpa Kategori' ? 1 : 0;
    });

    return view('welcome', compact('groupedProducts'));
})->name('welcome');

// Authentication Routes (Guest Only)
Route::middleware('guest')->group(function () {
    // Login & Register (Limit: 5 attempt per menit untuk mencegah Brute-Force/Spam)
    Route::middleware('throttle:5,1')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.post');
        Route::get('register', [AuthController::class, 'showRegister'])->name('register');
        Route::post('register', [AuthController::class, 'register'])->name('register.post');
    });

    // OTP Verification Routes
    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('verify.otp');
    
    // (Batasan: 5 percobaan per menit untuk cegah tebak kode)
    Route::middleware('throttle:5,1')->group(function () {
        Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp.post');
        Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('resend.otp');
    });
});



// Protected ERP Routes
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile routes for all authenticated users
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
    // Surat Jalan / Tanda Terima Barang (Invoice Manual)
    Route::get('invoices/{invoice}/surat-jalan', [\App\Http\Controllers\InvoiceController::class, 'suratJalan'])->name('invoices.surat-jalan');
    // Surat Jalan Pesanan Online
    Route::get('online-orders/{online_order}/surat-jalan', [OnlineOrderController::class, 'suratJalan'])->name('online-orders.surat-jalan');
    
    // FR-04: Global Search (accessible to all authenticated users)
    Route::get('/api/search', [\App\Http\Controllers\SearchController::class, 'search'])->name('api.search');
    
    // Administrative Regions Proxy API (same domain to avoid CORS/DNS issues in client browser)
    Route::get('/api/wilayah/provinces', [\App\Http\Controllers\CatalogController::class, 'getProvinces'])->name('api.wilayah.provinces');
    Route::get('/api/wilayah/regencies/{provinceId}', [\App\Http\Controllers\CatalogController::class, 'getRegencies'])->name('api.wilayah.regencies');
    Route::get('/api/wilayah/districts/{regencyId}', [\App\Http\Controllers\CatalogController::class, 'getDistricts'])->name('api.wilayah.districts');
    Route::get('/api/wilayah/villages/{districtId}', [\App\Http\Controllers\CatalogController::class, 'getVillages'])->name('api.wilayah.villages');
    
    // Rute yang bisa diakses oleh semua internal (staf_admin, direktur, bendahara, superadmin)
    Route::middleware('role:staf_admin,direktur,bendahara')->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Invoices (Read & Print) - direktur & bendahara bisa lihat
        Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
        Route::get('invoices/{invoice}/word', [InvoiceController::class, 'exportWord'])->name('invoices.export-word');
        Route::get('invoices/{invoice}/struk', [InvoiceController::class, 'struk'])->name('invoices.struk');

        // Laporan (Read)
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/print', [ReportController::class, 'print'])->name('reports.print');
        Route::get('reports/excel', [ReportController::class, 'exportSalesExcel'])->name('reports.excel');
        
        Route::get('reports/stock', [ReportController::class, 'stockCard'])->name('reports.stock');
        Route::get('reports/stock/print', [ReportController::class, 'printStockCard'])->name('reports.stock.print');
        Route::get('reports/stock/excel', [ReportController::class, 'exportStockCardExcel'])->name('reports.stock.excel');
        
        Route::get('reports/movements', [ReportController::class, 'movements'])->name('reports.movements');
        Route::get('reports/movements/print', [ReportController::class, 'printMovements'])->name('reports.movements.print');
        Route::get('reports/movements/excel', [ReportController::class, 'exportMovementsExcel'])->name('reports.movements.excel');
        
        Route::get('reports/purchases', [ReportController::class, 'purchases'])->name('reports.purchases');
        Route::get('reports/purchases/print', [ReportController::class, 'printPurchases'])->name('reports.purchases.print');
        Route::get('reports/purchases/excel', [ReportController::class, 'exportPurchasesExcel'])->name('reports.purchases.excel');

        Route::get('reports/online-orders', [ReportController::class, 'onlineOrders'])->name('reports.online-orders');
        Route::get('reports/online-orders/print', [ReportController::class, 'printOnlineOrders'])->name('reports.online-orders.print');
        Route::get('reports/online-orders/excel', [ReportController::class, 'exportOnlineOrdersExcel'])->name('reports.online-orders.excel');

        Route::get('reports/jatuh-tempo', [ReportController::class, 'jatuhTempo'])->name('reports.jatuh-tempo');
        Route::get('reports/jatuh-tempo/print', [ReportController::class, 'printJatuhTempo'])->name('reports.jatuh-tempo.print');

        Route::get('reports/expenses', [ReportController::class, 'expenses'])->name('reports.expenses');
        Route::get('reports/expenses/print', [ReportController::class, 'printExpenses'])->name('reports.expenses.print');

        // Pesanan Online (View Only untuk direktur/bendahara, action untuk staf_admin ditambahkan di bawah)
        Route::get('online-orders', [OnlineOrderController::class, 'index'])->name('online-orders.index');
        Route::get('online-orders/{online_order}', [OnlineOrderController::class, 'show'])->name('online-orders.show');
    });

    // Rute yang HANYA bisa diakses staf_admin (dan superadmin)
    Route::middleware('role:staf_admin')->group(function() {
        // Master Data
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('merks', MerkController::class)->except(['show']);
        Route::resource('customers', CustomerController::class);
        Route::get('products/next-sku', [ProductController::class, 'nextSku'])->name('products.next-sku');
        Route::resource('products', ProductController::class)->except(['show']);
        
        // Transaksi Barang Masuk/Keluar
        Route::resource('inventory-movements', InventoryMovementController::class)->except(['show']);
        
        // Pembuatan Invoice
        Route::get('api/movements/manual-out', [InvoiceController::class, 'getManualOutMovements'])->name('api.movements.manual_out');
        Route::resource('invoices', InvoiceController::class)->only(['create', 'store']);
    });

    // Rute Aksi Pesanan Online & Kasbon (Bisa diakses Staf Admin, Bendahara/Kepala Keuangan, dan Superadmin)
    Route::middleware('role:staf_admin,bendahara')->group(function() {
        Route::post('online-orders/{online_order}/approve', [OnlineOrderController::class, 'approve'])->name('online-orders.approve');
        Route::post('online-orders/{online_order}/complete', [OnlineOrderController::class, 'complete'])->name('online-orders.complete');
        Route::post('online-orders/{online_order}/complete-paid', [OnlineOrderController::class, 'completePaid'])->name('online-orders.complete-paid');
        Route::post('online-orders/{online_order}/complete-unpaid', [OnlineOrderController::class, 'completeUnpaid'])->name('online-orders.complete-unpaid');
        Route::post('online-orders/{online_order}/reject', [OnlineOrderController::class, 'reject'])->name('online-orders.reject');

        // Manajemen Kasbon
        Route::get('kasbons', [\App\Http\Controllers\KasbonController::class, 'index'])->name('kasbons.index');
        Route::post('kasbons/{kasbon}/bayar', [\App\Http\Controllers\KasbonController::class, 'bayar'])->name('kasbons.bayar');
        Route::delete('kasbons/{kasbon}', [\App\Http\Controllers\KasbonController::class, 'destroy'])->name('kasbons.destroy');
    });

    // Rute Khusus Customer
    Route::middleware('role:customer')->group(function() {
        Route::get('/catalog', [\App\Http\Controllers\CatalogController::class, 'index'])->name('catalog.index');
        Route::get('/catalog/checkout', [\App\Http\Controllers\CatalogController::class, 'checkout'])->name('catalog.checkout');
        Route::post('/catalog/order', [\App\Http\Controllers\CatalogController::class, 'storeOrder'])->name('catalog.order');
        Route::get('/catalog/orders', [\App\Http\Controllers\CatalogController::class, 'myOrders'])->name('catalog.orders');
    });

    // Rute Khusus Superadmin & Bendahara
    Route::middleware('role:superadmin,bendahara')->group(function() {
        // Upload Bukti Invoice
        Route::post('invoices/{invoice}/upload-bukti', [InvoiceController::class, 'uploadBukti'])->name('invoices.upload-bukti');
        
        // Laporan Bukti Invoice
        Route::get('reports/bukti-invoices', [ReportController::class, 'buktiInvoices'])->name('reports.bukti-invoices');
        Route::get('reports/bukti-invoices/print', [ReportController::class, 'printBuktiInvoices'])->name('reports.bukti-invoices.print');
    });

    // Rute Khusus Superadmin (Staff IT)
    Route::middleware('role:superadmin')->group(function() {
        Route::resource('users', \App\Http\Controllers\UserController::class);
        
        // Invoice Management (Edit & Hapus) - Hanya Superadmin
        Route::get('invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
        Route::put('invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
        Route::delete('invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');

        // Pengaturan Sistem / Landing Page
        Route::get('settings/landing-page', [\App\Http\Controllers\SettingController::class, 'landingPage'])->name('settings.landing-page');
        Route::post('settings/landing-page', [\App\Http\Controllers\SettingController::class, 'storeLandingPage'])->name('settings.landing-page.store');

        // Backup Database
        Route::get('backup/download', [\App\Http\Controllers\DatabaseBackupController::class, 'download'])->name('backup.download');
    });

    // Rute Khusus Staf Admin & Bendahara
    Route::middleware('role:staf_admin,bendahara')->group(function() {
        Route::post('invoices/{invoice}/mark-paid', [InvoiceController::class, 'markPaid'])->name('invoices.mark-paid');
        Route::resource('purchases', PurchaseController::class);
    });

    // Rute Khusus Bendahara & Superadmin
    Route::middleware('role:bendahara,superadmin')->group(function() {
        Route::resource('expenses', \App\Http\Controllers\ExpenseController::class);
    });
});
