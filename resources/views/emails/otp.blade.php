<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Anda</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f5; padding: 20px;">
    <div style="max-width: 500px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h2 style="color: #991b1b; text-align: center; margin-bottom: 20px;">JukungSync E-Catalog</h2>
        <p style="color: #374151; font-size: 16px;">Halo <strong>{{ $user->name }}</strong>,</p>
        <p style="color: #374151; font-size: 16px;">Terima kasih telah mendaftar. Untuk memverifikasi alamat email Anda dan mengaktifkan akun, silakan gunakan kode rahasia 6 digit di bawah ini:</p>
        
        <div style="background-color: #f3f4f6; padding: 15px; text-align: center; border-radius: 6px; margin: 25px 0;">
            <h1 style="margin: 0; font-size: 32px; letter-spacing: 5px; color: #111827;">{{ $otp }}</h1>
        </div>

        <p style="color: #6b7280; font-size: 14px;">Kode ini hanya berlaku selama 10 menit. Jika Anda tidak merasa mendaftar di sistem kami, abaikan email ini.</p>
        
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; text-align: center;">
            <p style="color: #9ca3af; font-size: 12px;">&copy; {{ date('Y') }} PT. Utama Madani Raya. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
