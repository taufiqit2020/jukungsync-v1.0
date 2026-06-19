<?php
$php = file_get_contents('generate_installer_sorting_final.php');
$md = "```php\n" . $php . "\n```";
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_sorting.md', $md);
