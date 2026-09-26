import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // legacy (Livewire/Bootstrap) — kept during migration
                'resources/sass/app.scss',
                'resources/js/app.js',
                // new (Inertia/React/Tailwind)
                'resources/css/app.css',
                'resources/js/app.tsx',
            ],
            refresh: true,
        }),
        react(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
});
