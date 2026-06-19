<?php

$files = glob('resources/views/reports/print*.blade.php');
foreach($files as $file) {
    $content = file_get_contents($file);
    // There are 2 possible newline formats
    $search1 = '<p class="mb-20 text-sm font-bold">Mengetahui, Pimpinan</p>' . "\n" . '            <p class="border-b border-black font-bold uppercase pb-1 text-sm whitespace-nowrap">HJ. NORMAULIDA, SH</p>';
    $search2 = '<p class="mb-20 text-sm font-bold">Mengetahui, Pimpinan</p>' . "\r\n" . '            <p class="border-b border-black font-bold uppercase pb-1 text-sm whitespace-nowrap">HJ. NORMAULIDA, SH</p>';
    $search3 = '<p class="mb-20 text-sm font-bold">Mengetahui, Pimpinan</p>' . "\n" . '            <p class="border-b border-black font-bold uppercase pb-1 text-sm whitespace-nowrap">Hj. NORMAULIDA, SH</p>';
    $search4 = '<p class="mb-20 text-sm font-bold">Mengetahui, Pimpinan</p>' . "\r\n" . '            <p class="border-b border-black font-bold uppercase pb-1 text-sm whitespace-nowrap">Hj. NORMAULIDA, SH</p>';

    $replace = '<p class="mb-20 text-sm font-bold capitalize">Mengetahui, {{ str_replace(\'_\', \' \', auth()->user()->role ?? \'Pimpinan\') }}</p>' . "\n" . '            <p class="border-b border-black font-bold uppercase pb-1 text-sm whitespace-nowrap">{{ auth()->user()->name ?? \'HJ. NORMAULIDA, SH\' }}</p>';
    
    $content = str_replace($search1, $replace, $content);
    $content = str_replace($search2, $replace, $content);
    $content = str_replace($search3, $replace, $content);
    $content = str_replace($search4, $replace, $content);

    // Some might have different indentation or different name format. Let's do a regex replace to be robust.
    $content = preg_replace(
        '/<p class="mb-20 text-sm font-bold">Mengetahui, Pimpinan<\/p>\s*<p class="border-b border-black font-bold uppercase pb-1 text-sm whitespace-nowrap">HJ\. NORMAULIDA, SH<\/p>/i',
        $replace,
        $content
    );

    file_put_contents($file, $content);
    echo "Replaced in $file\n";
}
