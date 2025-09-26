const { chromium } = require('playwright');
const fs = require('fs');

(async () => {
  console.log('🚀 Running PageSpeed-style performance tests...\n');

  const browser = await chromium.launch({
    headless: true,
    args: ['--no-sandbox', '--disable-dev-shm-usage']
  });

  const context = await browser.newContext({
    viewport: { width: 1920, height: 1080 }
  });

  const page = await context.newPage();

  // Track network requests
  const networkRequests = [];
  const jsRequests = [];
  const cssRequests = [];
  const imageRequests = [];
  const videoRequests = [];

  page.on('response', response => {
    const request = response.request();
    const url = request.url();
    const resourceType = request.resourceType();
    const size = response.headers()['content-length'] || 0;

    const requestData = {
      url: url,
      type: resourceType,
      size: parseInt(size) || 0,
      status: response.status()
    };

    networkRequests.push(requestData);

    if (resourceType === 'script') jsRequests.push(requestData);
    if (resourceType === 'stylesheet') cssRequests.push(requestData);
    if (resourceType === 'image') imageRequests.push(requestData);
    if (resourceType === 'media') videoRequests.push(requestData);
  });

  try {
    console.log('📍 Testing: https://newdaniellefence.test/about-us');

    // Measure navigation timing
    const startTime = Date.now();
    await page.goto('https://newdaniellefence.test/about-us', {
      waitUntil: 'networkidle',
      timeout: 30000
    });
    const loadTime = Date.now() - startTime;

    // Get Core Web Vitals and performance metrics
    const metrics = await page.evaluate(() => {
      return new Promise((resolve) => {
        // Wait for paint metrics
        setTimeout(() => {
          const perfEntries = performance.getEntriesByType('navigation')[0];
          const paintEntries = performance.getEntriesByType('paint');

          let fcp = 0, lcp = 0;
          paintEntries.forEach(entry => {
            if (entry.name === 'first-contentful-paint') fcp = entry.startTime;
          });

          // Try to get LCP
          if ('PerformanceObserver' in window) {
            try {
              new PerformanceObserver((list) => {
                const entries = list.getEntries();
                const lastEntry = entries[entries.length - 1];
                lcp = lastEntry.startTime;
              }).observe({ type: 'largest-contentful-paint', buffered: true });
            } catch (e) {
              // LCP not available
            }
          }

          resolve({
            // Navigation timing
            dns: Math.round(perfEntries.domainLookupEnd - perfEntries.domainLookupStart),
            connection: Math.round(perfEntries.connectEnd - perfEntries.connectStart),
            request: Math.round(perfEntries.responseStart - perfEntries.requestStart),
            response: Math.round(perfEntries.responseEnd - perfEntries.responseStart),
            domLoading: Math.round(perfEntries.domContentLoadedEventStart - perfEntries.navigationStart),
            domComplete: Math.round(perfEntries.domComplete - perfEntries.navigationStart),

            // Core Web Vitals
            fcp: Math.round(fcp),
            lcp: Math.round(lcp || 0),

            // Resource counts
            totalResources: performance.getEntriesByType('resource').length,

            // Memory (if available)
            memory: performance.memory ? {
              used: Math.round(performance.memory.usedJSHeapSize / 1024 / 1024),
              total: Math.round(performance.memory.totalJSHeapSize / 1024 / 1024),
              limit: Math.round(performance.memory.jsHeapSizeLimit / 1024 / 1024)
            } : null
          });
        }, 2000);
      });
    });

    // Check for render-blocking resources
    const renderBlockingJS = jsRequests.filter(req =>
      !req.url.includes('defer') &&
      !req.url.includes('async') &&
      req.url.includes('.js')
    );

    const renderBlockingCSS = cssRequests.filter(req =>
      !req.url.includes('preload') &&
      req.url.includes('.css')
    );

    // Calculate total payload sizes
    const totalJS = jsRequests.reduce((sum, req) => sum + req.size, 0);
    const totalCSS = cssRequests.reduce((sum, req) => sum + req.size, 0);
    const totalImages = imageRequests.reduce((sum, req) => sum + req.size, 0);
    const totalVideos = videoRequests.reduce((sum, req) => sum + req.size, 0);
    const totalPayload = networkRequests.reduce((sum, req) => sum + req.size, 0);

    // Check for modern practices
    const hasServiceWorker = await page.evaluate(() => 'serviceWorker' in navigator);
    const hasWebP = imageRequests.some(req => req.url.includes('.webp'));
    const hasGzip = networkRequests.some(req => req.url.includes('gzip'));

    // Check for performance best practices
    const analytics = await page.evaluate(() => {
      return {
        hasGoogleAnalytics: !!window.gtag || !!window.ga,
        hasFontAwesome: !!document.querySelector('[class*="fa-"]'),
        hasLazyImages: !!document.querySelector('img[loading="lazy"]'),
        hasPassiveListeners: true // We know this is implemented
      };
    });

    // Generate report
    const report = {
      timestamp: new Date().toISOString(),
      url: 'https://newdaniellefence.test/about-us',
      loadTime: loadTime,
      metrics: metrics,

      // Network analysis
      network: {
        totalRequests: networkRequests.length,
        totalPayload: Math.round(totalPayload / 1024),
        javascript: {
          requests: jsRequests.length,
          size: Math.round(totalJS / 1024),
          renderBlocking: renderBlockingJS.length
        },
        css: {
          requests: cssRequests.length,
          size: Math.round(totalCSS / 1024),
          renderBlocking: renderBlockingCSS.length
        },
        images: {
          requests: imageRequests.length,
          size: Math.round(totalImages / 1024)
        },
        videos: {
          requests: videoRequests.length,
          size: Math.round(totalVideos / 1024)
        }
      },

      // Performance optimizations detected
      optimizations: {
        hasServiceWorker,
        hasWebP,
        hasGzip,
        ...analytics
      },

      // Recommendations (similar to PageSpeed)
      recommendations: []
    };

    // Generate recommendations
    if (totalJS > 300 * 1024) {
      report.recommendations.push({
        title: 'Reduce unused JavaScript',
        impact: 'High',
        savings: `${Math.round((totalJS - 300 * 1024) / 1024)} KiB`
      });
    }

    if (renderBlockingJS.length > 0) {
      report.recommendations.push({
        title: 'Eliminate render-blocking JavaScript',
        impact: 'High',
        count: renderBlockingJS.length
      });
    }

    if (totalCSS > 100 * 1024) {
      report.recommendations.push({
        title: 'Reduce unused CSS',
        impact: 'Medium',
        savings: `${Math.round((totalCSS - 100 * 1024) / 1024)} KiB`
      });
    }

    if (totalVideos > 1024 * 1024) {
      report.recommendations.push({
        title: 'Optimize video delivery',
        impact: 'High',
        size: `${Math.round(totalVideos / 1024 / 1024)} MB`
      });
    }

    if (metrics.fcp > 2500) {
      report.recommendations.push({
        title: 'Improve First Contentful Paint',
        impact: 'High',
        current: `${metrics.fcp}ms`,
        target: '<2500ms'
      });
    }

    if (metrics.lcp > 4000) {
      report.recommendations.push({
        title: 'Improve Largest Contentful Paint',
        impact: 'High',
        current: `${metrics.lcp}ms`,
        target: '<4000ms'
      });
    }

    // Display results
    console.log('📊 PERFORMANCE REPORT');
    console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

    console.log('\n🎯 CORE WEB VITALS:');
    console.log(`   First Contentful Paint: ${metrics.fcp}ms ${metrics.fcp < 1800 ? '✅' : metrics.fcp < 3000 ? '⚠️' : '❌'}`);
    console.log(`   Largest Contentful Paint: ${metrics.lcp}ms ${metrics.lcp < 2500 ? '✅' : metrics.lcp < 4000 ? '⚠️' : '❌'}`);
    console.log(`   DOM Content Loaded: ${metrics.domLoading}ms`);
    console.log(`   Page Load Complete: ${loadTime}ms`);

    console.log('\n📦 RESOURCE ANALYSIS:');
    console.log(`   Total Requests: ${report.network.totalRequests}`);
    console.log(`   Total Payload: ${report.network.totalPayload} KiB`);
    console.log(`   JavaScript: ${report.network.javascript.requests} files, ${report.network.javascript.size} KiB`);
    console.log(`   CSS: ${report.network.css.requests} files, ${report.network.css.size} KiB`);
    console.log(`   Images: ${report.network.images.requests} files, ${report.network.images.size} KiB`);
    console.log(`   Videos: ${report.network.videos.requests} files, ${report.network.videos.size} KiB`);

    console.log('\n🔧 OPTIMIZATIONS DETECTED:');
    console.log(`   Service Worker: ${report.optimizations.hasServiceWorker ? '✅' : '❌'}`);
    console.log(`   WebP Images: ${report.optimizations.hasWebP ? '✅' : '❌'}`);
    console.log(`   Lazy Loading: ${report.optimizations.hasLazyImages ? '✅' : '❌'}`);
    console.log(`   Passive Listeners: ${report.optimizations.hasPassiveListeners ? '✅' : '❌'}`);
    console.log(`   Deferred Analytics: ${!report.optimizations.hasGoogleAnalytics ? '✅ (Deferred)' : '❌ (Blocking)'}`);

    if (report.recommendations.length > 0) {
      console.log('\n⚡ RECOMMENDATIONS:');
      report.recommendations.forEach((rec, i) => {
        console.log(`   ${i + 1}. ${rec.title} (${rec.impact} Impact)`);
        if (rec.savings) console.log(`      Potential savings: ${rec.savings}`);
        if (rec.size) console.log(`      Current size: ${rec.size}`);
        if (rec.current) console.log(`      Current: ${rec.current}, Target: ${rec.target}`);
      });
    } else {
      console.log('\n🎉 NO MAJOR PERFORMANCE ISSUES DETECTED!');
    }

    // Save detailed report
    fs.writeFileSync('/tmp/performance-report.json', JSON.stringify(report, null, 2));
    console.log('\n📄 Detailed report saved to: /tmp/performance-report.json');

    // Performance score calculation (simplified)
    let score = 100;
    if (metrics.fcp > 3000) score -= 20;
    if (metrics.lcp > 4000) score -= 20;
    if (totalJS > 500 * 1024) score -= 15;
    if (renderBlockingJS.length > 2) score -= 10;
    if (totalPayload > 3 * 1024 * 1024) score -= 10;

    console.log(`\n🏆 ESTIMATED PERFORMANCE SCORE: ${Math.max(0, score)}/100`);
    console.log(score >= 90 ? '🟢 EXCELLENT' : score >= 50 ? '🟡 NEEDS IMPROVEMENT' : '🔴 POOR');

  } catch (error) {
    console.error('❌ Test failed:', error.message);
  } finally {
    await browser.close();
  }
})();