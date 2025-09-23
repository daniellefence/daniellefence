// Test script to run in browser console
console.log('Testing mobile menu...');

// Find the mobile menu button
const button = document.querySelector('button[aria-label="Open main menu"], button .fa-bars').closest('button');
if (button) {
    console.log('Found mobile menu button:', button);

    // Simulate click
    button.click();
    console.log('Button clicked');

    // Wait a moment then check if menu is visible
    setTimeout(() => {
        const mobileMenu = document.querySelector('div[role="dialog"][aria-label="Menu"]');
        if (mobileMenu) {
            const backdrop = mobileMenu.querySelector('div[x-show="showMobile"]:first-child');
            const panel = mobileMenu.querySelector('div[x-show="showMobile"]:last-child');

            console.log('Mobile menu container found:', mobileMenu);
            console.log('Backdrop display:', backdrop ? getComputedStyle(backdrop).display : 'not found');
            console.log('Panel display:', panel ? getComputedStyle(panel).display : 'not found');

            // Check Alpine.js data
            const alpineData = mobileMenu.closest('[x-data]');
            if (alpineData && window.Alpine) {
                console.log('Alpine data:', window.Alpine.evaluate(alpineData, '{ showMobile }'));
            }
        } else {
            console.log('Mobile menu container not found');
        }
    }, 500);
} else {
    console.log('Mobile menu button not found');
    // List all buttons for debugging
    document.querySelectorAll('button').forEach((btn, i) => {
        console.log(`Button ${i}:`, btn.outerHTML.substring(0, 100));
    });
}