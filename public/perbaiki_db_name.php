<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$laravelRoot = dirname(__DIR__);
$envPath = $laravelRoot . '/.env';

// Read current .env values
$dbHost = '127.0.0.1';
$dbPort = '3306';
$dbName = '';
$dbUser = '';
$dbPass = '';

if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    $lines = explode("\n", $envContent);
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $val) = explode('=', $line, 2);
            $key = trim($key);
            $val = trim($val, "\"' ");
            if ($key === 'DB_HOST') $dbHost = $val;
            if ($key === 'DB_PORT') $dbPort = $val;
            if ($key === 'DB_DATABASE') $dbName = $val;
            if ($key === 'DB_USERNAME') $dbUser = $val;
            if ($key === 'DB_PASSWORD') $dbPass = $val;
        }
    }
}

// Handle form submission for testing or saving
$testResult = null;
$testSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $inputHost = trim($_POST['host'] ?? '');
    $inputPort = trim($_POST['port'] ?? '');
    $inputName = trim($_POST['database'] ?? '');
    $inputUser = trim($_POST['username'] ?? '');
    $inputPass = $_POST['password'] ?? '';
    
    // Test connection
    try {
        $dsn = "mysql:host=$inputHost;port=$inputPort;dbname=$inputName;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_TIMEOUT => 4,
        ];
        $pdo = new PDO($dsn, $inputUser, $inputPass, $options);
        $testSuccess = true;
        $testResult = "✔ KONEKSI BERHASIL! Database '$inputName' berhasil diakses.";
        
        if ($action === 'save') {
            // Update .env file
            if (file_exists($envPath)) {
                $envContent = file_get_contents($envPath);
                
                $keysToReplace = [
                    'DB_HOST' => $inputHost,
                    'DB_PORT' => $inputPort,
                    'DB_DATABASE' => $inputName,
                    'DB_USERNAME' => $inputUser,
                    'DB_PASSWORD' => $inputPass,
                ];
                
                foreach ($keysToReplace as $key => $val) {
                    if (preg_match("/^$key=.*/m", $envContent)) {
                        $envContent = preg_replace("/^$key=.*/m", "$key=$val", $envContent);
                    } else {
                        $envContent .= "\n$key=$val";
                    }
                }
                
                if (file_put_contents($envPath, $envContent) !== false) {
                    $saveMessage = "✔ Berhasil menyimpan konfigurasi ke file .env!<br>";
                    
                    // Hapus cache konfigurasi
                    $configCache = $laravelRoot . '/bootstrap/cache/config.php';
                    if (file_exists($configCache)) {
                        @unlink($configCache);
                        $saveMessage .= "✔ Cache konfigurasi (bootstrap/cache/config.php) berhasil dihapus!<br>";
                    }
                    $routeCache = $laravelRoot . '/bootstrap/cache/routes-v7.php';
                    if (file_exists($routeCache)) {
                        @unlink($routeCache);
                    }
                    
                    // Hapus script ini demi keamanan
                    @unlink(__FILE__);
                    
                    echo "<!DOCTYPE html><html><head><title>Sukses</title><style>body { font-family: sans-serif; background: #f3f4f6; margin-top: 100px; text-align: center; }</style></head><body>";
                    echo "<div style='background:white; padding: 40px; border-radius:8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width:600px; margin: 0 auto; border-top: 5px solid #16a34a;'>";
                    echo "<h2 style='color: #16a34a;'>✔ Pengaturan Berhasil Disimpan!</h2>";
                    echo "<p style='color: #4b5563; font-size: 15px;'>$saveMessage</p>";
                    echo "<div style='margin-top: 25px;'><a href='jalankan_migrasi_direk.php' style='display:inline-block; background: #16a34a; color: white; padding: 12px 25px; border-radius:4px; font-weight:bold; text-decoration:none;'>👉 Langkah Selanjutnya: Jalankan Migrasi Database</a></div>";
                    echo "</div></body></html>";
                    exit;
                } else {
                    $testResult = "❌ Gagal menulis ke file .env. Periksa izin akses file.";
                    $testSuccess = false;
                }
            } else {
                $testResult = "❌ File .env tidak ditemukan.";
                $testSuccess = false;
            }
        }
    } catch (PDOException $e) {
        $testSuccess = false;
        $testResult = "❌ KONEKSI GAGAL: " . $e->getMessage();
    }
    
    // Maintain input values
    $dbHost = $inputHost;
    $dbPort = $inputPort;
    $dbName = $inputName;
    $dbUser = $inputUser;
    $dbPass = $inputPass;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Uji Koneksi & Konfigurasi Database JukungSync</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f3f4f6; color: #1f2937; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 40px auto; background: white; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); overflow: hidden; border-top: 5px solid #2563eb; }
        .header { padding: 20px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; }
        .header h2 { margin: 0; color: #1e3a8a; font-size: 20px; }
        .header p { margin: 5px 0 0 0; color: #64748b; font-size: 13px; }
        .body { padding: 25px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; font-size: 14px; color: #475569; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box; font-size: 14px; font-family: monospace; }
        .form-group input:focus { border-color: #2563eb; outline: none; }
        .alert { padding: 15px; border-radius: 4px; margin-bottom: 20px; font-size: 14px; line-height: 1.5; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; }
        .alert-danger { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; word-break: break-all; }
        .btn { display: inline-block; background: #2563eb; color: white; border: none; padding: 12px 20px; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 14px; width: 100%; text-align: center; }
        .btn:hover { background: #1d4ed8; }
        .btn-success { background: #16a34a; margin-top: 10px; }
        .btn-success:hover { background: #15803d; }
        .tips { margin-top: 20px; background: #f8fafc; padding: 15px; border-radius: 4px; font-size: 13px; color: #475569; border-left: 3px solid #64748b; }
        .tips ul { margin: 5px 0 0 0; padding-left: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Uji Koneksi & Perbaikan Database</h2>
            <p>Gunakan form ini untuk mencoba kredensial database sampai berhasil terhubung.</p>
        </div>
        <div class="body">
            <?php if ($testResult): ?>
                <div class="alert <?php echo $testSuccess ? 'alert-success' : 'alert-danger'; ?>">
                    <?php echo $testResult; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>DB HOST</label>
                    <input type="text" name="host" value="<?php echo htmlspecialchars($dbHost); ?>" required placeholder="localhost atau 127.0.0.1">
                </div>
                <div class="form-group">
                    <label>DB PORT</label>
                    <input type="text" name="port" value="<?php echo htmlspecialchars($dbPort); ?>" required>
                </div>
                <div class="form-group">
                    <label>NAMA DATABASE</label>
                    <input type="text" name="database" value="<?php echo htmlspecialchars($dbName); ?>" required placeholder="u169145000_xxxx">
                </div>
                <div class="form-group">
                    <label>USERNAME DATABASE</label>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($dbUser); ?>" required placeholder="u169145000_xxxx">
                </div>
                <div class="form-group">
                    <label>PASSWORD DATABASE</label>
                    <input type="password" name="password" value="<?php echo htmlspecialchars($dbPass); ?>" placeholder="Masukkan password database">
                </div>

                <input type="hidden" name="action" id="action-input" value="test">
                <button type="submit" class="btn" onclick="document.getElementById('action-input').value='test';">Uji Koneksi Database</button>

                <?php if ($testSuccess): ?>
                    <button type="submit" class="btn btn-success" onclick="document.getElementById('action-input').value='save';">✔ Simpan Konfigurasi ke .env</button>
                <?php endif; ?>
            </form>

            <div class="tips">
                <strong>Tips Mengatasi Access Denied (1045):</strong>
                <ul>
                    <li>Coba ubah <b>DB HOST</b> dari <code>127.0.0.1</code> menjadi <code>localhost</code> (atau sebaliknya).</li>
                    <li>Pastikan Anda sudah mengasosiasikan user <code>u169145000_ptumar</code> ke database <code>u169145000_jukungsync1</code> di menu <b>MySQL Databases</b> Hostinger Anda.</li>
                    <li>Pastikan password database yang dimasukkan benar dan sesuai dengan password user tersebut di Hostinger.</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
