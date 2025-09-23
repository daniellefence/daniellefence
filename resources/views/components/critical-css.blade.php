{{-- Critical CSS for above-the-fold content --}}
<style>
/* Reset and base styles - Critical for LCP */
*,::before,::after{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}
::before,::after{--tw-content:''}
html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;font-family:Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";font-feature-settings:normal;font-variation-settings:normal}
body{margin:0;line-height:inherit}

/* Typography - Critical for text rendering */
h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}
a{color:inherit;text-decoration:inherit}
b,strong{font-weight:bolder}

/* Layout - Critical for above-the-fold */
.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}
.h-full{height:100%}
.w-full{width:100%}
.min-h-screen{min-height:100vh}
.font-sans{font-family:Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji"}
.relative{position:relative}
.absolute{position:absolute}
.fixed{position:fixed}
.sticky{position:sticky}
.top-0{top:0px}
.z-10{z-index:10}
.z-20{z-index:20}
.z-30{z-index:30}
.z-50{z-index:50}

/* Flexbox - Critical for layout */
.flex{display:flex}
.inline-flex{display:inline-flex}
.items-center{align-items:center}
.items-start{align-items:flex-start}
.justify-center{justify-content:center}
.justify-between{justify-content:space-between}
.gap-2{gap:0.5rem}
.gap-3{gap:0.75rem}
.gap-4{gap:1rem}
.gap-6{gap:1.5rem}

/* Colors - Critical brand colors */
.bg-white{background-color:#fff}
.bg-black{background-color:#000}
.text-white{color:#fff}
.text-black{color:#000}
.text-slate-900{color:#0f172a}
.text-slate-800{color:#1e293b}
.text-slate-700{color:#334155}
.bg-outdoor-primary{background-color:#8e2a2a}
.bg-outdoor-mint{background-color:#16a34a}
.text-outdoor-primary{color:#8e2a2a}

/* Spacing - Critical for layout */
.p-2{padding:0.5rem}
.p-4{padding:1rem}
.p-6{padding:1.5rem}
.px-4{padding-left:1rem;padding-right:1rem}
.px-6{padding-left:1.5rem;padding-right:1.5rem}
.py-2{padding-top:0.5rem;padding-bottom:0.5rem}
.py-4{padding-top:1rem;padding-bottom:1rem}
.py-6{padding-top:1.5rem;padding-bottom:1.5rem}
.mx-auto{margin-left:auto;margin-right:auto}
.mt-2{margin-top:0.5rem}
.mb-4{margin-bottom:1rem}

/* Display utilities */
.block{display:block}
.inline-block{display:inline-block}
.hidden{display:none}

/* Container */
.container{width:100%}
@media (min-width: 640px){.container{max-width:640px}}
@media (min-width: 768px){.container{max-width:768px}}
@media (min-width: 1024px){.container{max-width:1024px}}
@media (min-width: 1280px){.container{max-width:1280px}}
@media (min-width: 1536px){.container{max-width:1536px}}

/* Responsive utilities */
@media (min-width: 768px){.md\:block{display:block}.md\:flex{display:flex}.md\:hidden{display:none}}
@media (min-width: 1024px){.lg\:block{display:block}.lg\:flex{display:flex}.lg\:hidden{display:none}}

/* Header specific critical styles */
.backdrop-blur-md{backdrop-filter:blur(12px)}
.backdrop-blur-xl{backdrop-filter:blur(24px)}
.border-b{border-bottom-width:1px}
.border-slate-200\/50{border-color:rgb(226 232 240 / 0.5)}
.bg-white\/80{background-color:rgb(255 255 255 / 0.8)}
.shadow-md{box-shadow:0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)}
.rounded-lg{border-radius:0.5rem}
.rounded-full{border-radius:9999px}

/* Hero section critical styles */
.h-16{height:4rem}
.h-20{height:5rem}
.h-24{height:6rem}
.h-28{height:7rem}
.w-auto{width:auto}
.object-cover{object-fit:cover}
.inset-0{inset:0px}

/* Animation prevention for critical render */
.transition-none{transition-property:none}

/* Font loading optimization */
@font-face{font-family:'Inter';font-style:normal;font-weight:400;font-display:swap;src:url('https://fonts.bunny.net/inter/files/inter-latin-400-normal.woff2') format('woff2')}
@font-face{font-family:'Inter';font-style:normal;font-weight:600;font-display:swap;src:url('https://fonts.bunny.net/inter/files/inter-latin-600-normal.woff2') format('woff2')}
</style>