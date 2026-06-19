<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - PT Utama Madani Raya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-heading { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 font-sans min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    
    <!-- Background Elements -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-red-900 rounded-full mix-blend-multiply filter blur-[100px] opacity-20"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-yellow-400 rounded-full mix-blend-multiply filter blur-[100px] opacity-20"></div>

    <div class="max-w-xl w-full bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-gray-100 z-10 relative">
        <div class="h-2 w-full bg-gradient-to-r from-red-900 via-red-600 to-yellow-400"></div>
        
        <div class="p-8 sm:p-12 text-center">
            <!-- Icon -->
            <div class="mx-auto w-24 h-24 bg-red-50 text-red-600 rounded-full flex items-center justify-center mb-6 shadow-inner border-4 border-white">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>

            <!-- Error Code & Title -->
            <h1 class="font-heading text-8xl font-black text-transparent bg-clip-text bg-gradient-to-br from-gray-800 to-gray-400 mb-2">403</h1>
            <h2 class="text-2xl font-bold text-gray-800 mb-4 tracking-tight">Akses Terbatas</h2>
            
            <!-- Message -->
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mb-8">
                <p class="text-gray-600 font-medium leading-relaxed">
                    {{ $exception->getMessage() ?: 'Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.' }}
                </p>
                <p class="text-sm text-gray-500 mt-2">
                    Silakan hubungi Superadmin jika Anda merasa ini adalah sebuah kesalahan.
                </p>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <button onclick="window.history.back()" class="w-full sm:w-auto px-6 py-3 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all shadow-sm flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </button>
                <a href="{{ auth()->check() && auth()->user()->role === 'customer' ? route('catalog.index') : route('dashboard') }}" class="w-full sm:w-auto px-6 py-3 bg-red-900 text-white font-bold rounded-xl hover:bg-red-800 transition-all shadow-md flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Beranda
                </a>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="bg-gray-50 py-4 px-6 text-center border-t border-gray-100">
            <div class="flex items-center justify-center gap-2 opacity-60">
                <img src="{{ asset('img/invoice-watermark.png') }}" alt="PT UMAR" class="h-5">
                <span class="text-xs font-bold text-gray-600">PT UTAMA MADANI RAYA</span>
            </div>
        </div>
    </div>
</body>
</html>
