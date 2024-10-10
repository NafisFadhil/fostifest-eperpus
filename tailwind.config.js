import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.tsx",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: "#FE6019",
                secondary: "#FEE140",
                body: "#fafafa",
                border: "#EBEBEB",
                theme_light: "#E5E5E5",
                theme_dark: "#1a202c",
            },
            textColor: {
                default: "#888888",
                dark: "#222",
                light: "#ceced0",
            },
        },
    },

    plugins: [forms],
};
