# Deploy otomatis ke Hostinger via FTP
param(
    [string]$FtpPassword = ""
)

$ftpHost = "ftp.ptutamamadaniraya.com"
$ftpUser = "u169145000"
$ftpPassword = $FtpPassword
$localFile = "C:\Users\USER\.gemini\antigravity\scratch\JukungSync-V1.1\public\installer_v59.php"
$remoteFile = "installer_v59.php"
$remoteUri = "ftp://$ftpHost/public_html/$remoteFile"

Write-Host "=== Deploy Otomatis ke Hostinger ===" -ForegroundColor Cyan
Write-Host "File  : $localFile" -ForegroundColor Gray
Write-Host "Target: $remoteUri" -ForegroundColor Gray
Write-Host ""

if ([string]::IsNullOrEmpty($ftpPassword)) {
    Write-Host "ERROR: Password FTP belum diisi. Jalankan dengan:" -ForegroundColor Red
    Write-Host "  .\deploy_ftp.ps1 -FtpPassword 'password_anda'" -ForegroundColor Yellow
    exit 1
}

try {
    Write-Host "Mengunggah file installer..." -ForegroundColor Yellow
    $wc = New-Object System.Net.WebClient
    $wc.Credentials = New-Object System.Net.NetworkCredential($ftpUser, $ftpPassword)
    $wc.UploadFile($remoteUri, $localFile)
    Write-Host "✅ Upload berhasil!" -ForegroundColor Green

    Write-Host ""
    Write-Host "Menjalankan installer di server..." -ForegroundColor Yellow
    $response = Invoke-WebRequest -Uri "https://ptutamamadaniraya.com/$remoteFile" -TimeoutSec 30 -UseBasicParsing
    
    if ($response.StatusCode -eq 200) {
        Write-Host "✅ Installer berhasil dijalankan!" -ForegroundColor Green
        Write-Host ""
        Write-Host "Silakan buka: https://ptutamadaniraya.com/products" -ForegroundColor Cyan
    } else {
        Write-Host "⚠️ Installer dijalankan tapi status: $($response.StatusCode)" -ForegroundColor Yellow
    }
} catch {
    Write-Host "❌ Error: $_" -ForegroundColor Red
}
