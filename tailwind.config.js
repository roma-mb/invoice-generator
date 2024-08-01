/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                "indigo": "#2a3849",
                "black": "#050d16",
                "crayola": "#303440",
                "ash-gray": "#B2C6B3",
                "beaver": "#A9836C",
                "auro-metal": "#738282",
                "axolotl": "#6F7661",
                "steel-blue": "#4093A5",
                "sea-green": "#3C9E64",
            },
        },
    },
    plugins: [],
}

