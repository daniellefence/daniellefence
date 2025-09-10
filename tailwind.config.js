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
    ],

    theme: {
        extend: {
            colors:{
                // Brand Colors
                'danielle':'#8f2a2a',           // Primary brand red
                'daniellealt':'#7a2626',        // Darker primary red
                'brand-red':'#c1121F',          // Secondary brand red
                'brand-cream':'#fdf0d5',        // Cream/beige
                'brand-dark':'#003049',         // Dark blue
                'brand-light':'#669bbc',        // Light blue
                
                // System Colors
                'primary':'#8f2a2a',            // Using brand primary
                'primary_alt':'#7a2626',
                'success':'#1F8755',
                'success_alt':'#186741',
                'warning':'#FEC029',
                'warning_alt':'#b9860a',
                'info':'#669bbc',               // Using brand light blue
                'info_alt':'#5588a3',
                'danger':'#c1121F',             // Using brand secondary red
                'danger_alt':'#a00f1a'
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, typography],
};
