import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/dashboard.js'],
            publicDirectory: 'public',
            hotFile: 'public/hot',
            refresh: ['resources/views/**/*.blade.php'],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['storage/framework/views/**'],
        },
    },
});
