import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    server: {
        //ローカル環境では不要
        // https: true,
    },
    build: {
        manifest: 'manifest.json',
        rollupOptions: {
            input: {
                appCss: 'resources/css/app.css',
                app: 'resources/js/app.js',
                categoryCss: 'resources/css/category.css',
                contentCss: 'resources/css/content.css',
                main: 'resources/js/main.js',
                particle: 'resources/js/particle.js',
                screenSize: 'resources/js/screen-size.js',
                adminCategory: 'resources/js/admin/category.js',
                adminContent: 'resources/js/admin/content.js',
            }
        }
    }
});
