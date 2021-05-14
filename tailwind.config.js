const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                blueGray: {
                    '050': '#F0F4F8',
                    '100': '#D9E2EC',
                    '200': '#BCCCDC',
                    '300': '#9FB3C8',
                    '400': '#829AB1',
                    '500': '#627D98',
                    '600': '#486581',
                    '700': '#334E68',
                    '800': '#243B53',
                    '900': '#102A43', 
                },
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
