<?php
$content = file_get_contents('show.blade.php.bak');

$replacements = [
    // 1. Update @page margins
    "@page { \n                size: A4 portrait; \n                margin: 5mm 15mm; \n            }" => "@page { \n                size: A4 portrait; \n                margin-top: 50mm; \n                margin-bottom: 20mm; \n                margin-left: 15mm; \n                margin-right: 15mm; \n            }",

    // 2. Update .print-header in @media print
    ".print-header {\n                position: fixed !important;\n                top: 0 !important;\n                left: 0 !important;\n                right: 0 !important;\n                width: 100% !important;\n                background: white !important;\n                z-index: 50 !important;\n            }" => ".print-header {\n                position: fixed !important;\n                top: -50mm !important;\n                left: 0 !important;\n                right: 0 !important;\n                width: 100% !important;\n                height: 45mm !important;\n                background: white !important;\n                z-index: 50 !important;\n            }",

    // 3. Update .print-footer in @media print
    ".print-footer {\n                position: fixed !important;\n                bottom: 0 !important;\n                left: 0 !important;\n                right: 0 !important;\n                width: 100% !important;\n                z-index: 50 !important;\n            }" => ".print-footer {\n                position: fixed !important;\n                bottom: -20mm !important;\n                left: 0 !important;\n                right: 0 !important;\n                width: 100% !important;\n                height: 15mm !important;\n                z-index: 50 !important;\n            }",

    // 4. Remove .header-space and .footer-space
    "            .header-space, .footer-space {\n                display: block;\n            }\n            .header-space { height: 45mm; }\n            .footer-space { height: 15mm; }" => "",

    // 5. Remove wrapper table start
    "    <!-- Wrapper Table (untuk mengulangi header space & footer space pada setiap halaman) -->\n    <table class=\"w-full relative z-10\">\n        <thead>\n            <tr>\n                <td>\n                    <!-- Space untuk Header Fixed -->\n                    <div class=\"header-space\"></div>\n                </td>\n            </tr>\n        </thead>\n        <tbody>\n            <tr>\n                <td>" => "",

    // 6. Remove wrapper table end
    "                </td>\n            </tr>\n        </tbody>\n        <tfoot>\n            <tr>\n                <td>\n                    <!-- Space untuk Footer Fixed -->\n                    <div class=\"footer-space\"></div>\n                </td>\n            </tr>\n        </tfoot>\n    </table>" => ""
];

foreach ($replacements as $search => $replace) {
    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
    } else {
        echo "Failed to find search string:\n" . substr($search, 0, 50) . "...\n";
    }
}

file_put_contents('resources/views/invoices/show.blade.php', $content);
echo "Modification complete.\n";
