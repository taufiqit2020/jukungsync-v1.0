<?php
file_put_contents('payload_print_v3.txt', base64_encode(file_get_contents('resources/views/invoices/show.blade.php')));
