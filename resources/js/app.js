import './bootstrap';
import AOS from 'aos';
import { initPerformanceOptimizations } from './performance';

// Patch MutationObserver to prevent Filament errors
const OriginalMutationObserver = window.MutationObserver;
window.MutationObserver = function(callback) {
    const observer = new OriginalMutationObserver(callback);
    const originalObserve = observer.observe;

    observer.observe = function(target, options) {
        if (target && target.nodeType === Node.ELEMENT_NODE) {
            return originalObserve.call(this, target, options);
        }
        console.warn('MutationObserver.observe called with invalid target, ignoring');
    };

    return observer;
};

// Initialize performance optimizations immediately
initPerformanceOptimizations();

// Let Livewire handle Alpine.js completely - don't start our own instance

import 'livewire-sortable'

// Initialize AOS with performance-optimized settings
document.addEventListener('DOMContentLoaded', function() {
    AOS.init({
        duration: 600,          // Faster animations for better performance
        easing: 'ease-out',     // Simpler easing
        once: true,             // Animate only once for better performance
        offset: 50,             // Smaller offset
        delay: 0,               // No delay
        anchorPlacement: 'top-bottom',
        disable: 'mobile',      // Disable on mobile for better performance
        startEvent: 'DOMContentLoaded',
        initClassName: 'aos-init',
        animatedClassName: 'aos-animate',
        useClassNames: false,
        disableMutationObserver: true,  // Disable for better performance
        debounceDelay: 50,
        throttleDelay: 100,
    });

    // Add some custom CSS for extra cool effects
    const style = document.createElement('style');
    style.textContent = `
        [data-aos="slide-up"] {
            transform: translate3d(0, 100px, 0);
            opacity: 0;
        }
        [data-aos="slide-up"].aos-animate {
            transform: translate3d(0, 0, 0);
            opacity: 1;
        }

        [data-aos="zoom-in-up"] {
            transform: translate3d(0, 100px, 0) scale(0.6);
            opacity: 0;
        }
        [data-aos="zoom-in-up"].aos-animate {
            transform: translate3d(0, 0, 0) scale(1);
            opacity: 1;
        }

        [data-aos="bounce-in"] {
            transform: scale(0.3);
            opacity: 0;
        }
        [data-aos="bounce-in"].aos-animate {
            transform: scale(1);
            opacity: 1;
            animation: aosBouncein 0.6s ease-out;
        }

        @keyframes aosBouncein {
            20% { transform: scale(1.1); }
            50% { transform: scale(1.05); }
            80% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
    `;
    document.head.appendChild(style);
});

import.meta.glob([
    '../images/**',
    '../catalogs/**',
    '../videos/**'
]);
import 'fslightbox';

// Import ChatGPT functionality for Filament admin
import './chatgpt';
