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
            colors: {
                primary: '#FEFDED',   // Warna primary
                secondary: '#FA7070', // Warna secondary
                third: '#C6EBC5',     // Warna third
                fourth: '#A1C398',    // Warna fourth
            },
            backgroundImage: {
                'gray-gradient': 'linear-gradient(to bottom left, #9ca3af 1%, white 60%)',
                'green-gradient': 'linear-gradient(to right, #C6EBC5 10%, white 50%)',
            },
            fontFamily: {
                //hiraukan banyaknya font ini, sempet nyoba-nyoba soale
                mono: ["Syne", "monospace"],
                inter: ["Inter", "sans-serif"], 
                Fira_Code: ['Fira_Code', 'monospace'],
                Funnel_Sans: ['Funnel Sans', 'sans-serif'],
                Poppins: ['Poppins', 'serif'],
                Rammetto_One: ['Rammetto One', 'cursive']
            },
            fontWeight: {
                thin: 100,
                extralight: 200,
                light: 300,
                normal: 400,
                medium: 500,
                semibold: 600,
                bold: 700,
                extrabold: 800,
                black: 900,
            },
        },
    },
    plugins: [],
};
