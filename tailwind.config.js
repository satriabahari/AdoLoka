import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Onest", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: "#0ea5e9",
                    dark: "#0284c7",
                    hover: "#0369a1",
                },
                secondary: {
                    DEFAULT: "#10b981",
                    dark: "#059669",
                },
                tertiary: "",

                title: "",
                description: "",
                background: "",
                neutral: "",

                error: "#dc2626",
                success: "#22c55e",
            },
        },
    },

    plugins: [forms],
};
