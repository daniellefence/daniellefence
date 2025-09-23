const puppeteer = require('puppeteer');

(async () => {
  let browser;
  try {
    console.log('Launching browser...');
    browser = await puppeteer.launch({
      headless: false,
      executablePath: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome',
      args: ['--no-sandbox', '--disable-setuid-sandbox', '--ignore-certificate-errors']
    });

    const page = await browser.newPage();

    // Listen for console messages from the page
    page.on('console', msg => {
      console.log('BROWSER CONSOLE:', msg.text());
    });

    // Set viewport to mobile size to test mobile menu
    await page.setViewport({ width: 375, height: 667 });

    console.log('Navigating to site...');
    await page.goto('https://newdaniellefence.test', {
      waitUntil: 'networkidle2',
      timeout: 30000
    });

    // Wait for Alpine.js to load
    await new Promise(resolve => setTimeout(resolve, 2000));

    console.log('Looking for mobile menu button...');
    // Find the mobile menu button (hamburger icon)
    const mobileButton = await page.$('button .fa-bars');
    if (!mobileButton) {
      console.log('Mobile menu button not found');
      await browser.close();
      return;
    }

    const buttonElement = await mobileButton.evaluateHandle(el => el.closest('button'));
    console.log('Found mobile menu button, clicking...');

    // Click the mobile menu button
    await buttonElement.click();

    // Wait for animations
    await new Promise(resolve => setTimeout(resolve, 1000));

    console.log('Checking mobile menu visibility...');

    // Load and run our Alpine state test
    const testScript = require('fs').readFileSync('./test-alpine-state.js', 'utf8');
    await page.evaluate(testScript);

    // Wait for the test to complete
    await new Promise(resolve => setTimeout(resolve, 2000));

    // Check if mobile menu is visible
    const mobileMenuResult = await page.evaluate(() => {
      const menuDialog = document.querySelector('div[role="dialog"][aria-label="Menu"]');
      if (!menuDialog) return { found: false, error: 'Menu dialog not found' };

      const backdrop = menuDialog.querySelector('div[x-show="showMobile"]:first-child');
      const panel = menuDialog.querySelector('div[x-show="showMobile"]:nth-child(2)');

      const results = {
        found: true,
        backdropDisplay: backdrop ? window.getComputedStyle(backdrop).display : 'not found',
        backdropOpacity: backdrop ? window.getComputedStyle(backdrop).opacity : 'not found',
        panelDisplay: panel ? window.getComputedStyle(panel).display : 'not found',
        panelTransform: panel ? window.getComputedStyle(panel).transform : 'not found',
        alpineData: null
      };

      // Check Alpine.js data
      const alpineContainer = menuDialog.closest('[x-data]');
      if (alpineContainer && window.Alpine) {
        try {
          results.alpineData = window.Alpine.$data(alpineContainer);
        } catch (e) {
          results.alpineData = 'Error accessing Alpine data: ' + e.message;
        }
      }

      return results;
    });

    console.log('Mobile menu test results:', JSON.stringify(mobileMenuResult, null, 2));

    // Take a screenshot for visual verification
    await page.screenshot({ path: '/Users/shanebarron/Herd/newdaniellefence/mobile-menu-test.png' });
    console.log('Screenshot saved to mobile-menu-test.png');

  } catch (error) {
    console.error('Error:', error.message);
  } finally {
    if (browser) {
      await browser.close();
    }
  }
})();