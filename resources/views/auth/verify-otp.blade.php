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
            <div class="w-20 h-20 rounded-3xl bg-white/10 border border-white/15 flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="text-yellow-400 text-[10px] font-black uppercase tracking-[0.3em] mb-4 block">Verifikasi Email</span>
            <h1 class="font-heading font-black text-white text-4xl leading-tight mb-4">
                Satu Langkah<br>Lagi Menuju<br><span class="text-yellow-400">Akses Penuh.</span>
            </h1>
            <p class="text-white/55 text-sm leading-relaxed max-w-xs mb-6">
                Kami telah mengirimkan kode verifikasi 6 digit ke email Anda. Masukkan kode tersebut untuk mengaktifkan akun.
            </p>
            <div class="p-4 bg-white/10 border border-white/15 rounded-2xl">
                <p class="text-white/60 text-xs font-semibold mb-1">📧 Kode dikirim ke:</p>
                <p class="text-white font-bold text-sm break-all">{{ session('otp_email') }}</p>
            </div>
        </div>

        <p class="relative z-10 text-white/25 text-xs">&copy; {{ date('Y') }} PT Utama Madani Raya.</p>
    </div>

    {{-- RIGHT: OTP Form --}}
    <div class="flex-1 flex items-center justify-center p-6 sm:p-10">
        <div class="w-full max-w-md">

            <div class="lg:hidden text-center mb-8">
                <img src="{{ asset('img/invoice-watermark.png') }}" alt="Logo" class="h-14 mx-auto mb-3 object-contain">
                <h2 class="font-heading font-black text-gray-800 text-xl">Verifikasi Email</h2>
                <p class="text-gray-500 text-xs mt-1">Kode OTP dikirim ke <strong>{{ session('otp_email') }}</strong></p>
            </div>

            <div class="hidden lg:block mb-7">
                <h2 class="font-heading font-black text-gray-900 text-3xl mb-1">Masukkan Kode OTP</h2>
                <p class="text-gray-500 text-sm">Periksa inbox atau folder spam email Anda.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">

                {{-- Mobile email info --}}
                <div class="lg:hidden mb-6 p-3 bg-gray-50 border border-gray-100 rounded-xl text-center">
                    <p class="text-xs text-gray-500">Kode dikirim ke:</p>
                    <p class="text-sm font-bold text-gray-800 break-all">{{ session('otp_email') }}</p>
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
                            <span>Sisa waktu: <strong id="countdown" class="text-red-800 font-mono font-black text-base">05:00</strong></span>
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
                        <p class="text-xs text-gray-500 mb-2">Belum menerima email? Periksa folder <em>spam</em> atau</p>
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
                // Allow only digits
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

        // ===== Countdown =====
        let timeLeft = 300;
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
                    text: 'Waktu 5 menit telah habis. Klik Kirim Ulang untuk mendapatkan kode OTP baru.',
                    confirmButtonColor: '#7f1d1d',
                });
            } else {
                const m = Math.floor(timeLeft / 60);
                const s = timeLeft % 60;
                countdownEl.textContent = (m < 10 ? '0' + m : m) + ':' + (s < 10 ? '0' + s : s);
                if (timeLeft <= 60) countdownEl.style.animation = 'none';
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