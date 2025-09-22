import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import aspect from '@tailwindcss/aspect-ratio';

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
                // Enhanced Brand Color System
                'brand': {
                    // Primary Red Palette (Based on #8e2a2a)
                    'primary': {
                        50: '#fdf2f2',   // Very light red tint
                        100: '#fde8e8',  // Light red tint
                        200: '#fbd5d5',  // Lighter red
                        300: '#f8b4b4',  // Light red
                        400: '#f87171',  // Medium light red
                        500: '#ef4444',  // Standard red
                        600: '#dc2626',  // Medium red
                        700: '#b91c1c',  // Dark red
                        800: '#991b1b',  // Darker red
                        900: '#8e2a2a',  // Danielle Red (primary)
                        950: '#671f1f'   // Darkest red
                    },

                    // Secondary Green Palette (Complementary)
                    'secondary': {
                        50: '#f0fdf4',   // Very light green
                        100: '#dcfce7',  // Light green tint
                        200: '#bbf7d0',  // Lighter green
                        300: '#86efac',  // Light green
                        400: '#4ade80',  // Medium light green
                        500: '#22c55e',  // Standard green
                        600: '#16a34a',  // Medium green
                        700: '#15803d',  // Dark green
                        800: '#166534',  // Darker green
                        900: '#2a4d3a',  // Forest green (secondary)
                        950: '#1a2e23'   // Darkest green
                    },

                    // Accent Gold/Amber Palette
                    'accent': {
                        50: '#fffbeb',   // Very light amber
                        100: '#fef3c7',  // Light amber tint
                        200: '#fde68a',  // Lighter amber
                        300: '#fcd34d',  // Light amber
                        400: '#fbbf24',  // Medium light amber
                        500: '#f59e0b',  // Standard amber
                        600: '#d97706',  // Medium amber
                        700: '#b45309',  // Dark amber
                        800: '#92400e',  // Darker amber
                        900: '#d4af37',  // Gold (accent)
                        950: '#78350f'   // Darkest amber
                    },

                    // Neutral Gray Palette
                    'neutral': {
                        50: '#fafafa',   // Very light gray
                        100: '#f5f5f5',  // Light gray tint
                        200: '#e5e5e5',  // Lighter gray
                        300: '#d4d4d4',  // Light gray
                        400: '#a3a3a3',  // Medium light gray
                        500: '#737373',  // Standard gray
                        600: '#525252',  // Medium gray
                        700: '#404040',  // Dark gray
                        800: '#262626',  // Darker gray
                        900: '#5a5a5a',  // Charcoal gray (neutral)
                        950: '#0a0a0a'   // Darkest gray
                    },

                    // Light/Background Palette
                    'light': {
                        50: '#fefefe',   // Pure white
                        100: '#fdfdf8',  // Warm white
                        200: '#faf8f2',  // Light warm
                        300: '#f7f4ed',  // Warmer light
                        400: '#f2ede3',  // Medium warm
                        500: '#ede6d9',  // Standard warm
                        600: '#e8dfd0',  // Medium warm beige
                        700: '#ddd1bf',  // Darker warm
                        800: '#d2c4ae',  // Dark warm
                        900: '#f5f5f0',  // Warm off-white (light)
                        950: '#c7b99d'   // Darkest warm
                    }
                },

                // Legacy colors (maintain compatibility)
                'danielle':'#8e2a2a',
                'daniellealt':'#6b1e1e',
                'primary':'#1B70FA',
                'primary_alt':'#165cd4',
                'success':'#16a34a',
                'success_alt':'#15803d',
                'warning':'#FEC029',
                'warning_alt':'#b9860a',
                'info':'#24CBEE',
                'info_alt':'#24CBEE',
                'danger':'#8e2a2a',
                'danger_alt':'#671f1f',

                // Green-Based Color Scheme (Nature-Inspired Palette)
                'brand-primary': '#16a34a',    // Primary Green - main brand color
                'brand-secondary': '#8B7355',  // Earth Brown - warmth, natural materials
                'brand-accent': '#FFD700',     // Gold - premium accent for stars and highlights
                'brand-neutral': '#64748B',    // Stone Gray - durability, strength, natural stone
                'brand-light': '#F8FAFC',      // Cloud White - clean, fresh, open sky

                // Outdoor Color Scheme (Nature-Inspired Palette)
                'outdoor': {
                    'primary': '#16a34a',      // Green-600
                    'light': '#dcfce7',        // Green-100
                    'sky': '#0ea5e9',          // Sky-500
                    'gold': '#eab308',         // Yellow-500
                    'cedar': '#8b5a3c',        // Custom cedar brown
                    'sage': '#84cc16',         // Lime-500
                    'mint': '#06d6a0',         // Custom mint
                    'mist': '#f1f5f9',         // Slate-50
                }
            },
            fontFamily: {
                sans: ['Inter', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
                display: ['Playfair Display', 'Georgia', 'Times New Roman', 'serif'],
                body: ['Inter', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
            },
        },
    },

    plugins: [forms, typography, aspect],
};
