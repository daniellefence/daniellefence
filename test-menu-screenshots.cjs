const { chromium } = require('playwright');

(async () => {
  console.log('🔍 Testing menu z-index with screenshots...\n');

  const browser = await chromium.launch({ headless: false });
  const context = await browser.newContext({
    viewport: { width: 1920, height: 1080 }
  });
  const page = await context.newPage();

  try {
    // Test 1: Product page with hero
    console.log('📍 Test 1: Product page menu dropdown');
    await page.goto('https://newdaniellefence.test/fencing/wood-fence/wood-board-on-board-fence');
    await page.waitForLoadState('networkidle');

    // Open Products dropdown
    await page.click('button:has-text("Products")');
    await page.waitForTimeout(500);

    await page.screenshot({
      path: '/tmp/test1-product-page-menu.png',
      fullPage: false
    });
    console.log('✅ Screenshot saved: /tmp/test1-product-page-menu.png');

    // Test 2: About Us page with hero background
    console.log('\n📍 Test 2: About Us page with hero background');
    await page.goto('https://newdaniellefence.test/about-us');
    await page.waitForLoadState('networkidle');

    // Open Company dropdown
    await page.click('button:has-text("Company")');
    await page.waitForTimeout(500);

    await page.screenshot({
      path: '/tmp/test2-about-menu.png',
      fullPage: false
    });
    console.log('✅ Screenshot saved: /tmp/test2-about-menu.png');

    // Test 3: Home page hero section
    console.log('\n📍 Test 3: Home page hero section');
    await page.goto('https://newdaniellefence.test');
    await page.waitForLoadState('networkidle');

    // Open Services dropdown
    await page.click('button:has-text("Services")');
    await page.waitForTimeout(500);

    await page.screenshot({
      path: '/tmp/test3-home-menu.png',
      fullPage: false
    });
    console.log('✅ Screenshot saved: /tmp/test3-home-menu.png');

    // Test 4: FAQ page
    console.log('\n📍 Test 4: FAQ page');
    await page.goto('https://newdaniellefence.test/faq');
    await page.waitForLoadState('networkidle');

    // Open Products dropdown
    await page.click('button:has-text("Products")');
    await page.waitForTimeout(500);

    await page.screenshot({
      path: '/tmp/test4-faq-menu.png',
      fullPage: false
    });
    console.log('✅ Screenshot saved: /tmp/test4-faq-menu.png');

    console.log('\n✨ All screenshots captured successfully!');
    console.log('\n📸 Screenshots saved to:');
    console.log('   - /tmp/test1-product-page-menu.png');
    console.log('   - /tmp/test2-about-menu.png');
    console.log('   - /tmp/test3-home-menu.png');
    console.log('   - /tmp/test4-faq-menu.png');

    console.log('\n🎯 Check these screenshots to verify the menu dropdowns appear above hero sections.');

  } catch (error) {
    console.error('❌ Test failed:', error.message);
  } finally {
    console.log('\n👀 Browser will stay open for 10 seconds for inspection...');
    await page.waitForTimeout(10000);
    await browser.close();
  }
})();