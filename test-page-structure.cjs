const { chromium } = require('playwright');

(async () => {
  console.log('🔍 Checking page structure...\n');

  const browser = await chromium.launch({ headless: false });
  const context = await browser.newContext({
    viewport: { width: 1920, height: 1080 }
  });
  const page = await context.newPage();

  try {
    console.log('📍 Navigating to About Us page...');
    await page.goto('https://newdaniellefence.test/about-us');
    await page.waitForLoadState('networkidle');

    // Get page structure
    const structure = await page.evaluate(() => {
      const header = document.querySelector('header');
      const hero = document.querySelector('section.relative.overflow-hidden');
      const dropdown = document.querySelector('[x-show="showCompany"]');

      // Find where header is in the DOM
      let headerParent = header ? header.parentElement : null;
      let heroParent = hero ? hero.parentElement : null;

      // Check if header is inside or outside main content
      const headerInMain = header ? header.closest('main') : null;
      const heroInMain = hero ? hero.closest('main') : null;

      // Get body children structure
      const bodyChildren = [];
      for (let child of document.body.children) {
        if (child.tagName) {
          bodyChildren.push({
            tag: child.tagName,
            class: child.className,
            id: child.id,
            hasHeader: child.contains(header),
            hasHero: child.contains(hero)
          });
        }
      }

      return {
        headerLocation: {
          exists: !!header,
          parent: headerParent ? headerParent.tagName + '.' + headerParent.className : 'null',
          inMain: !!headerInMain,
          zIndex: header ? window.getComputedStyle(header).zIndex : 'N/A'
        },
        heroLocation: {
          exists: !!hero,
          parent: heroParent ? heroParent.tagName + '.' + heroParent.className : 'null',
          inMain: !!heroInMain,
          overflow: hero ? window.getComputedStyle(hero).overflow : 'N/A',
          zIndex: hero ? window.getComputedStyle(hero).zIndex : 'N/A'
        },
        dropdownLocation: {
          exists: !!dropdown,
          parent: dropdown ? dropdown.parentElement.tagName : 'null'
        },
        bodyStructure: bodyChildren
      };
    });

    console.log('\n📊 Page Structure:');
    console.log(JSON.stringify(structure, null, 2));

    // Try clicking dropdown and checking what's blocking it
    console.log('\n🖱️ Testing dropdown interaction...');
    await page.click('button:has-text("Company")');
    await page.waitForTimeout(500);

    const blockingElement = await page.evaluate(() => {
      const dropdown = document.querySelector('[x-show="showCompany"]');
      if (!dropdown) return { error: 'No dropdown found' };

      const rect = dropdown.getBoundingClientRect();

      // Check multiple points in the dropdown
      const points = [
        { x: rect.left + 10, y: rect.top + 10, label: 'top-left' },
        { x: rect.left + rect.width/2, y: rect.top + 10, label: 'top-center' },
        { x: rect.left + rect.width - 10, y: rect.top + 10, label: 'top-right' },
        { x: rect.left + rect.width/2, y: rect.top + rect.height/2, label: 'center' }
      ];

      const results = points.map(point => {
        const element = document.elementFromPoint(point.x, point.y);
        return {
          point: point.label,
          element: element ? element.tagName + '.' + element.className : 'null',
          isDropdown: element ? dropdown.contains(element) : false
        };
      });

      return {
        dropdownRect: rect,
        pointChecks: results
      };
    });

    console.log('\n🎯 Element blocking check:');
    console.log(JSON.stringify(blockingElement, null, 2));

  } catch (error) {
    console.error('❌ Error:', error.message);
  } finally {
    await browser.close();
  }
})();