<?php
$content = file_get_contents('show.blade.php.bak');

// 1. Update @page margins
$content = str_replace(
    "@page { \n                size: A4 portrait; \n                margin: 5mm 15mm; \n            }",
    "@page { \n                size: A4 portrait; \n                margin-top: 50mm; \n                margin-bottom: 20mm; \n                margin-left: 15mm; \n                margin-right: 15mm; \n            }",
    $content
);

// 2. Update .print-header to be placed in the margin
$content = preg_replace(
    '/\.print-header\s*\{[^}]+\}/s',
    ".print-header {\n                position: fixed !important;\n                top: -45mm !important;\n                left: 0 !important;\n                right: 0 !important;\n                width: 100% !important;\n                height: 40mm !important;\n                background: white !important;\n                z-index: 50 !important;\n            }",
    $content
);

// 3. Update .print-footer to be placed in the margin
$content = preg_replace(
    '/\.print-footer\s*\{[^}]+\}/s',
    ".print-footer {\n                position: fixed !important;\n                bottom: -15mm !important;\n                left: 0 !important;\n                right: 0 !important;\n                width: 100% !important;\n                height: 15mm !important;\n                z-index: 50 !important;\n            }",
    $content
);

// 4. Remove .header-space and .footer-space CSS
$content = preg_replace('/\.header-space,\s*\.footer-space\s*\{[^}]+\}/s', '', $content);
$content = preg_replace('/\.header-space\s*\{[^}]+\}/s', '', $content);
$content = preg_replace('/\.footer-space\s*\{[^}]+\}/s', '', $content);

// 5. Remove the outer wrapper table from the body!
// We need to match from:
//     <!-- Wrapper Table (untuk mengulangi header space & footer space pada setiap halaman) -->
//     <table class="w-full relative z-10">
// All the way to:
//         <tbody>
//             <tr>
//                 <td>
//                     <!-- KONTEN UTAMA -->
$search_wrapper_start = <<<EOD
    <!-- Wrapper Table (untuk mengulangi header space & footer space pada setiap halaman) -->
    <table class="w-full relative z-10">
        <thead>
            <tr>
                <td>
                    <!-- Space untuk Header Fixed -->
                    <div class="header-space"></div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <!-- KONTEN UTAMA -->
EOD;

$replace_wrapper_start = <<<EOD
    <!-- KONTEN UTAMA -->
EOD;

$content = str_replace($search_wrapper_start, $replace_wrapper_start, $content);

// 6. Remove the closing of the wrapper table
$search_wrapper_end = <<<EOD
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <!-- Space untuk Footer Fixed -->
                    <div class="footer-space"></div>
                </td>
            </tr>
        </tfoot>
    </table>
EOD;

$replace_wrapper_end = <<<EOD
EOD;

$content = str_replace($search_wrapper_end, $replace_wrapper_end, $content);

file_put_contents('resources/views/invoices/show.blade.php', $content);
echo "Modification complete.";
