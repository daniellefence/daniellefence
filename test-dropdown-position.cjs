const { chromium } = require('playwright');

(async () => {
  console.log('🔍 Testing dropdown position...\n');

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

    // Get dropdown position and viewport info
    const positionInfo = await page.evaluate(() => {
      const dropdown = document.querySelector('div[x-show="showCompany"]');
      const viewport = {
        width: window.innerWidth,
        height: window.innerHeight,
        scrollY: window.scrollY,
        scrollX: window.scrollX
      };

      if (!dropdown) return { error: 'No dropdown' };

      const rect = dropdown.getBoundingClientRect();
      const computed = window.getComputedStyle(dropdown);

      // Check if dropdown is within viewport
      const inViewport = {
        top: rect.top >= 0,
        left: rect.left >= 0,
        bottom: rect.bottom <= viewport.height,
        right: rect.right <= viewport.width,
        fullyVisible: rect.top >= 0 && rect.left >= 0 &&
                      rect.bottom <= viewport.height && rect.right <= viewport.width
      };

      return {
        viewport: viewport,
        dropdownRect: {
          top: rect.top,
          left: rect.left,
          right: rect.right,
          bottom: rect.bottom,
          width: rect.width,
          height: rect.height
        },
        computedStyles: {
          position: computed.position,
          display: computed.display,
          visibility: computed.visibility,
          opacity: computed.opacity,
          transform: computed.transform,
          zIndex: computed.zIndex,
          overflow: computed.overflow,
          clip: computed.clip,
          clipPath: computed.clipPath
        },
        inViewport: inViewport,
        scrollNeeded: {
          toSeeTop: rect.top < 0 ? Math.abs(rect.top) : 0,
          toSeeLeft: rect.left < 0 ? Math.abs(rect.left) : 0,
          toSeeBottom: rect.bottom > viewport.height ? rect.bottom - viewport.height : 0,
          toSeeRight: rect.right > viewport.width ? rect.right - viewport.width : 0
        }
      };
    });

    console.log('\n📊 Dropdown Position Analysis:');
    console.log(JSON.stringify(positionInfo, null, 2));

    // Try scrolling the dropdown into view if needed
    if (!positionInfo.inViewport?.fullyVisible) {
      console.log('\n📜 Dropdown is outside viewport, scrolling into view...');
      await page.evaluate(() => {
        const dropdown = document.querySelector('div[x-show="showCompany"]');
        if (dropdown) {
          dropdown.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
      });

      await page.waitForTimeout(1000);
      await page.screenshot({
        path: '/tmp/dropdown-after-scroll.png',
        fullPage: false
      });
      console.log('📸 Screenshot after scroll saved to /tmp/dropdown-after-scroll.png');
    }

    // Try making dropdown visible with different approach
    console.log('\n🔧 Attempting to make dropdown visible with positioning fix...');
    await page.evaluate(() => {
      const dropdown = document.querySelector('div[x-show="showCompany"]');
      if (dropdown) {
        // Remove x-cloak attribute
        dropdown.removeAttribute('x-cloak');

        // Force position to be visible
        dropdown.style.position = 'fixed';
        dropdown.style.top = '100px';
        dropdown.style.left = '50%';
        dropdown.style.transform = 'translateX(-50%)';
        dropdown.style.zIndex = '99999';
        dropdown.style.display = 'block';
        dropdown.style.visibility = 'visible';
        dropdown.style.opacity = '1';
      }
    });

    await page.screenshot({
      path: '/tmp/dropdown-fixed-position.png',
      fullPage: false
    });
    console.log('📸 Screenshot with fixed position saved to /tmp/dropdown-fixed-position.png');

  } catch (error) {
    console.error('❌ Error:', error.message);
  } finally {
    console.log('\n👀 Browser will stay open for 5 seconds...');
    await page.waitForTimeout(5000);
    await browser.close();
  }
})();