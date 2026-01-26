import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            // input: ['resources/css/app.css', 'resources/js/app.js','resources/js/dashboard-finance.js',],
            input: ['resources/css/app.css', 'resources/js/app.js','resources/css/filament/dkm/theme.css','resources/js/dashboard-finance.js',],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
    },
});