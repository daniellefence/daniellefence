import './bootstrap';
import AOS from 'aos';

import 'livewire-sortable'

// Initialize AOS with enhanced settings
document.addEventListener('DOMContentLoaded', function() {
    AOS.init({
        duration: 1000,         // Slower, more dramatic animations
        easing: 'ease-out-cubic', // Smoother easing
        once: false,            // Allow re-animation on scroll up
        offset: 100,            // Trigger earlier
        delay: 50,              // Faster initial delay
        anchorPlacement: 'top-bottom',
        disable: false,         // Never disable
        startEvent: 'DOMContentLoaded',
        initClassName: 'aos-init',
        animatedClassName: 'aos-animate',
        useClassNames: false,
        disableMutationObserver: false,
        debounceDelay: 50,
        throttleDelay: 99,
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
