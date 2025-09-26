// Mobile Performance Optimizations for Danielle Fence

// Detect if user is on a slow connection or save-data mode
const isSaveData = () => {
    const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
    return (connection && (connection.saveData === true || connection.effectiveType === 'slow-2g' || connection.effectiveType === '2g'));
};

// Optimized Image Loading Strategy
export function optimizeImages() {
    // Add loading="lazy" to all images not in viewport
    const images = document.querySelectorAll('img:not([loading])');
    const heroImage = document.querySelector('.hero img');

    images.forEach((img, index) => {
        // Skip hero image and first 3 images
        if (img !== heroImage && index > 2) {
            img.loading = 'lazy';
            img.decoding = 'async';
        } else {
            img.loading = 'eager';
            img.decoding = 'sync';
        }

        // Add aspect ratio to prevent CLS
        if (img.width && img.height) {
            img.style.aspectRatio = `${img.width}/${img.height}`;
        }
    });

    // Use lower quality images for slow connections
    if (isSaveData()) {
        images.forEach(img => {
            if (img.src.includes('.webp')) {
                // Could swap to lower quality version if available
                img.loading = 'lazy';
            }
        });
    }
}

// Optimize Cumulative Layout Shift (CLS)
export function preventLayoutShift() {
    // Reserve space for dynamic content
    const dynamicElements = document.querySelectorAll('[data-dynamic-height]');
    dynamicElements.forEach(el => {
        const height = el.getAttribute('data-dynamic-height');
        if (height) {
            el.style.minHeight = height + 'px';
        }
    });

    // Add dimensions to all images without them
    document.querySelectorAll('img:not([width])').forEach(img => {
        if (img.naturalWidth) {
            img.width = img.naturalWidth;
            img.height = img.naturalHeight;
        }
    });

    // Prevent font loading layout shift
    if ('fonts' in document) {
        document.fonts.ready.then(() => {
            document.body.classList.add('fonts-loaded');
        });
    }
}

// Optimize Third-party Scripts
export function optimizeThirdParty() {
    // Delay non-critical third-party scripts
    const delayedScripts = [
        { src: 'https://www.googletagmanager.com/', delay: 3000 },
        { src: 'https://script.advertiserreports.com/', delay: 4000 }
    ];

    delayedScripts.forEach(script => {
        setTimeout(() => {
            const scripts = document.querySelectorAll(`script[src*="${script.src}"]`);
            scripts.forEach(s => {
                if (!s.hasAttribute('data-loaded')) {
                    s.setAttribute('data-loaded', 'true');
                    // Re-insert to trigger loading
                    const newScript = document.createElement('script');
                    newScript.src = s.src;
                    newScript.async = true;
                    document.head.appendChild(newScript);
                }
            });
        }, script.delay);
    });
}

// Reduce JavaScript Execution Time
export function optimizeJavaScript() {
    // Use requestIdleCallback for non-critical tasks
    const nonCriticalTasks = [
        () => initializeAnalytics(),
        () => loadSocialWidgets(),
        () => initializeAnimations()
    ];

    nonCriticalTasks.forEach(task => {
        if ('requestIdleCallback' in window) {
            requestIdleCallback(task, { timeout: 5000 });
        } else {
            setTimeout(task, 1000);
        }
    });
}

// Initialize analytics when idle
function initializeAnalytics() {
    // Check if analytics is already loaded by the deferred script
    if (window.gtag) {
        console.log('Analytics already loaded');
        return;
    }

    // Analytics initialization moved to database seeder for better control
    console.log('Analytics deferred loading active');
}

// Load social widgets when needed
function loadSocialWidgets() {
    // Lazy load social media widgets
    const socialContainers = document.querySelectorAll('.social-widget');
    if (socialContainers.length > 0) {
        // Load social scripts here
    }
}

// Initialize animations efficiently
function initializeAnimations() {
    // Use Intersection Observer for scroll animations
    if ('IntersectionObserver' in window) {
        const animatedElements = document.querySelectorAll('[data-aos]');

        const animationObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('aos-animate');
                    animationObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '50px'
        });

        animatedElements.forEach(el => {
            animationObserver.observe(el);
        });
    }
}

// Progressive Enhancement for Mobile
export function enhanceMobileExperience() {
    // Detect mobile device
    const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

    if (isMobile) {
        // Disable hover effects on mobile
        document.body.classList.add('touch-device');

        // Optimize touch interactions
        document.addEventListener('touchstart', () => {}, { passive: true });

        // Reduce animation complexity
        const animatedElements = document.querySelectorAll('.animate-marquee');
        animatedElements.forEach(el => {
            const duration = el.style.getPropertyValue('--marquee-duration');
            if (duration) {
                // Slow down animations on mobile to reduce CPU usage
                el.style.setProperty('--marquee-duration', '90s');
            }
        });

        // Preload next page on link touch
        let touchedLink = null;
        document.addEventListener('touchstart', (e) => {
            const link = e.target.closest('a');
            if (link && link.href && link.href.startsWith(window.location.origin)) {
                touchedLink = link.href;
                const linkEl = document.createElement('link');
                linkEl.rel = 'prefetch';
                linkEl.href = touchedLink;
                document.head.appendChild(linkEl);
            }
        }, { passive: true });
    }
}

// Resource Hints for faster navigation
export function addResourceHints() {
    // Preconnect to required origins
    const origins = [
        'https://fonts.bunny.net',
        'https://cdn.jsdelivr.net'
    ];

    origins.forEach(origin => {
        const link = document.createElement('link');
        link.rel = 'preconnect';
        link.href = origin;
        link.crossOrigin = 'anonymous';
        document.head.appendChild(link);
    });

    // Prefetch likely next pages
    const likelyPages = [
        '/fencing',
        '/request-a-quote',
        '/contact',
        '/about-us'
    ];

    // Only prefetch on good connections
    if (!isSaveData()) {
        setTimeout(() => {
            likelyPages.forEach(page => {
                const link = document.createElement('link');
                link.rel = 'prefetch';
                link.href = page;
                document.head.appendChild(link);
            });
        }, 5000); // Wait 5 seconds after load
    }
}

// Initialize all optimizations
export function initPerformanceOptimizations() {
    // Run immediately
    preventLayoutShift();
    optimizeImages();

    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            enhanceMobileExperience();
            addResourceHints();
            optimizeJavaScript();
        });
    } else {
        enhanceMobileExperience();
        addResourceHints();
        optimizeJavaScript();
    }

    // Run after page load
    window.addEventListener('load', () => {
        optimizeThirdParty();
    });
}

// Auto-initialize if module is imported
if (typeof window !== 'undefined') {
    initPerformanceOptimizations();
}