import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'; // <--- 1. Importar esto

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
        vue(), // <--- 2. Activar esto aquí
    ],
    server: {
        hmr: {
            host: 'localhost',
        },
    },
});