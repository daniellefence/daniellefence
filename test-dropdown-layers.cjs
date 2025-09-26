const { chromium } = require('playwright');

(async () => {
  console.log('🔍 Analyzing layer stacking issues...\n');

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

    // Comprehensive analysis
    const analysis = await page.evaluate(() => {
      const dropdown = document.querySelector('div[x-show="showCompany"]');
      const header = document.querySelector('header');
      const hero = document.querySelector('section.relative.overflow-hidden');
      const heroContent = document.querySelector('.relative.z-10.py-24');

      if (!dropdown) return { error: 'No dropdown found' };

      // Get all elements in the stacking order
      const elements = [];

      // Check what's at various z-levels
      const testPoints = [
        { x: window.innerWidth / 2, y: 150, label: 'dropdown-area' },
        { x: window.innerWidth / 2, y: 300, label: 'hero-area' }
      ];

      const zLayers = {};
      testPoints.forEach(point => {
        const elem = document.elementFromPoint(point.x, point.y);
        if (elem) {
          const computed = window.getComputedStyle(elem);
          zLayers[point.label] = {
            element: elem.tagName + '.' + elem.className.substring(0, 50),
            zIndex: computed.zIndex,
            position: computed.position,
            parent: elem.parentElement ? elem.parentElement.tagName : 'none'
          };
        }
      });

      // Check all ancestors of dropdown for potential issues
      const ancestors = [];
      let current = dropdown;
      while (current && current !== document.body) {
        const styles = window.getComputedStyle(current);
        ancestors.push({
          tag: current.tagName,
          class: current.className ? current.className.substring(0, 50) : '',
          zIndex: styles.zIndex,
          position: styles.position,
          overflow: styles.overflow,
          transform: styles.transform !== 'none' ? 'yes' : 'no',
          opacity: styles.opacity,
          filter: styles.filter !== 'none' ? 'yes' : 'no',
          willChange: styles.willChange,
          contain: styles.contain
        });
        current = current.parentElement;
      }

      // Check if dropdown is actually being rendered
      const dropdownRect = dropdown.getBoundingClientRect();
      const dropdownComputed = window.getComputedStyle(dropdown);

      // Check for CSS transforms creating new stacking contexts
      const headerComputed = header ? window.getComputedStyle(header) : null;
      const heroComputed = hero ? window.getComputedStyle(hero) : null;

      return {
        dropdown: {
          exists: true,
          rect: dropdownRect,
          display: dropdownComputed.display,
          visibility: dropdownComputed.visibility,
          zIndex: dropdownComputed.zIndex,
          position: dropdownComputed.position,
          opacity: dropdownComputed.opacity,
          transform: dropdownComputed.transform,
          hasXCloak: dropdown.hasAttribute('x-cloak'),
          innerHTML: dropdown.innerHTML ? 'Has content' : 'Empty'
        },
        header: {
          zIndex: headerComputed?.zIndex,
          position: headerComputed?.position,
          transform: headerComputed?.transform,
          filter: headerComputed?.filter,
          contain: headerComputed?.contain
        },
        hero: {
          exists: !!hero,
          zIndex: heroComputed?.zIndex,
          position: heroComputed?.position,
          overflow: heroComputed?.overflow,
          transform: heroComputed?.transform
        },
        heroContent: {
          exists: !!heroContent,
          zIndex: heroContent ? window.getComputedStyle(heroContent).zIndex : 'none'
        },
        zLayers: zLayers,
        ancestors: ancestors
      };
    });

    console.log('\n📊 Complete Analysis:');
    console.log(JSON.stringify(analysis, null, 2));

    // Try to identify the exact blocking element
    console.log('\n🎯 Checking what\'s blocking the dropdown...');
    const blockingCheck = await page.evaluate(() => {
      const dropdown = document.querySelector('div[x-show="showCompany"]');
      if (!dropdown) return null;

      // Get dropdown bounds
      const dropdownRect = dropdown.getBoundingClientRect();

      // Hide the dropdown temporarily
      const originalDisplay = dropdown.style.display;
      dropdown.style.display = 'none';

      // Check what's at the dropdown position
      const elementBehind = document.elementFromPoint(
        dropdownRect.left + dropdownRect.width / 2,
        dropdownRect.top + 50
      );

      // Restore dropdown
      dropdown.style.display = originalDisplay;

      if (elementBehind) {
        const computed = window.getComputedStyle(elementBehind);
        return {
          blocking: elementBehind.tagName + '.' + elementBehind.className.substring(0, 100),
          zIndex: computed.zIndex,
          position: computed.position,
          parent: elementBehind.parentElement ? elementBehind.parentElement.tagName : 'none'
        };
      }
      return null;
    });

    console.log('\n🚫 Element at dropdown position when hidden:');
    console.log(JSON.stringify(blockingCheck, null, 2));

  } catch (error) {
    console.error('❌ Error:', error.message);
  } finally {
    await browser.close();
  }
})();