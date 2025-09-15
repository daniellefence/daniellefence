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
            colors: {
                // Primary Brand Colors (keeping your main brand color)
                'primary': '#8f2a2a',           // Your exact brand burgundy
                'primary-dark': '#6b2424',      // Darker shade for hover states
                'primary-light': '#a84545',     // Lighter shade for accents

                // Legacy names for backwards compatibility
                'danielle': '#8f2a2a',
                'daniellealt': '#6b2424',

                // Warm Neutral Palette (complements burgundy beautifully)
                'neutral': {
                    50: '#fafaf9',   // Almost white with warm tint
                    100: '#f5f5f4',  // Light cream
                    200: '#e7e5e4',  // Light gray
                    300: '#d6d3d1',  // Medium light gray
                    400: '#a8a29e',  // Medium gray
                    500: '#78716c',  // Dark gray
                    600: '#57534e',  // Darker gray
                    700: '#44403c',  // Very dark gray
                    800: '#292524',  // Almost black
                    900: '#1c1917',  // Rich black
                },

                // Accent Colors (professional and complementary)
                'accent': {
                    'blue': '#2563eb',    // Trust & professionalism
                    'green': '#16a34a',   // Growth & success
                    'amber': '#d97706',   // Warmth & attention
                    'teal': '#0891b2',    // Modern & fresh
                    'purple': '#7c3aed',  // Premium & creative
                },

                // Semantic Colors
                'success': '#16a34a',
                'warning': '#eab308',
                'error': '#8a2e2e',     // Using primary burgundy for errors
                'info': '#2563eb',

                // Background Colors
                'bg': {
                    'light': '#fafaf9',      // Lightest background
                    'cream': '#f5f5f4',      // Cream background
                    'muted': '#e7e5e4',      // Muted background
                    'card': '#ffffff',       // Card backgrounds
                    'dark': '#1c1917',       // Dark mode background
                },

                // Text Colors
                'text': {
                    'primary': '#1c1917',    // Main text
                    'secondary': '#57534e',  // Secondary text
                    'muted': '#78716c',      // Muted text
                    'light': '#a8a29e',      // Light text
                    'white': '#ffffff',      // White text
                },

                // Legacy compatibility mappings
                'brand-cream': '#f5f5f4',
                'brand-light': '#2563eb',
                'brand-dark': '#1c1917',
                'brand-navy': '#1e40af',
                'brand-gold': '#d97706',
                'brand-green': '#16a34a',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, typography],
};
