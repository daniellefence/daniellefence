import { ViteImageOptimizer } from 'vite-plugin-image-optimizer';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        minify: 'esbuild',
        cssMinify: 'esbuild',
        rollupOptions: {
            output: {
                manualChunks: (id) => {
                    if (id.includes('node_modules')) {
                        return 'vendor';
                    }
                }
            }
        },
        target: 'es2015',
        sourcemap: false,
        cssCodeSplit: true,
        reportCompressedSize: false,
        chunkSizeWarningLimit: 1000,
        // Optimize for production builds
        terserOptions: {
            compress: {
                drop_console: true,
                drop_debugger: true
            }
        },
        // Increase build timeout
        assetsInlineLimit: 4096,
        emptyOutDir: true
    },
    plugins: [
        // Only optimize images in development, not production
        ...(process.env.NODE_ENV !== 'production' ? [
            ViteImageOptimizer({
                test: /\.(jpe?g|png|gif|tiff|webp|svg|avif)$/i,
                gifsicle: { optimizationLevel: 7, interlaced: false },
                mozjpeg: { quality: 85, progressive: true },
                pngquant: { quality: [0.8, 0.9], speed: 4 },
                svgo: {
                    plugins: [
                        { name: 'removeViewBox', active: false },
                        { name: 'removeEmptyAttrs', active: false }
                    ]
                },
                webp: { quality: 85 },
                avif: { quality: 80 }
            })
        ] : []),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/filament/admin/theme.css',
            ],
            refresh: [
                'resources/routes/**',
                'resources/views/**',
                'app/Filament/**',
                'app/Forms/Components/**',
                'app/Livewire/**',
                'app/Infolists/Components/**',
                'app/Providers/Filament/**',
                'app/Tables/Columns/**',
            ],
        }),
    ],
    server: {
        hmr: {
            overlay: false
        }
    }
});
