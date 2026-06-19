<?php
$content = file_get_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer.php');
$output = "# Script Installer Otomatis\n\nSilakan copy semua kode di bawah ini, lalu simpan sebagai file `update.php` di Hostinger Anda.\n\n```php\n" . $content . "\n```\n";
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_artifact.md', $output);
?>
