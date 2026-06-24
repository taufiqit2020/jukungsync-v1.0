<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function findLaravelRoot($dir, $depth = 0) {
    if ($depth > 3) return null;
    if (!is_dir($dir)) return null;
    if (file_exists($dir . '/artisan') && file_exists($dir . '/bootstrap/app.php')) return $dir;
    $items = @scandir($dir);
    if (!$items) return null;
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . '/' . $item;
        if (is_dir($path)) { $found = findLaravelRoot($path, $depth + 1); if ($found) return $found; }
    }
    return null;
}

$laravelRoot = findLaravelRoot(dirname(__DIR__));
if (!$laravelRoot) $laravelRoot = __DIR__;

try {
    @mkdir(dirname($laravelRoot . '/config/filesystems.php'), 0777, true);
    file_put_contents($laravelRoot . '/config/filesystems.php', base64_decode('PD9waHAKCnJldHVybiBbCgogICAgLyoKICAgIHwtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQogICAgfCBEZWZhdWx0IEZpbGVzeXN0ZW0gRGlzawogICAgfC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiAgICB8CiAgICB8IEhlcmUgeW91IG1heSBzcGVjaWZ5IHRoZSBkZWZhdWx0IGZpbGVzeXN0ZW0gZGlzayB0aGF0IHNob3VsZCBiZSB1c2VkCiAgICB8IGJ5IHRoZSBmcmFtZXdvcmsuIFRoZSAibG9jYWwiIGRpc2ssIGFzIHdlbGwgYXMgYSB2YXJpZXR5IG9mIGNsb3VkCiAgICB8IGJhc2VkIGRpc2tzIGFyZSBhdmFpbGFibGUgdG8geW91ciBhcHBsaWNhdGlvbiBmb3IgZmlsZSBzdG9yYWdlLgogICAgfAogICAgKi8KCiAgICAnZGVmYXVsdCcgPT4gZW52KCdGSUxFU1lTVEVNX0RJU0snLCAnbG9jYWwnKSwKCiAgICAvKgogICAgfC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tCiAgICB8IEZpbGVzeXN0ZW0gRGlza3MKICAgIHwtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQogICAgfAogICAgfCBCZWxvdyB5b3UgbWF5IGNvbmZpZ3VyZSBhcyBtYW55IGZpbGVzeXN0ZW0gZGlza3MgYXMgbmVjZXNzYXJ5LCBhbmQgeW91CiAgICB8IG1heSBldmVuIGNvbmZpZ3VyZSBtdWx0aXBsZSBkaXNrcyBmb3IgdGhlIHNhbWUgZHJpdmVyLiBFeGFtcGxlcyBmb3IKICAgIHwgbW9zdCBzdXBwb3J0ZWQgc3RvcmFnZSBkcml2ZXJzIGFyZSBjb25maWd1cmVkIGhlcmUgZm9yIHJlZmVyZW5jZS4KICAgIHwKICAgIHwgU3VwcG9ydGVkIGRyaXZlcnM6ICJsb2NhbCIsICJmdHAiLCAic2Z0cCIsICJzMyIKICAgIHwKICAgICovCgogICAgJ2Rpc2tzJyA9PiBbCgogICAgICAgICdsb2NhbCcgPT4gWwogICAgICAgICAgICAnZHJpdmVyJyA9PiAnbG9jYWwnLAogICAgICAgICAgICAncm9vdCcgPT4gc3RvcmFnZV9wYXRoKCdhcHAvcHJpdmF0ZScpLAogICAgICAgICAgICAnc2VydmUnID0+IHRydWUsCiAgICAgICAgICAgICd0aHJvdycgPT4gZmFsc2UsCiAgICAgICAgICAgICdyZXBvcnQnID0+IGZhbHNlLAogICAgICAgIF0sCgogICAgICAgICdwdWJsaWMnID0+IFsKICAgICAgICAgICAgJ2RyaXZlcicgPT4gJ2xvY2FsJywKICAgICAgICAgICAgJ3Jvb3QnID0+IHB1YmxpY19wYXRoKCdzdG9yYWdlJyksCiAgICAgICAgICAgICd1cmwnID0+IHJ0cmltKGVudignQVBQX1VSTCcsICdodHRwOi8vbG9jYWxob3N0JyksICcvJykuJy9zdG9yYWdlJywKICAgICAgICAgICAgJ3Zpc2liaWxpdHknID0+ICdwdWJsaWMnLAogICAgICAgICAgICAndGhyb3cnID0+IGZhbHNlLAogICAgICAgICAgICAncmVwb3J0JyA9PiBmYWxzZSwKICAgICAgICBdLAoKICAgICAgICAnczMnID0+IFsKICAgICAgICAgICAgJ2RyaXZlcicgPT4gJ3MzJywKICAgICAgICAgICAgJ2tleScgPT4gZW52KCdBV1NfQUNDRVNTX0tFWV9JRCcpLAogICAgICAgICAgICAnc2VjcmV0JyA9PiBlbnYoJ0FXU19TRUNSRVRfQUNDRVNTX0tFWScpLAogICAgICAgICAgICAncmVnaW9uJyA9PiBlbnYoJ0FXU19ERUZBVUxUX1JFR0lPTicpLAogICAgICAgICAgICAnYnVja2V0JyA9PiBlbnYoJ0FXU19CVUNLRVQnKSwKICAgICAgICAgICAgJ3VybCcgPT4gZW52KCdBV1NfVVJMJyksCiAgICAgICAgICAgICdlbmRwb2ludCcgPT4gZW52KCdBV1NfRU5EUE9JTlQnKSwKICAgICAgICAgICAgJ3VzZV9wYXRoX3N0eWxlX2VuZHBvaW50JyA9PiBlbnYoJ0FXU19VU0VfUEFUSF9TVFlMRV9FTkRQT0lOVCcsIGZhbHNlKSwKICAgICAgICAgICAgJ3Rocm93JyA9PiBmYWxzZSwKICAgICAgICAgICAgJ3JlcG9ydCcgPT4gZmFsc2UsCiAgICAgICAgXSwKCiAgICBdLAoKICAgIC8qCiAgICB8LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KICAgIHwgU3ltYm9saWMgTGlua3MKICAgIHwtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQogICAgfAogICAgfCBIZXJlIHlvdSBtYXkgY29uZmlndXJlIHRoZSBzeW1ib2xpYyBsaW5rcyB0aGF0IHdpbGwgYmUgY3JlYXRlZCB3aGVuIHRoZQogICAgfCBgc3RvcmFnZTpsaW5rYCBBcnRpc2FuIGNvbW1hbmQgaXMgZXhlY3V0ZWQuIFRoZSBhcnJheSBrZXlzIHNob3VsZCBiZQogICAgfCB0aGUgbG9jYXRpb25zIG9mIHRoZSBsaW5rcyBhbmQgdGhlIHZhbHVlcyBzaG91bGQgYmUgdGhlaXIgdGFyZ2V0cy4KICAgIHwKICAgICovCgogICAgJ2xpbmtzJyA9PiBbCiAgICAgICAgcHVibGljX3BhdGgoJ3N0b3JhZ2UnKSA9PiBzdG9yYWdlX3BhdGgoJ2FwcC9wdWJsaWMnKSwKICAgIF0sCgpdOwo='));
    @mkdir(dirname($laravelRoot . '/public/perbaiki_storage_link.php'), 0777, true);
    file_put_contents($laravelRoot . '/public/perbaiki_storage_link.php', base64_decode('PD9waHAKaW5pX3NldCgnZGlzcGxheV9lcnJvcnMnLCAxKTsKaW5pX3NldCgnZGlzcGxheV9zdGFydHVwX2Vycm9ycycsIDEpOwplcnJvcl9yZXBvcnRpbmcoRV9BTEwpOwoKJGxhcmF2ZWxSb290ID0gZGlybmFtZShfX0RJUl9fKTsKJHB1YmxpY1N0b3JhZ2VQYXRoID0gX19ESVJfXyAuICcvc3RvcmFnZSc7CiR0YXJnZXRTdG9yYWdlUGF0aCA9ICRsYXJhdmVsUm9vdCAuICcvc3RvcmFnZS9hcHAvcHVibGljJzsKCmVjaG8gIjxoMT5QZXJiYWlrYW4gTWVkaWEgU3RvcmFnZSBKdWt1bmdTeW5jIChUYW5wYSBTeW1saW5rKTwvaDE+IjsKZWNobyAiTGFyYXZlbCBSb290OiAiIC4gaHRtbHNwZWNpYWxjaGFycygkbGFyYXZlbFJvb3QpIC4gIjxicj4iOwplY2hvICJQdWJsaWMgU3RvcmFnZSBQYXRoOiAiIC4gaHRtbHNwZWNpYWxjaGFycygkcHVibGljU3RvcmFnZVBhdGgpIC4gIjxicj4iOwplY2hvICJUYXJnZXQgU3RvcmFnZSBQYXRoOiAiIC4gaHRtbHNwZWNpYWxjaGFycygkdGFyZ2V0U3RvcmFnZVBhdGgpIC4gIjxicj48YnI+IjsKCi8vIDEuIEppa2EgcHVibGljL3N0b3JhZ2UgYWRhbGFoIHN5bWxpbmsgKGJhaWsgYWt0aWYgbWF1cHVuIGJyb2tlbiksIGhhcHVzCmlmIChpc19saW5rKCRwdWJsaWNTdG9yYWdlUGF0aCkpIHsKICAgIGVjaG8gIk1lbmdoYXB1cyBzeW1ib2xpYyBsaW5rIGxhbWEgeWFuZyBiZXJtYXNhbGFoLi4uPGJyPiI7CiAgICBpZiAoQHVubGluaygkcHVibGljU3RvcmFnZVBhdGgpKSB7CiAgICAgICAgZWNobyAi4pyUIFN5bWJvbGljIGxpbmsgYmVyaGFzaWwgZGloYXB1cy48YnI+IjsKICAgIH0gZWxzZSB7CiAgICAgICAgZWNobyAi4p2MIEdhZ2FsIG1lbmdoYXB1cyBzeW1ib2xpYyBsaW5rITxicj4iOwogICAgfQp9CgovLyAyLiBCdWF0IGRpcmVrdG9yaSBmaXNpayBwdWJsaWMvc3RvcmFnZSBqaWthIGJlbHVtIGFkYQppZiAoIWlzX2RpcigkcHVibGljU3RvcmFnZVBhdGgpKSB7CiAgICBlY2hvICJNZW1idWF0IGRpcmVrdG9yaSBmaXNpayBwdWJsaWMvc3RvcmFnZS4uLjxicj4iOwogICAgaWYgKEBta2RpcigkcHVibGljU3RvcmFnZVBhdGgsIDA3NzcsIHRydWUpKSB7CiAgICAgICAgZWNobyAi4pyUIERpcmVrdG9yaSBmaXNpayBwdWJsaWMvc3RvcmFnZSBiZXJoYXNpbCBkaWJ1YXQuPGJyPiI7CiAgICB9IGVsc2UgewogICAgICAgIGVjaG8gIuKdjCBHYWdhbCBtZW1idWF0IGRpcmVrdG9yaSBmaXNpayBwdWJsaWMvc3RvcmFnZSE8YnI+IjsKICAgIH0KfSBlbHNlIHsKICAgIGVjaG8gIuKclCBEaXJla3RvcmkgZmlzaWsgcHVibGljL3N0b3JhZ2Ugc3VkYWggYWRhLjxicj4iOwp9CgovLyAzLiBCdWF0IHN1YmZvbGRlciB5YW5nIGRpYnV0dWhrYW4KJHN1YmZvbGRlcnMgPSBbJ3Byb2R1Y3RzJywgJ2J1a3RpX2ludm9pY2VzJ107CmZvcmVhY2ggKCRzdWJmb2xkZXJzIGFzICRzdWIpIHsKICAgICRzdWJQYXRoID0gJHB1YmxpY1N0b3JhZ2VQYXRoIC4gJy8nIC4gJHN1YjsKICAgIGlmICghaXNfZGlyKCRzdWJQYXRoKSkgewogICAgICAgIGlmIChAbWtkaXIoJHN1YlBhdGgsIDA3NzcsIHRydWUpKSB7CiAgICAgICAgICAgIGVjaG8gIuKclCBTdWJmb2xkZXIgJyRzdWInIGJlcmhhc2lsIGRpYnVhdC48YnI+IjsKICAgICAgICB9IGVsc2UgewogICAgICAgICAgICBlY2hvICLinYwgR2FnYWwgbWVtYnVhdCBzdWJmb2xkZXIgJyRzdWInITxicj4iOwogICAgICAgIH0KICAgIH0KfQoKLy8gNC4gU2FsaW4gZmlsZSBkYXJpIHN0b3JhZ2UvYXBwL3B1YmxpYyBrZSBwdWJsaWMvc3RvcmFnZSBzZWNhcmEgcmVrdXJzaWYKZnVuY3Rpb24gY29weUZvbGRlcigkc3JjLCAkZHN0KSB7CiAgICBpZiAoIWlzX2Rpcigkc3JjKSkgcmV0dXJuOwogICAgQG1rZGlyKCRkc3QsIDA3NzcsIHRydWUpOwogICAgJGZpbGVzID0gYXJyYXlfZGlmZihzY2FuZGlyKCRzcmMpLCBhcnJheSgnLicsJy4uJykpOwogICAgZm9yZWFjaCAoJGZpbGVzIGFzICRmaWxlKSB7CiAgICAgICAgaWYgKGlzX2RpcigiJHNyYy8kZmlsZSIpKSB7CiAgICAgICAgICAgIGNvcHlGb2xkZXIoIiRzcmMvJGZpbGUiLCAiJGRzdC8kZmlsZSIpOwogICAgICAgIH0gZWxzZSB7CiAgICAgICAgICAgIGlmIChAY29weSgiJHNyYy8kZmlsZSIsICIkZHN0LyRmaWxlIikpIHsKICAgICAgICAgICAgICAgIGVjaG8gIuKclCBNZW55YWxpbjogIiAuIGh0bWxzcGVjaWFsY2hhcnMoIiRmaWxlIikgLiAiIGtlIHB1YmxpYy9zdG9yYWdlPGJyPiI7CiAgICAgICAgICAgIH0gZWxzZSB7CiAgICAgICAgICAgICAgICBlY2hvICLinYwgR2FnYWwgbWVueWFsaW46ICIgLiBodG1sc3BlY2lhbGNoYXJzKCIkZmlsZSIpIC4gIjxicj4iOwogICAgICAgICAgICB9CiAgICAgICAgfQogICAgfQp9CgplY2hvICI8YnI+PGI+TWVueWFsaW4gZmlsZSBhc2V0IGxhbWEuLi48L2I+PGJyPiI7CmNvcHlGb2xkZXIoJHRhcmdldFN0b3JhZ2VQYXRoLCAkcHVibGljU3RvcmFnZVBhdGgpOwoKZWNobyAiPGJyPjxoMyBzdHlsZT0nY29sb3I6Z3JlZW47Jz7inJQgU0VMRVNBSTogUGVueWltcGFuYW4gZmlzaWsgbWVkaWEgYmVyaGFzaWwgZGlzaWFwa2FuIHRhbnBhIGtlbmRhbGEgc3ltbGluayE8L2gzPiI7Cj8+Cg=='));
    @mkdir(dirname($laravelRoot . '/public/cek_gambar_produksi.php'), 0777, true);
    file_put_contents($laravelRoot . '/public/cek_gambar_produksi.php', base64_decode('PD9waHAKaW5pX3NldCgnZGlzcGxheV9lcnJvcnMnLCAxKTsKaW5pX3NldCgnZGlzcGxheV9zdGFydHVwX2Vycm9ycycsIDEpOwplcnJvcl9yZXBvcnRpbmcoRV9BTEwpOwoKJGxhcmF2ZWxSb290ID0gZGlybmFtZShfX0RJUl9fKTsKcmVxdWlyZSAkbGFyYXZlbFJvb3QgLiAnL3ZlbmRvci9hdXRvbG9hZC5waHAnOwokYXBwID0gcmVxdWlyZV9vbmNlICRsYXJhdmVsUm9vdCAuICcvYm9vdHN0cmFwL2FwcC5waHAnOwokYXBwLT5tYWtlKCdJbGx1bWluYXRlXENvbnRyYWN0c1xDb25zb2xlXEtlcm5lbCcpLT5ib290c3RyYXAoKTsKCnVzZSBBcHBcTW9kZWxzXFByb2R1Y3Q7CnVzZSBJbGx1bWluYXRlXFN1cHBvcnRcRmFjYWRlc1xTdG9yYWdlOwoKZWNobyAiPGgxPkRpYWdub3N0aWsgR2FtYmFyIFByb2R1a3NpPC9oMT4iOwoKdHJ5IHsKICAgICRwcm9kdWN0cyA9IFByb2R1Y3Q6OmxpbWl0KDQ1KS0+Z2V0KCk7CiAgICBlY2hvICI8dGFibGUgYm9yZGVyPScxJyBjZWxscGFkZGluZz0nNScgc3R5bGU9J2JvcmRlci1jb2xsYXBzZTpjb2xsYXBzZTtmb250LWZhbWlseTpzYW5zLXNlcmlmO2ZvbnQtc2l6ZToxMnB4Oyc+IjsKICAgIGVjaG8gIjx0ciBzdHlsZT0nYmFja2dyb3VuZDojZWVlOyc+PHRoPlNLVTwvdGg+PHRoPk5hbWEgQmFyYW5nPC90aD48dGg+REIgR2FtYmFyPC90aD48dGg+U3RvcmFnZSBVUkw8L3RoPjx0aD5QaHlzaWNhbCBQYXRoPC90aD48dGg+RXhpc3RzPzwvdGg+PHRoPkFsdGVybmF0ZSAocHVibGljL2ltZy9wcm9kdWN0cykgRXhpc3RzPzwvdGg+PC90cj4iOwogICAgCiAgICBmb3JlYWNoICgkcHJvZHVjdHMgYXMgJHApIHsKICAgICAgICAkZGJHYW1iYXIgPSAkcC0+Z2FtYmFyOwogICAgICAgICR1cmwgPSBTdG9yYWdlOjp1cmwoJGRiR2FtYmFyKTsKICAgICAgICAkcGh5c2ljYWxQYXRoID0gcHVibGljX3BhdGgoJ3N0b3JhZ2UvJyAuICRkYkdhbWJhcik7CiAgICAgICAgJGV4aXN0cyA9IGZpbGVfZXhpc3RzKCRwaHlzaWNhbFBhdGgpID8gIuKclCBZRVMiIDogIuKdjCBOTyI7CiAgICAgICAgCiAgICAgICAgLy8gQ2VrIGppa2EgYWRhIGRpIHB1YmxpYy9pbWcvcHJvZHVjdHMKICAgICAgICAkYWx0RmlsZW5hbWUgPSBiYXNlbmFtZSgkZGJHYW1iYXIpOwogICAgICAgICRhbHRQYXRoID0gcHVibGljX3BhdGgoJ2ltZy9wcm9kdWN0cy8nIC4gJGFsdEZpbGVuYW1lKTsKICAgICAgICAkYWx0RXhpc3RzID0gZmlsZV9leGlzdHMoJGFsdFBhdGgpID8gIuKclCBZRVMiIDogIuKdjCBOTyI7CiAgICAgICAgCiAgICAgICAgZWNobyAiPHRyPiI7CiAgICAgICAgZWNobyAiPHRkPiIgLiBodG1sc3BlY2lhbGNoYXJzKCRwLT5za3UpIC4gIjwvdGQ+IjsKICAgICAgICBlY2hvICI8dGQ+IiAuIGh0bWxzcGVjaWFsY2hhcnMoJHAtPm5hbWFfYmFyYW5nKSAuICI8L3RkPiI7CiAgICAgICAgZWNobyAiPHRkPiIgLiBodG1sc3BlY2lhbGNoYXJzKCRkYkdhbWJhcikgLiAiPC90ZD4iOwogICAgICAgIGVjaG8gIjx0ZD4iIC4gaHRtbHNwZWNpYWxjaGFycygkdXJsKSAuICI8L3RkPiI7CiAgICAgICAgZWNobyAiPHRkIHN0eWxlPSdmb250LWZhbWlseTptb25vc3BhY2U7Jz4iIC4gaHRtbHNwZWNpYWxjaGFycygkcGh5c2ljYWxQYXRoKSAuICI8L3RkPiI7CiAgICAgICAgZWNobyAiPHRkIHN0eWxlPSdmb250LXdlaWdodDpib2xkO2NvbG9yOiIgLiAoJGV4aXN0cyA9PT0gIuKclCBZRVMiID8gImdyZWVuIiA6ICJyZWQiKSAuICInPiIgLiAkZXhpc3RzIC4gIjwvdGQ+IjsKICAgICAgICBlY2hvICI8dGQgc3R5bGU9J2ZvbnQtd2VpZ2h0OmJvbGQ7Y29sb3I6IiAuICgkYWx0RXhpc3RzID09PSAi4pyUIFlFUyIgPyAiZ3JlZW4iIDogInJlZCIpIC4gIic+IiAuICRhbHRFeGlzdHMgLiAiPC90ZD4iOwogICAgICAgIGVjaG8gIjwvdHI+IjsKICAgIH0KICAgIGVjaG8gIjwvdGFibGU+IjsKfSBjYXRjaCAoRXhjZXB0aW9uICRlKSB7CiAgICBlY2hvICJFcnJvcjogIiAuICRlLT5nZXRNZXNzYWdlKCk7Cn0KPz4K'));

    // --- LOGIC PERBAIKAN STORAGE LINK OTOMATIS (FISIK - TANPA SYMLINK) ---
    $publicStoragePath = $laravelRoot . '/public/storage';
    $targetStoragePath = $laravelRoot . '/storage/app/public';
    $log = '';

    if (is_link($publicStoragePath)) {
        @unlink($publicStoragePath);
        $log .= '✔ Symbolic link lama dihapus.\n';
    }

    if (!is_dir($publicStoragePath)) {
        if (@mkdir($publicStoragePath, 0777, true)) {
            $log .= '✔ Direktori fisik public/storage dibuat.\n';
        } else {
            $log .= '❌ Gagal membuat direktori fisik public/storage.\n';
        }
    }

    // Buat subfolder
    foreach (['products', 'bukti_invoices'] as $sub) {
        $subPath = $publicStoragePath . '/' . $sub;
        if (!is_dir($subPath)) {
            @mkdir($subPath, 0777, true);
        }
    }

    // Salin file secara rekursif
    function copyFolderRecursive($src, $dst) {
        if (!is_dir($src)) return 0;
        @mkdir($dst, 0777, true);
        $count = 0;
        $files = array_diff(scandir($src), array('.','..'));
        foreach ($files as $file) {
            if (is_dir("$src/$file")) {
                $count += copyFolderRecursive("$src/$file", "$dst/$file");
            } else {
                if (@copy("$src/$file", "$dst/$file")) {
                    $count++;
                }
            }
        }
        return $count;
    }

    // 1. Salin file dari folder storage/app/public
    $copiedCount = copyFolderRecursive($targetStoragePath, $publicStoragePath);
    $log .= '✔ Berhasil menyalin ' . $copiedCount . ' file media dari folder storage.\n';

    // 2. Salin file seeder dari folder public/img/products ke public/storage/products
    $imgProductsPath = $laravelRoot . '/public/img/products';
    if (is_dir($imgProductsPath)) {
        $copiedImg = copyFolderRecursive($imgProductsPath, $publicStoragePath . '/products');
        $log .= '✔ Berhasil menyalin ' . $copiedImg . ' file seeder dari folder img/products.\n';
    }

    // Bersihkan cache Laravel
    $cacheDir = $laravelRoot . '/bootstrap/cache';
    if (is_dir($cacheDir)) { $caches = glob($cacheDir . '/*.php'); foreach ($caches as $cf) @unlink($cf); }

    if (function_exists('opcache_reset')) { opcache_reset(); }

    echo "<div style='font-family:Inter,sans-serif;max-width:640px;margin:60px auto;padding:0 20px;'>";  
    echo "<div style='background:linear-gradient(135deg,#1e3a8a,#2563eb);border-radius:1.25rem;padding:2rem;color:white;text-align:center;margin-bottom:1.5rem;'>";  
    echo "<div style='font-size:3rem;margin-bottom:0.75rem;'>🖼️</div>";  
    echo "<h1 style='margin:0;font-size:1.5rem;font-weight:900;'>Pembaruan & Migrasi Berhasil!</h1>";  
    echo "<p style='margin:0.5rem 0 0;opacity:0.8;font-size:0.9rem;'>Penyimpanan Fisik Tanpa Symlink Diaktifkan (v54)</p>
";  
    echo "</div>";  
    echo "<div style='background:white;border:1px solid #e5e7eb;border-radius:1rem;padding:1.5rem;margin-bottom:1.25rem;box-shadow:0 4px 16px rgba(0,0,0,0.06);'>";  
    echo "<h2 style='margin:0 0 1rem;color:#1f2937;font-size:1rem;font-weight:800;'>Log Pembaruan:</h2>";  
    echo "<pre style='background:#f3f4f6;padding:1rem;border-radius:0.5rem;font-size:0.8rem;line-height:1.6;'>" . htmlspecialchars($log) . "</pre>";
    echo "<p style='font-size:0.875rem;color:#4b5563;'>Disk <code>public</code> telah dipindahkan ke folder fisik <code>public/storage</code>. Semua file media seeder berhasil disalin.</p>";
    echo "</div>";  
    echo "<div style='text-align:center;'>";  
    echo "<a href='/products' style='display:inline-flex;align-items:center;gap:0.5rem;padding:0.875rem 2rem;background:linear-gradient(135deg,#ca8a04,#d97706);color:#111827;text-decoration:none;border-radius:0.875rem;font-weight:800;font-size:0.95rem;box-shadow:0 4px 16px rgba(202,138,4,0.35);'>📦 Buka Data Barang</a>";  
    echo "</div>";  
    echo "</div>";  
} catch (\Exception $e) {
    echo "<h1 style='color:red;'>Error:</h1><pre>" . $e->getMessage() . "</pre>";
}
