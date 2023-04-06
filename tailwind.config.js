/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    ],
    theme: {
        extend: {
            aspectRatio: {
                '3/2': '3 / 2',
            },
            height:{
                '48r': '48rem',
            },
            colors: {
                'purple': '#723F5FFF',
            },
        },
        fontFamily: {
            'roboto': ['Roboto', 'sans-serif'],
        }
    },
    plugins: [],
}
