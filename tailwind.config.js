import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

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
                primary: "#243642",
                secondary: "#387478",
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

    plugins: [forms, typography],
};
