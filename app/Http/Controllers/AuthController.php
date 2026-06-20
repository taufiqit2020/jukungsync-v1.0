<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman form login
     */
    /**
     * Arahkan user ke halaman sesuai role-nya
     */
    private function redirectByRole()
    {
        $role = Auth::user()->role;
        return match($role) {
            'customer'  => redirect()->route('catalog.index')->with('success', 'Berhasil masuk! Selamat datang di JukungSync.'),
            default     => redirect()->route('dashboard')->with('success', 'Berhasil masuk! Selamat datang di JukungSync.'),
        };
    }

    public function showLogin()
    {
        // Jika sudah login, lempar ke halaman sesuai role
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('auth.login');
    }

    public function showRegister()
    {
        // Jika sudah login, lempar ke halaman sesuai role
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'perusahaan'  => ['required', 'string', 'max:255'],
            'alamat'      => ['required', 'string'],
            'nomor_hp'    => ['required', 'string', 'max:20'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'    => ['required', 'string', 'min:8', 'confirmed'],
            'foto_ktp'    => ['required', 'string'],   // base64 dari kamera
            'otp_method'  => ['required', 'in:email,whatsapp'],
        ], [
            'foto_ktp.required' => 'Foto KTP wajib diambil menggunakan kamera sebelum mendaftar.',
        ]);

        // Simpan foto KTP (base64) ke storage
        $ktpPath = null;
        try {
            $base64Data = $validated['foto_ktp'];
            // Hapus prefix data URI jika ada (data:image/jpeg;base64,...)
            if (str_contains($base64Data, ',')) {
                $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
            }
            $imageData = base64_decode($base64Data);
            $filename  = 'ktp/' . uniqid('ktp_') . '.jpg';
            \Illuminate\Support\Facades\Storage::disk('public')->put($filename, $imageData);
            $ktpPath = $filename;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal menyimpan foto KTP: ' . $e->getMessage());
        }

        $otp = sprintf('%06d', mt_rand(100000, 999999));

        $user = User::create([
            'name'                  => $validated['name'],
            'perusahaan'            => $validated['perusahaan'],
            'alamat'                => $validated['alamat'],
            'nomor_hp'              => $validated['nomor_hp'],
            'email'                 => $validated['email'],
            'password'              => Hash::make($validated['password']),
            'role'                  => 'customer',
            'foto_ktp'              => $ktpPath,
            'otp_method'            => $validated['otp_method'],
            'email_otp'             => $otp,
            'email_otp_expires_at'  => now()->addMinutes(10),
        ]);

        $otpSent    = false;
        $otpMethod  = $validated['otp_method'];

        if ($otpMethod === 'whatsapp') {
            // Kirim via WhatsApp (Fonnte)
            $nomor = preg_replace('/[^0-9]/', '', $user->nomor_hp);
            if (str_starts_with($nomor, '0')) {
                $nomor = '62' . substr($nomor, 1);
            }
            $pesan  = "Halo {$user->name}, 👋\n\n";
            $pesan .= "Berikut adalah *Kode OTP* verifikasi akun JukungSync Anda:\n\n";
            $pesan .= "🔑 *{$otp}*\n\n";
            $pesan .= "Kode berlaku selama *10 menit*.\n";
            $pesan .= "Jangan bagikan kode ini kepada siapapun.\n\n";
            $pesan .= "_PT Utama Madani Raya – JukungSync_";
            try {
                $otpSent = \App\Services\FonnteService::sendMessage($nomor, $pesan);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal kirim OTP via WA: ' . $e->getMessage());
            }
        } else {
            // Kirim via Email
            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\OtpMail($otp, $user));
                $otpSent = true;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal mengirim email OTP: ' . $e->getMessage());
            }
        }

        // Simpan info ke session untuk halaman verifikasi OTP
        session([
            'otp_email'     => $user->email,
            'otp_method'    => $otpMethod,
            'otp_target'    => $otpMethod === 'whatsapp' ? $user->nomor_hp : $user->email,
        ]);

        $successMsg = $otpSent
            ? ($otpMethod === 'whatsapp'
                ? 'Pendaftaran berhasil! Kode OTP telah dikirim ke WhatsApp Anda.'
                : 'Pendaftaran berhasil! Kode OTP telah dikirim ke email Anda.')
            : 'Pendaftaran berhasil! Jika OTP belum diterima, gunakan tombol Kirim Ulang.';

        return redirect()->route('verify.otp')->with('success', $successMsg);
    }


    /**
     * Proses pengecekan kredensial login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            
            // Periksa jika user belum verifikasi OTP (khusus role customer)
            if ($user->role === 'customer' && is_null($user->email_verified_at)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                // Set session email kembali untuk OTP
                session(['otp_email' => $user->email]);
                
                return redirect()->route('verify.otp')->with('error', 'MODE TESTING: Akun belum diverifikasi. Kode OTP Anda adalah ' . $user->email_otp . '. Silakan masukkan kode tersebut.');
            }

            $request->session()->regenerate();

            // Redirect ke halaman sesuai role
            return $this->redirectByRole();
        }

        return back()->withErrors([
            'email' => 'Email atau Password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Akhiri sesi (Logout)
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }


    /**
     * Tampilkan halaman verifikasi OTP
     */
    public function showVerifyOtp()
    {
        if (!session('otp_email')) {
            return redirect()->route('login');
        }
        return view('auth.verify-otp');
    }

    /**
     * Proses verifikasi kode OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|max:10',
        ]);

        $email = session('otp_email');
        if (!$email) {
            return redirect()->route('login')->with('error', 'Sesi verifikasi kadaluarsa. Silakan login kembali.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('register')->with('error', 'Pengguna tidak ditemukan.');
        }

        // Normalisasi: hapus spasi, strip karakter bukan angka, pastikan 6 digit (dengan leading zero)
        $inputOtp  = trim($request->otp);
        $inputOtp  = preg_replace('/[^0-9]/', '', $inputOtp);
        // Pad leading zeros jika kurang dari 6 digit (misal input '054321' terbaca sebagai '54321')
        $inputOtp  = str_pad($inputOtp, 6, '0', STR_PAD_LEFT);

        $storedOtp = trim((string) $user->email_otp);
        $storedOtp = str_pad($storedOtp, 6, '0', STR_PAD_LEFT);

        // Cek masa berlaku dulu
        if (now()->gt($user->email_otp_expires_at)) {
            return back()->with('error', 'Kode OTP telah kadaluarsa. Silakan klik Kirim Ulang untuk mendapatkan kode baru.');
        }

        // Cek kecocokan kode
        if ($inputOtp !== $storedOtp) {
            return back()->with('error', 'Kode OTP yang Anda masukkan salah. Periksa kembali email Anda.');
        }

        // Verifikasi sukses — tandai akun sebagai verified
        $user->email_verified_at  = now();
        $user->email_otp          = null;
        $user->email_otp_expires_at = null;
        $user->save();

        session()->forget('otp_email');

        // Auto-login setelah verifikasi berhasil
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('catalog.index')->with('success', 'Email berhasil diverifikasi! Selamat datang di E-Catalog PT Utama Madani Raya.');
    }

    /**
     * Kirim ulang kode OTP
     */
    public function resendOtp()
    {
        $email = session('otp_email');
        if (!$email) {
            return redirect()->route('login')->with('error', 'Sesi kadaluarsa. Silakan login kembali.');
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return back()->with('error', 'Pengguna tidak ditemukan.');
        }

        $otp = sprintf('%06d', mt_rand(100000, 999999));
        $user->email_otp = $otp;
        $user->email_otp_expires_at = now()->addMinutes(10);
        $user->save();

        $otpMethod = session('otp_method', $user->otp_method ?? 'email');

        if ($otpMethod === 'whatsapp') {
            $nomor = preg_replace('/[^0-9]/', '', $user->nomor_hp);
            if (str_starts_with($nomor, '0')) {
                $nomor = '62' . substr($nomor, 1);
            }
            $pesan  = "Halo {$user->name}, 👋\n\n";
            $pesan .= "Berikut adalah *Kode OTP baru* verifikasi akun JukungSync Anda:\n\n";
            $pesan .= "🔑 *{$otp}*\n\n";
            $pesan .= "Kode berlaku selama *10 menit*.\n";
            $pesan .= "Jangan bagikan kode ini kepada siapapun.\n\n";
            $pesan .= "_PT Utama Madani Raya – JukungSync_";
            try {
                \App\Services\FonnteService::sendMessage($nomor, $pesan);
                return back()->with('success', 'Kode OTP baru telah dikirim ke WhatsApp Anda.');
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal kirim ulang OTP via WA: ' . $e->getMessage());
                return back()->with('error', 'Gagal mengirim OTP via WhatsApp. Coba lagi atau pilih metode email.');
            }
        } else {
            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\OtpMail($otp, $user));
                return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal mengirim ulang email OTP: ' . $e->getMessage());
                return back()->with('error', 'Gagal mengirim email. Pastikan koneksi dan pengaturan email benar.');
            }
        }
    }
}
