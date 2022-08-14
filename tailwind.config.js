const colors = require('tailwindcss/colors')

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                // basic
                primary: colors.blue['500'],
                'primary-variant': colors.blue['700'],
                'secondary': '#ecc94b',
                'background': colors.white,
                'surface': colors.white,
                'error': '#b0020',
                'on-surface': colors.black,
                'on-primary': colors.white,
                'on-secondary': colors.black,
                'on-background': colors.black,
                'on-error': colors.white,

                // dark
                'dark-primary': colors.blue['200'],
                'dark-primary-variant': colors.blue['700'],
                'dark-secondary': '#ecc94b',
                'dark-background': '#121212',
                'dark-surface': '#121212',
                'dark-error': '#cf6679',
                'dark-on-surface': colors.white,
                'dark-on-primary': colors.black,
                'dark-on-secondary': colors.black,
                'dark-on-background': colors.white,
                'dark-on-error': colors.black
            }
        },

    },
    plugins: [],
}
