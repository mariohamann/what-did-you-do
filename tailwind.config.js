import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            boxShadow: {
                hard: "4px 4px 0px 0px #000000",
            },
            fontFamily: {
                sans: ["Poppins", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // https://uicolors.app/edit?sv1=secondary:50-fefbec/100-fcf2c9/200-fae48d/300-f8d86d/400-f5bd2a/500-ee9d12/600-d3780c/700-af550e/800-8e4212/900-753612/950-431b05;primary:50-ebf6ff/100-daefff/200-bce0ff/300-94c9ff/400-6aa5ff/500-4782ff/600-275aff/700-1946e6/800-1a40b9/900-1e3c91/950-122154
                primary: {
                    50: "hsl(207, 100%, 96%)",
                    100: "hsl(206, 100%, 93%)",
                    200: "hsl(208, 100%, 87%)",
                    300: "hsl(210, 100%, 79%)",
                    400: "hsl(216, 100%, 71%)",
                    500: "hsl(221, 100%, 64%)",
                    600: "hsl(226, 100%, 58%)",
                    700: "hsl(227, 80%, 50%)",
                    800: "hsl(226, 75%, 41%)",
                    900: "hsl(224, 66%, 34%)",
                    950: "hsl(226, 65%, 20%)",
                },
                secondary: {
                    50: "hsl(50, 90%, 96%)",
                    100: "hsl(48, 89%, 89%)",
                    200: "hsl(48, 92%, 77%)",
                    300: "hsl(46, 91%, 70%)",
                    400: "hsl(43, 91%, 56%)",
                    500: "hsl(38, 87%, 50%)",
                    600: "hsl(33, 89%, 44%)",
                    700: "hsl(26, 85%, 37%)",
                    800: "hsl(23, 78%, 31%)",
                    900: "hsl(22, 73%, 26%)",
                    950: "hsl(21, 86%, 14%)",
                },
            },
        },
    },

    plugins: [forms],
};
