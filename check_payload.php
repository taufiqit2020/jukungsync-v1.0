<?php
$p = json_decode(base64_decode(file_get_contents('payload_edit.txt')), true);
$web = base64_decode($p['w']);
file_put_contents('test_web.txt', $web);
