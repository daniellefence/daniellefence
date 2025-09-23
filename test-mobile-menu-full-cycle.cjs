const puppeteer = require('puppeteer');

(async () => {
  let browser;
  try {
    console.log('Testing mobile menu full open/close cycle...');
    browser = await puppeteer.launch({
      headless: false,
      executablePath: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome',
      args: ['--no-sandbox', '--disable-setuid-sandbox']
    });

    const page = await browser.newPage();
    await page.setViewport({ width: 375, height: 667 });

    await page.goto('https://newdaniellefence.test', {
      waitUntil: 'networkidle2',
      timeout: 30000
    });

    // Wait for Alpine.js
    await new Promise(resolve => setTimeout(resolve, 2000));

    // Test initial state (should be hidden)
    console.log('=== Testing Initial State ===');
    const initialState = await page.evaluate(() => {
      const backdrop = document.querySelector('div[x-show="showMobile"]:first-child');
      const panel = document.querySelector('div[x-show="showMobile"]:last-child');
      return {
        backdrop: backdrop ? window.getComputedStyle(backdrop).display : 'not found',
        panel: panel ? window.getComputedStyle(panel).display : 'not found'
      };
    });
    console.log('Initial state - Backdrop:', initialState.backdrop, 'Panel:', initialState.panel);

    // Click to open menu
    console.log('=== Clicking to Open Menu ===');
    const mobileButton = await page.$('button .fa-bars');
    const buttonElement = await mobileButton.evaluateHandle(el => el.closest('button'));
    await buttonElement.click();

    // Wait for animation
    await new Promise(resolve => setTimeout(resolve, 500));

    // Check opened state
    const openedState = await page.evaluate(() => {
      const menuDialog = document.querySelector('div[role="dialog"][aria-label="Menu"]');
      const backdrop = menuDialog ? menuDialog.querySelector('div[x-show="showMobile"]:nth-child(1)') : null;
      const panel = menuDialog ? menuDialog.querySelector('div[x-show="showMobile"]:nth-child(2)') : null;

      // Also check Alpine data
      const alpineContainer = document.querySelector('[x-data*="showMobile"]');
      let showMobileValue = null;
      if (alpineContainer && window.Alpine) {
        try {
          const data = window.Alpine.$data(alpineContainer);
          showMobileValue = data.showMobile;
        } catch (e) {
          showMobileValue = 'error: ' + e.message;
        }
      }

      return {
        backdrop: backdrop ? window.getComputedStyle(backdrop).display : 'not found',
        panel: panel ? window.getComputedStyle(panel).display : 'not found',
        showMobileValue: showMobileValue
      };
    });
    console.log('Opened state - Backdrop:', openedState.backdrop, 'Panel:', openedState.panel, 'Alpine showMobile:', openedState.showMobileValue);

    // Click close button (use fa-times icon inside button)
    console.log('=== Clicking Close Button ===');
    await page.click('button .fa-times');

    // Wait for animation
    await new Promise(resolve => setTimeout(resolve, 500));

    // Check closed state
    const closedState = await page.evaluate(() => {
      const backdrop = document.querySelector('div[x-show="showMobile"]:first-child');
      const panel = document.querySelector('div[x-show="showMobile"]:last-child');
      return {
        backdrop: backdrop ? window.getComputedStyle(backdrop).display : 'not found',
        panel: panel ? window.getComputedStyle(panel).display : 'not found'
      };
    });
    console.log('Closed state - Backdrop:', closedState.backdrop, 'Panel:', closedState.panel);

    console.log('=== Test Results ===');
    console.log('✅ Initial state hidden:', initialState.backdrop === 'none' && initialState.panel === 'none');
    console.log('✅ Opens correctly:', openedState.backdrop === 'block' && openedState.panel === 'block');
    console.log('✅ Closes correctly:', closedState.backdrop === 'none' && closedState.panel === 'none');

  } catch (error) {
    console.error('Error:', error.message);
  } finally {
    if (browser) {
      await browser.close();
    }
  }
})();