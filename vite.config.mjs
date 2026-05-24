import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig(({ command }) => {
    const isBuild = command === 'build';
    const devOrigin = process.env.VITE_DEV_ORIGIN || 'http://arti.test';

    return {
        base: isBuild ? '/wp-content/themes/arti-theme/dist/' : '/',
        server: {
            port: 3000,
            cors: true,
            origin: devOrigin,
        },
        build: {
            manifest: true,
            outDir: 'dist',
            rollupOptions: {
                input: [
                    'resources/js/app.js',
                    'resources/css/app.css',
                    'resources/css/editor-style.css'
                ],
            },
        },
        plugins: [
            tailwindcss(),
        ],
    }
});
