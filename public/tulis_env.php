<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$laravelRoot = dirname(__DIR__);
$envPath = $laravelRoot . '/.env';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbPass = $_POST['db_pass'] ?? '';
    
    $envContent = 'APP_NAME=JukungSync
APP_ENV=production
APP_KEY=base64:QADcvI3nUFp4Jud50nbhzydLO6otK4qKEV/rTBqRavc=
APP_DEBUG=false
APP_URL=https://ptutamamadaniraya.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u169145000_jukungsyncv1
DB_USERNAME=u169145000_ptumar
DB_PASSWORD=' . $dbPass . '

SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME="ptutamamadaniraya@gmail.com"
MAIL_PASSWORD="dhje wovz ngji sawd"
MAIL_FROM_ADDRESS="ptutamamadaniraya@gmail.com"
MAIL_FROM_NAME="JukungSync"

FONNTE_TOKEN=cQUCGXHqtDyQFW88CHJx

MIDTRANS_SERVER_KEY="Mid-server-YOUR_SERVER_KEY_HERE"
MIDTRANS_CLIENT_KEY="Mid-client-YOUR_CLIENT_KEY_HERE"
MIDTRANS_IS_PRODUCTION=false
';

    if (file_put_contents($envPath, $envContent) !== false) {
        echo "<div style='font-family:sans-serif;text-align:center;margin-top:100px;'>";
        echo "<h1 style='color:green;'>✔ File .env berhasil dibuat dengan sukses!</h1>";
        echo "<p style='color:#374151;'>Silakan coba buka kembali website Anda: <a href='https://ptutamamadaniraya.com' style='color:#2563eb;font-weight:bold;text-decoration:none;'>https://ptutamamadaniraya.com</a></p>";
        @unlink(__FILE__);
        echo "<p style='color:#9ca3af;font-size:12px;'><i>File script ini (tulis_env.php) telah dihapus secara otomatis demi keamanan.</i></p>";
        echo "</div>";
        exit;
    } else {
        echo "<h1 style='color:red;'>❌ Gagal membuat file .env!</h1>";
        echo "<p>Periksa perizinan folder di: $laravelRoot</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Setup File .env JukungSync</title>
    <style>
        body { font-family: sans-serif; text-align: center; margin-top: 100px; background: #f3f4f6; }
        .card { background: white; padding: 30px; border-radius: 8px; max-width: 400px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        input[type="password"] { width: 100%; padding: 10px; margin: 15px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background: #16a34a; color: white; border: none; padding: 12px 20px; border-radius: 4px; font-weight: bold; cursor: pointer; width: 100%; }
        button:hover { background: #15803d; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Setup File .env</h2>
        <p style="color: #4b5563; font-size: 14px;">Masukkan password database MySQL Anda untuk membuat file konfigurasi secara otomatis.</p>
        <form method="POST">
            <input type="password" name="db_pass" placeholder="Password Database MySQL Anda" required autocomplete="off">
            <button type="submit">Buat File .env Otomatis</button>
        </form>
    </div>
</body>
</html>
