<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Catalog - PT Utama Madani Raya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        tema: {
                            hitam: '#111827',
                            kuning: '#FBBF24',
                            marun: '#7f1d1d',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-heading { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 font-sans min-h-screen flex flex-col">
    <!-- Header Customer -->
    <header class="bg-[#111827] text-white py-4 px-6 sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('catalog.index') }}" class="flex items-center gap-3">
                <div class="bg-white/95 backdrop-blur-sm rounded-xl p-2 shadow-sm flex items-center justify-center">
                    <img src="{{ asset('img/invoice-watermark.png') }}" alt="Logo" class="h-8 object-contain">
                </div>
                <div>
                    <h1 class="font-heading font-bold text-xl leading-tight">E-Catalog UMAR<span class="text-[#FBBF24]">.</span></h1>
                </div>
            </a>
            <a href="{{ route('catalog.index') }}" class="text-sm font-medium hover:text-[#FBBF24] transition-colors">
                &larr; Kembali ke Katalog
            </a>
        </div>
    </header>
    <main class="flex-grow p-6">
        <div class="max-w-7xl mx-auto mt-4">
            @yield('content')
        </div>
    </main>
</body>
</html>
