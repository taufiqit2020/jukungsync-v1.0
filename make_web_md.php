<?php
$content = file_get_contents('routes/web.php');
$md = "```php\n" . $content . "\n```";
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/web_php_terbaru.md', $md);
