<?php
$dir = 'C:/Users/USER/.gemini/antigravity/scratch/JukungSync-V1.1/resources/views/reports';
$files = glob($dir . '/print*.blade.php');

$search = 'class="border-b border-black font-bold uppercase pb-1 text-sm whitespace-nowrap"';
$replace = 'class="border-b border-black font-bold pb-1 text-sm whitespace-nowrap"';

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
