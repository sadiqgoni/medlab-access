import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/views/layouts/landing.blade.php',
        './resources/views/landing.blade.php',
        './resources/views/layouts/app.blade.php',
        './resources/views/layouts/navigation.blade.php',
        './resources/views/layouts/footer.blade.php',
        './resources/views/layouts/sidebar.blade.php',
        './resources/views/layouts/header.blade.php',
        './resources/views/layouts/content.blade.php',
        './resources/views/layouts/footer.blade.php',
        './resources/views/layouts/sidebar.blade.php',
        './resources/views/layouts/header.blade.php',
        './resources/views/layouts/content.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                display: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#e3f2fd',
                    100: '#bbdefb',
                    200: '#90caf9',
                    300: '#64b5f6',
                    400: '#42a5f5',
                    500: '#1e88e5',
                    600: '#1976d2',
                    700: '#1565c0',
                    800: '#0d47a1',
                    900: '#0a2351',
                },
                secondary: {
                    50: '#e8f5e9',
                    100: '#c8e6c9',
                    200: '#a5d6a7',
                    300: '#81c784',
                    400: '#66bb6a',
                    500: '#4caf50',
                    600: '#43a047',
                    700: '#388e3c',
                    800: '#2e7d32',
                    900: '#1b5e20',
                },
                accent: '#FF5722',
                neutral: {
                    lightest: '#f8f9fa',
                    light: '#f1f3f5',
                    dark: '#343a40',
                },
            },
        },
    },

    plugins: [forms],
};
