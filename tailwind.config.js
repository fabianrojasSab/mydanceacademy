import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: "#BF6FA3",
                secondary: "#5A3E6D",
                background: "#E0B7BD",
                text: "#8E6A83",
                accent: "#F9A8D4",
                dark: "#4A234F",
                gray_unique: "#F3F4F6",
            },
        },
    },

    plugins: [forms, typography, 
        require('flowbite/plugin')({
        datatables: true,
        }),
    ],
};
