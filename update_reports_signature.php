<?php
$dir = 'C:/Users/USER/.gemini/antigravity/scratch/JukungSync-V1.1/resources/views/reports';
$files = glob($dir . '/*.blade.php');

$search = '<p class="mb-20 text-sm font-bold capitalize">Mengetahui {{ ucwords(str_replace(\'_\', \' \', auth()->user()->role ?? \'Pimpinan\')) }},</p>';
$replace = '<p class="mb-20 text-sm font-bold {{ auth()->user()->role === \'bendahara\' ? \'uppercase\' : \'capitalize\' }}">Mengetahui {{ auth()->user()->role === \'bendahara\' ? \'KEPALA ADMINISTRASI DAN KEUANGAN\' : ucwords(str_replace(\'_\', \' \', auth()->user()->role ?? \'Pimpinan\')) }},</p>';

foreach ($files as $file) {
    $content = file_get_contents($file);
    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
        file_put_contents($file, $content);
        echo "Updated $file\n";
    } else {
        echo "Not found in $file\n";
    }
}
