<?php
$file = 'routes/web.php';
$content = file_get_contents($file);

// Clean up duplicated use statements
$content = preg_replace('/(use App\\\\Http\\\\Controllers\\\\CustomerController;\s*)+/', "use App\\Http\\Controllers\\CustomerController;\n", $content);

file_put_contents($file, $content);
echo "Routes cleaned.\n";
