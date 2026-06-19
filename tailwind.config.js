/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                'tema-hitam': '#111827',
                'tema-kuning': '#FBBF24',
                'tema-marun': '#800000',
            }
        },
    },
    plugins: [],
}
