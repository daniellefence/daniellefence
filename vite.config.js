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
                    // More aggressive chunking for better caching
                    if (id.includes('node_modules')) {
                        if (id.includes('alpine')) return 'alpine';
                        if (id.includes('aos')) return 'animations';
                        return 'vendor';
                    }
                },
                // Optimize chunk names for better caching
                chunkFileNames: 'js/[name]-[hash].js',
                entryFileNames: 'js/[name]-[hash].js',
                assetFileNames: (assetInfo) => {
                    const ext = assetInfo.name.split('.').pop();
                    if (['css'].includes(ext)) {
                        return 'css/[name]-[hash].[ext]';
                    }
                    if (['png', 'jpg', 'jpeg', 'webp', 'svg'].includes(ext)) {
                        return 'images/[name]-[hash].[ext]';
                    }
                    return 'assets/[name]-[hash].[ext]';
                }
            }
        },
        target: 'es2020',
        sourcemap: false,
        cssCodeSplit: true,
        reportCompressedSize: false,
        chunkSizeWarningLimit: 500,
        // Remove terser options for esbuild
        esbuildOptions: {
            drop: ['console', 'debugger'],
            legalComments: 'none'
        },
        assetsInlineLimit: 2048, // Inline smaller assets
        emptyOutDir: true,
        // Enable compression
        cssTarget: 'chrome90',
        modulePreload: {
            polyfill: false
        }
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
