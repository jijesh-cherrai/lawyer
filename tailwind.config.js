import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    safelist: [
        // Background colors
        { pattern: /^bg-(red|green|blue|yellow|gray|indigo|purple|pink)-(100|200|300|400|500|600|700|800|900)$/ },

        // Text colors
        { pattern: /^text-(red|green|blue|yellow|gray|indigo|purple|pink)-(100|200|300|400|500|600|700|800|900)$/ },

        // Border colors
        { pattern: /^border-(red|green|blue|yellow|gray|indigo|purple|pink)-(100|200|300|400|500|600|700|800|900)$/ },

        // Padding and Margin
        { pattern: /^p-(0|1|2|3|4|5|6|8|10|12|16)$/ },
        { pattern: /^m-(0|1|2|3|4|5|6|8|10|12|16)$/ },

        // Widths and Heights
        { pattern: /^w-(4|8|16|32|64|full)$/ },
        { pattern: /^h-(4|8|16|32|64|full)$/ },

        // Borders and Radius
        { pattern: /^border-(0|2|4|8)$/ },
        { pattern: /^rounded-(none|sm|md|lg|full)$/ },

        // Shadows
        { pattern: /^shadow-(sm|md|lg|xl|2xl)$/ },

        // Flex and Grid
        'flex', 'flex-row', 'flex-col', 'items-center', 'justify-center',
        'grid', 'grid-cols-1', 'grid-cols-2', 'grid-cols-3', 'gap-2', 'gap-4',

        // Miscellaneous
        'cursor-pointer', 'hidden', 'block', 'inline-block', 'overflow-hidden',
        'text-center', 'text-left', 'text-right', 'font-bold', 'font-medium', 'font-light',
    ],
    plugins: [],
};
