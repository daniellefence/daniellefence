const { chromium } = require('playwright');

(async () => {
  console.log('🔍 Deep debugging dropdown visibility...\n');

  const browser = await chromium.launch({ headless: false });
  const context = await browser.newContext({
    viewport: { width: 1920, height: 1080 }
  });
  const page = await context.newPage();

  try {
    console.log('📍 Navigating to About Us page...');
    await page.goto('https://newdaniellefence.test/about-us');
    await page.waitForLoadState('networkidle');

    // Click Company dropdown
    console.log('🖱️ Clicking Company dropdown...');
    await page.click('button:has-text("Company")');
    await page.waitForTimeout(500);

    // Debug all parent elements
    const debugInfo = await page.evaluate(() => {
      const dropdown = document.querySelector('div[x-show="showCompany"]');
      if (!dropdown) return { error: 'Dropdown not found' };

      // Check all parent elements for overflow
      const parents = [];
      let current = dropdown.parentElement;
      while (current && current !== document.body) {
        const styles = window.getComputedStyle(current);
        parents.push({
          tag: current.tagName,
          class: current.className,
          overflow: styles.overflow,
          overflowX: styles.overflowX,
          overflowY: styles.overflowY,
          position: styles.position,
          zIndex: styles.zIndex,
          display: styles.display,
          visibility: styles.visibility,
          opacity: styles.opacity,
          clip: styles.clip,
          clipPath: styles.clipPath
        });
        current = current.parentElement;
      }

      // Check dropdown computed styles
      const dropdownStyles = window.getComputedStyle(dropdown);

      // Check if Alpine.js is hiding it
      const xShowValue = dropdown.getAttribute('x-show');
      const xDataElement = dropdown.closest('[x-data]');
      let alpineData = null;
      if (xDataElement && window.Alpine) {
        alpineData = Alpine.$data(xDataElement);
      }

      return {
        dropdown: {
          tag: dropdown.tagName,
          class: dropdown.className,
          xShow: xShowValue,
          display: dropdownStyles.display,
          visibility: dropdownStyles.visibility,
          opacity: dropdownStyles.opacity,
          position: dropdownStyles.position,
          zIndex: dropdownStyles.zIndex,
          overflow: dropdownStyles.overflow,
          transform: dropdownStyles.transform,
          pointerEvents: dropdownStyles.pointerEvents,
          innerHTML: dropdown.innerHTML.substring(0, 200) + '...'
        },
        alpineData: alpineData,
        parents: parents
      };
    });

    console.log('\n📊 Debug Information:');
    console.log(JSON.stringify(debugInfo, null, 2));

    // Try different fix approaches
    console.log('\n🔧 Attempting comprehensive fix...');
    await page.evaluate(() => {
      const dropdown = document.querySelector('div[x-show="showCompany"]');
      if (dropdown) {
        // Force visibility
        dropdown.style.cssText = `
          display: block !important;
          visibility: visible !important;
          opacity: 1 !important;
          z-index: 99999 !important;
          position: fixed !important;
          top: 100px !important;
          left: 50% !important;
          transform: translateX(-50%) !important;
          background: white !important;
          border: 2px solid red !important;
          padding: 20px !important;
        `;

        // Remove any clipping from parents
        let current = dropdown.parentElement;
        while (current && current !== document.body) {
          current.style.overflow = 'visible';
          current.style.clipPath = 'none';
          current.style.clip = 'auto';
          current = current.parentElement;
        }
      }
    });

    await page.screenshot({
      path: '/tmp/dropdown-comprehensive-fix.png',
      fullPage: false
    });
    console.log('📸 Screenshot with comprehensive fix saved to /tmp/dropdown-comprehensive-fix.png');

  } catch (error) {
    console.error('❌ Error:', error.message);
  } finally {
    console.log('\n👀 Browser will stay open for 5 seconds...');
    await page.waitForTimeout(5000);
    await browser.close();
  }
})();