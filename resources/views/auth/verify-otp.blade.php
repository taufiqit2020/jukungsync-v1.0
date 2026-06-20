<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - JukungSync ERP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { tema: { hitam: '#111827', kuning: '#FBBF24', marun: '#7f1d1d' } },
                    fontFamily: { sans: ['Inter','sans-serif'], heading: ['Outfit','sans-serif'] }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;700;800;900&display=swap" rel="stylesheet">
    <style>
        .otp-box {
            width: 48px; height: 60px;
            text-align: center; font-size: 1.5rem; font-weight: 900;
            border: 2px solid #e5e7eb; border-radius: 14px;
            background: #f9fafb; transition: all 0.15s;
            font-family: 'Outfit', monospace;
        }
        .otp-box:focus { border-color: #7f1d1d; background: white; box-shadow: 0 0 0 3px rgba(127,29,29,0.15); outline: none; }
        .otp-box.filled { border-color: #7f1d1d; background: #fff7f7; }
        @keyframes shake { 0%,100%{transform:translateX(0)} 20%,60%{transform:translateX(-6px)} 40%,80%{transform:translateX(6px)} }
        .shake { animation: shake 0.4s ease; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex">

    @php
        $otpMethod = session('otp_method', 'email');
        $otpTarget = session('otp_target', session('otp_email'));
        $isWhatsapp = $otpMethod === 'whatsapp';
    @endphp

    {{-- LEFT BRANDING --}}
    <div class="hidden lg:flex lg:w-5/12 xl:w-2/5 flex-col justify-between p-12 relative overflow-hidden" style="background: linear-gradient(145deg,#111827 0%,#1f2937 50%,#7f1d1d 100%)">
        <div class="absolute -top-24 -left-24 w-80 h-80 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-40 -right-20 w-96 h-96 bg-yellow-300/10 rounded-full"></div>

        <div class="relative z-10">
            <div class="inline-flex items-center gap-3 bg-white/10 border border-white/10 rounded-2xl px-4 py-3">
                <img src="{{ asset('img/invoice-watermark.png') }}" alt="Logo" class="h-10 object-contain">
                <div>
                    <p class="text-white/50 text-[9px] font-bold uppercase tracking-widest">Powered by</p>
                    <p class="text-white font-heading font-black text-lg leading-none">JukungSync<span class="text-yellow-400">.</span></p>
                </div>
            </div>
        </div>

        <div class="relative z-10">
            {{-- Icon sesuai metode --}}
            <div class="w-20 h-20 rounded-3xl flex items-center justify-center mb-6 {{ $isWhatsapp ? 'bg-green-400/20 border border-green-400/30' : 'bg-white/10 border border-white/15' }}">
                @if($isWhatsapp)
                <svg class="w-10 h-10 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.183-.573c.978.58 1.711.883 2.81.884 3.18 0 5.766-2.585 5.768-5.766 0-3.181-2.585-5.766-5.768-5.766zm3.332 8.163c-.159.453-.94.887-1.319.923-.339.032-.782.1-1.892-.353-1.332-.544-2.181-1.921-2.247-2.009-.065-.088-.535-.713-.535-1.36 0-.648.337-.968.455-1.09.117-.122.254-.153.338-.153s.169-.004.241-.004c.071 0 .17-.027.266.204.098.232.336.822.366.883.03.061.05.132.016.204-.035.071-.05.116-.1.177-.049.061-.106.133-.146.183-.045.051-.093.107-.04.204.053.096.237.396.508.64.351.314.646.406.744.457.098.051.155.04.213-.026.058-.066.248-.285.313-.383.066-.098.131-.082.222-.048.092.034.58.273.68.323s.166.075.19.117c.024.041.024.244-.135.697zm-3.332-10.457c4.619 0 8.375 3.756 8.375 8.375 0 4.619-3.756 8.375-8.375 8.375-1.554 0-3.003-.42-4.238-1.154l-4.708 1.236 1.263-4.593c-.808-1.285-1.268-2.813-1.268-4.464 0-4.619 3.756-8.375 8.375-8.375z"/>
                </svg>
                @else
                <svg class="w-10 h-10 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                @endif
            </div>

            <span class="text-yellow-400 text-[10px] font-black uppercase tracking-[0.3em] mb-4 block">
                Verifikasi {{ $isWhatsapp ? 'WhatsApp' : 'Email' }}
            </span>
            <h1 class="font-heading font-black text-white text-4xl leading-tight mb-4">
                Satu Langkah<br>Lagi Menuju<br><span class="text-yellow-400">Akses Penuh.</span>
            </h1>
            <p class="text-white/55 text-sm leading-relaxed max-w-xs mb-6">
                Kami telah mengirimkan kode verifikasi 6 digit ke {{ $isWhatsapp ? 'WhatsApp' : 'email' }} Anda. Masukkan kode tersebut untuk mengaktifkan akun.
            </p>
            <div class="p-4 bg-white/10 border border-white/15 rounded-2xl">
                <p class="text-white/60 text-xs font-semibold mb-1">
                    {{ $isWhatsapp ? '📱 Kode dikirim ke WhatsApp:' : '📧 Kode dikirim ke email:' }}
                </p>
                <p class="text-white font-bold text-sm break-all">{{ $otpTarget }}</p>
            </div>
        </div>

        <p class="relative z-10 text-white/25 text-xs">&copy; {{ date('Y') }} PT Utama Madani Raya.</p>
    </div>

    {{-- RIGHT: OTP Form --}}
    <div class="flex-1 flex items-center justify-center p-6 sm:p-10">
        <div class="w-full max-w-md">

            <div class="lg:hidden text-center mb-8">
                <img src="{{ asset('img/invoice-watermark.png') }}" alt="Logo" class="h-14 mx-auto mb-3 object-contain">
                <h2 class="font-heading font-black text-gray-800 text-xl">
                    Verifikasi {{ $isWhatsapp ? 'WhatsApp' : 'Email' }}
                </h2>
                <p class="text-gray-500 text-xs mt-1">
                    Kode OTP dikirim ke
                    <strong>{{ $isWhatsapp ? '💬 ' : '📧 ' }}{{ $otpTarget }}</strong>
                </p>
            </div>

            <div class="hidden lg:block mb-7">
                <h2 class="font-heading font-black text-gray-900 text-3xl mb-1">Masukkan Kode OTP</h2>
                <p class="text-gray-500 text-sm">
                    {{ $isWhatsapp
                        ? 'Periksa pesan WhatsApp di nomor yang Anda daftarkan.'
                        : 'Periksa inbox atau folder spam email Anda.' }}
                </p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">

                {{-- Metode badge --}}
                <div class="flex items-center justify-center gap-2 mb-6 p-3 rounded-2xl {{ $isWhatsapp ? 'bg-green-50 border border-green-100' : 'bg-blue-50 border border-blue-100' }}">
                    @if($isWhatsapp)
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.183-.573c.978.58 1.711.883 2.81.884 3.18 0 5.766-2.585 5.768-5.766 0-3.181-2.585-5.766-5.768-5.766zm3.332 8.163c-.159.453-.94.887-1.319.923-.339.032-.782.1-1.892-.353-1.332-.544-2.181-1.921-2.247-2.009-.065-.088-.535-.713-.535-1.36 0-.648.337-.968.455-1.09.117-.122.254-.153.338-.153s.169-.004.241-.004c.071 0 .17-.027.266.204.098.232.336.822.366.883.03.061.05.132.016.204-.035.071-.05.116-.1.177-.049.061-.106.133-.146.183-.045.051-.093.107-.04.204.053.096.237.396.508.64.351.314.646.406.744.457.098.051.155.04.213-.026.058-.066.248-.285.313-.383.066-.098.131-.082.222-.048.092.034.58.273.68.323s.166.075.19.117c.024.041.024.244-.135.697zm-3.332-10.457c4.619 0 8.375 3.756 8.375 8.375 0 4.619-3.756 8.375-8.375 8.375-1.554 0-3.003-.42-4.238-1.154l-4.708 1.236 1.263-4.593c-.808-1.285-1.268-2.813-1.268-4.464 0-4.619 3.756-8.375 8.375-8.375z"/>
                    </svg>
                    <div>
                        <p class="text-xs font-bold text-green-800">OTP via WhatsApp</p>
                        <p class="text-xs text-green-700">Dikirim ke: <strong>{{ $otpTarget }}</strong></p>
                    </div>
                    @else
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <div>
                        <p class="text-xs font-bold text-blue-800">OTP via Email</p>
                        <p class="text-xs text-blue-700">Dikirim ke: <strong>{{ $otpTarget }}</strong></p>
                    </div>
                    @endif
                </div>

                <form method="POST" action="{{ route('verify.otp.post') }}" class="space-y-6" id="otpForm">
                    @csrf

                    {{-- 6-box OTP input --}}
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-4 uppercase tracking-wider text-center">6 Digit Kode OTP</label>
                        <div class="flex items-center justify-center gap-2 sm:gap-3" id="otpBoxes">
                            @for($i = 0; $i < 6; $i++)
                            <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]"
                                class="otp-box" id="otpBox{{ $i }}"
                                autocomplete="off" required>
                            @endfor
                        </div>
                        {{-- Hidden actual otp field --}}
                        <input type="hidden" name="otp" id="otpHidden">

                        {{-- Countdown --}}
                        <div class="mt-5 flex items-center justify-center gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Sisa waktu: <strong id="countdown" class="text-red-800 font-mono font-black text-base">10:00</strong></span>
                        </div>
                    </div>

                    <button type="submit" id="submitBtn"
                        class="w-full py-3.5 bg-gray-900 hover:bg-black text-yellow-400 font-heading font-black text-sm rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 active:scale-95 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Verifikasi Sekarang
                    </button>
                </form>

                <div class="mt-7 pt-6 border-t border-gray-100 space-y-4 text-center">
                    <div>
                        <p class="text-xs text-gray-500 mb-2">
                            Belum menerima kode?
                            {{ $isWhatsapp ? 'Pastikan nomor HP aktif atau' : 'Periksa folder spam atau' }}
                        </p>
                        <form method="POST" action="{{ route('resend.otp') }}" id="resendForm">
                            @csrf
                            <button type="submit" id="resendBtn"
                                class="text-sm font-bold text-red-800 hover:underline disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                Kirim Ulang Kode OTP
                            </button>
                        </form>
                    </div>
                    <div class="pt-3 border-t border-gray-100">
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 text-xs text-gray-400 hover:text-gray-700 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Kembali ke Pendaftaran
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // ===== OTP Box Navigation =====
        const boxes = Array.from(document.querySelectorAll('.otp-box'));
        const hidden = document.getElementById('otpHidden');

        function syncHidden() {
            hidden.value = boxes.map(b => b.value).join('');
        }

        boxes.forEach((box, i) => {
            box.addEventListener('input', e => {
                box.value = box.value.replace(/[^0-9]/g, '').slice(-1);
                box.classList.toggle('filled', box.value !== '');
                syncHidden();
                if (box.value && i < 5) boxes[i + 1].focus();
            });
            box.addEventListener('keydown', e => {
                if (e.key === 'Backspace' && !box.value && i > 0) {
                    boxes[i - 1].value = '';
                    boxes[i - 1].classList.remove('filled');
                    boxes[i - 1].focus();
                    syncHidden();
                }
                if (e.key === 'ArrowLeft' && i > 0) boxes[i - 1].focus();
                if (e.key === 'ArrowRight' && i < 5) boxes[i + 1].focus();
            });
            box.addEventListener('paste', e => {
                e.preventDefault();
                const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '');
                pasted.split('').forEach((ch, j) => {
                    if (boxes[j]) { boxes[j].value = ch; boxes[j].classList.add('filled'); }
                });
                syncHidden();
                const next = Math.min(pasted.length, 5);
                boxes[next].focus();
            });
        });

        boxes[0].focus();

        // ===== OTP Form submit validation =====
        document.getElementById('otpForm').addEventListener('submit', function(e) {
            syncHidden();
            const otp = hidden.value;
            if (otp.length !== 6 || !/^\d{6}$/.test(otp)) {
                e.preventDefault();
                document.getElementById('otpBoxes').classList.add('shake');
                setTimeout(() => document.getElementById('otpBoxes').classList.remove('shake'), 500);
                return;
            }
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Memverifikasi...';
        });

        // ===== Countdown (10 menit) =====
        let timeLeft = 600; // 10 menit
        const countdownEl = document.getElementById('countdown');
        const resendBtn = document.getElementById('resendBtn');

        const timer = setInterval(() => {
            if (timeLeft <= 0) {
                clearInterval(timer);
                countdownEl.textContent = '00:00';
                countdownEl.style.color = '#dc2626';
                boxes.forEach(b => b.disabled = true);
                document.getElementById('submitBtn').disabled = true;
                Swal.fire({
                    icon: 'warning', title: 'Waktu Habis!',
                    text: 'Waktu 10 menit telah habis. Klik Kirim Ulang untuk mendapatkan kode OTP baru.',
                    confirmButtonColor: '#7f1d1d',
                });
            } else {
                const m = Math.floor(timeLeft / 60);
                const s = timeLeft % 60;
                countdownEl.textContent = (m < 10 ? '0' + m : m) + ':' + (s < 10 ? '0' + s : s);
                if (timeLeft <= 60) countdownEl.style.color = '#dc2626';
                timeLeft--;
            }
        }, 1000);
    </script>

    @if($errors->any())
    <script>
        Swal.fire({
            icon: 'error', title: 'Verifikasi Gagal!',
            html: '<ul style="text-align:left;" class="text-sm mt-2">@foreach($errors->all() as $error)<li>&bull; {{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#7f1d1d', confirmButtonText: 'Tutup'
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error', title: 'Verifikasi Gagal',
            text: '{{ addslashes(session("error")) }}',
            confirmButtonColor: '#7f1d1d',
        });
    </script>
    @endif

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success', title: 'Berhasil!',
            text: '{{ addslashes(session("success")) }}',
            confirmButtonColor: '#111827',
        });
    </script>
    @endif

</body>
</html>