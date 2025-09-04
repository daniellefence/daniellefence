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
                'danielle':'#8e2a2a',
                'daniellealt':'#6b1e1e',
                'primary':'#1B70FA',
                'primary_alt':'#165cd4',
                'success':'#1F8755',
                'success_alt':'#186741',
                'warning':'#FEC029',
                'warning_alt':'#b9860a',
                'info':'#24CBEE',
                'info_alt':'#24CBEE',
                'danger':'#8e2a2a',
                'danger_alt':'#671f1f'
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, typography],
};
