const { chromium } = require('playwright');

(async () => {
  console.log('🔍 Testing dropdown visibility issue...\n');

  const browser = await chromium.launch({ headless: false });
  const context = await browser.newContext({
    viewport: { width: 1920, height: 1080 }
  });
  const page = await context.newPage();

  try {
    // Navigate to About Us page
    console.log('📍 Navigating to About Us page...');
    await page.goto('https://newdaniellefence.test/about-us');
    await page.waitForLoadState('networkidle');

    // Click Company dropdown
    console.log('🖱️ Clicking Company dropdown...');
    await page.click('button:has-text("Company")');
    await page.waitForTimeout(500);

    // Check dropdown visibility and position
    const dropdownInfo = await page.evaluate(() => {
      const dropdown = document.querySelector('div[x-show="showCompany"]');
      const hero = document.querySelector('.relative.overflow-hidden, section.relative.overflow-hidden');
      const header = document.querySelector('header');

      if (dropdown) {
        const dropdownRect = dropdown.getBoundingClientRect();
        const dropdownStyles = window.getComputedStyle(dropdown);

        // Check what element is at the dropdown's position
        const elementAtDropdown = document.elementFromPoint(
          dropdownRect.left + 50,
          dropdownRect.top + 50
        );

        let heroZIndex = 'none';
        let heroPosition = 'none';
        if (hero) {
          const heroStyles = window.getComputedStyle(hero);
          heroZIndex = heroStyles.zIndex;
          heroPosition = heroStyles.position;
        }

        return {
          dropdownExists: true,
          dropdownDisplay: dropdownStyles.display,
          dropdownVisibility: dropdownStyles.visibility,
          dropdownOpacity: dropdownStyles.opacity,
          dropdownZIndex: dropdownStyles.zIndex,
          dropdownPosition: dropdownStyles.position,
          dropdownRect: {
            top: dropdownRect.top,
            left: dropdownRect.left,
            width: dropdownRect.width,
            height: dropdownRect.height
          },
          elementAtDropdown: elementAtDropdown ? elementAtDropdown.tagName + '.' + elementAtDropdown.className : 'null',
          heroZIndex: heroZIndex,
          heroPosition: heroPosition,
          headerZIndex: window.getComputedStyle(header).zIndex
        };
      }
      return { dropdownExists: false };
    });

    console.log('\n📊 Dropdown Analysis:');
    console.log(JSON.stringify(dropdownInfo, null, 2));

    // Try to force the dropdown to be visible
    console.log('\n🔧 Attempting to force dropdown visibility...');
    await page.evaluate(() => {
      const dropdown = document.querySelector('div[x-show="showCompany"]');
      if (dropdown) {
        dropdown.style.zIndex = '9999';
        dropdown.style.position = 'fixed';
      }
    });

    await page.screenshot({
      path: '/tmp/dropdown-forced.png',
      fullPage: false
    });
    console.log('📸 Screenshot with forced z-index saved to /tmp/dropdown-forced.png');

  } catch (error) {
    console.error('❌ Error:', error.message);
  } finally {
    console.log('\n👀 Browser will stay open for inspection...');
    await page.waitForTimeout(10000);
    await browser.close();
  }
})();