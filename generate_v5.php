<?php
$content = file_get_contents('show_v4.blade.php.bak');

$css_search = "            .watermark { z-index: -1 !important; opacity: 0.1 !important; }\n        }";
$css_replace = "            .watermark { z-index: -1 !important; opacity: 0.1 !important; }\n            .print-footer {\n                position: fixed !important;\n                bottom: -20mm !important;\n                left: 0 !important;\n                right: 0 !important;\n                width: 100% !important;\n                z-index: 50 !important;\n            }\n        }";

$css_search_page = "            @page { \n                size: A4 portrait; \n                margin: 10mm 15mm; \n            }";
$css_replace_page = "            @page { \n                size: A4 portrait; \n                margin-top: 10mm;\n                margin-bottom: 25mm;\n                margin-left: 15mm;\n                margin-right: 15mm;\n            }";

$sig_search = <<<EOD
    <!-- Informasi Pembayaran & Tanda Tangan -->
    <div class="mt-8 flex justify-between page-break-avoid">
        <div class="text-sm">
            <p class="mb-1">Pembayaran dapat dilakukan Cash atau Transfer melalui rekening :</p>
            <table class="w-full max-w-sm">
                <tr>
                    <td class="w-20 border-0 p-1">Bank</td>
                    <td class="font-bold border-0 p-1">: BSI</td>
                </tr>
                <tr>
                    <td class="border-0 p-1">No. Rek</td>
                    <td class="font-bold text-lg border-0 p-1">: 7343793687</td>
                </tr>
                <tr>
                    <td class="border-0 p-1">A/N</td>
                    <td class="font-bold border-0 p-1">: PT Utama Madani Raya</td>
                </tr>
            </table>
        </div>
        <div class="text-center w-64 mr-8">
            <p class="font-bold uppercase mb-20">OWNER</p>
            <p class="border-b border-black font-bold uppercase pb-1 inline-block w-full">HJ. NORMAULIDA, S.H.</p>
        </div>
    </div>

    <!-- Banner Footer (Absolute standard flow) -->
    <div class="mt-12 header-bg p-2 text-center text-sm font-semibold tracking-wide" style="border-radius: 4px; background-color: #111827; color: white;">
        Alamat Kantor : Jl. Panglima Batur Banjarbaru Utara, Banjarbaru Kalimantan Selatan
    </div>
EOD;

$sig_replace = <<<EOD
    <!-- Informasi Pembayaran & Tanda Tangan -->
    <div class="mt-8 page-break-avoid">
        <!-- Bank Info (Di atas) -->
        <div class="text-sm mb-8">
            <p class="mb-1">Pembayaran dapat dilakukan Cash atau Transfer melalui rekening :</p>
            <table class="w-full max-w-sm">
                <tr>
                    <td class="w-20 border-0 p-1">Bank</td>
                    <td class="font-bold border-0 p-1">: BSI</td>
                </tr>
                <tr>
                    <td class="border-0 p-1">No. Rek</td>
                    <td class="font-bold text-lg border-0 p-1">: 7343793687</td>
                </tr>
                <tr>
                    <td class="border-0 p-1">A/N</td>
                    <td class="font-bold border-0 p-1">: PT Utama Madani Raya</td>
                </tr>
            </table>
        </div>
        
        <!-- Signature (Di bawah Bank Info, posisi kanan) -->
        <div class="flex justify-end">
            <div class="text-center w-64 mr-8">
                <p class="font-bold uppercase mb-20">OWNER</p>
                <p class="border-b border-black font-bold uppercase pb-1 inline-block w-full">HJ. NORMAULIDA, S.H.</p>
            </div>
        </div>
    </div>

    <!-- Banner Footer (Fixed di bawah kertas untuk print) -->
    <div class="print-footer mt-12 header-bg p-2 text-center text-sm font-semibold tracking-wide" style="border-radius: 4px; background-color: #111827; color: white;">
        Alamat Kantor : Jl. Panglima Batur Banjarbaru Utara, Banjarbaru Kalimantan Selatan
    </div>
EOD;

$content = str_replace($css_search, $css_replace, $content);
$content = str_replace($css_search_page, $css_replace_page, $content);
$content = str_replace($sig_search, $sig_replace, $content);

file_put_contents('resources/views/invoices/show.blade.php', $content);
echo "Modification complete.";
