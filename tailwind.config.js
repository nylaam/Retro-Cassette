import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                cream: '#F5EBD7',
                ink: '#2B2B2B',
                lcd: '#1F3D2B',
                'lcd-text': '#9BE29B',
            },
            fontFamily: {
                pixel: ['"Press Start 2P"', 'monospace'],
            },
        },
    },

    plugins: [forms],
};
