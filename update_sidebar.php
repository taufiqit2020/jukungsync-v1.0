<?php
$file = 'resources/views/layouts/admin.blade.php';
$content = file_get_contents($file);

$searchLink = <<<EOD
                <a href="{{ route('merks.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('merks.*') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Data Merk
                </a>

                <a href="{{ route('products.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('products.*') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
EOD;

$replaceLink = <<<EOD
                <a href="{{ route('merks.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('merks.*') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Data Merk
                </a>
                
                <a href="{{ route('customers.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('customers.*') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Data Customer
                </a>

                <a href="{{ route('products.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('products.*') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
EOD;

$content = str_replace($searchLink, $replaceLink, $content);
file_put_contents($file, $content);
echo "Sidebar updated.\n";
