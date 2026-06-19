<?php
$zip = new ZipArchive();
if ($zip->open('update_grosir_dan_invoice_FIXED.zip') === TRUE) {
    for ($i = 0; $i < $zip->numFiles; $i++) {
        echo $zip->getNameIndex($i) . PHP_EOL;
    }
    $zip->close();
} else {
    echo 'Failed to open zip';
}
