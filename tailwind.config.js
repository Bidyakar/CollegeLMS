/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./**/*.php",
        "./**/*.html",
        "./index.php",
        "./includes/**/*.php",
        "./admin/**/*.php",
        "./student/**/*.php",
        "./auth/**/*.php"
    ],
    theme: {
        extend: {
            colors: {
                indigo: {
                    900: '#191146'
                },
                yellow: {
                    400: '#FACC15'
                },
                'uneza-red': '#DC2626',
                'uneza-dark': '#1F2937',
            },
            fontFamily: {
                sans: ['Inter', 'sans-serif'],
                serif: ['Playfair Display', 'serif']
            }
        },
    },
    plugins: [],
}
