const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        fontSize: {
            'xs': ['12px', {
                letterSpacing: '1px',
                lineHeight: '1.5',
            }],
            'sm': ['14px', {
                letterSpacing: '0px',
                lineHeight: '1.5',
            }],
            'base': ['16px', {
                letterSpacing: '0px',
                lineHeight: '1.5',
            }],
            'lg': ['21px', {
                letterSpacing: '0px',
                lineHeight: '1.2',
            }],
            'xl': ['28px', {
                letterSpacing: '0px',
                lineHeight: '1.3',
            }],
            '2xl': ['38px', {
                letterSpacing: '0px',
                lineHeight: '1.5',
            }],
            '3xl': ['51px', {
                letterSpacing: '0px',
                lineHeight: '1.5',
            }],
        },
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                'box': '4px 4px 0 0 rgba(0, 0, 0, 1)',
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
