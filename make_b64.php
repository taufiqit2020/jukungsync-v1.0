<?php file_put_contents('b64.txt', base64_encode(file_get_contents('resources/views/invoices/show.blade.php'))); echo "OK";
