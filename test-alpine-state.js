// Browser console test for Alpine.js state
console.log('=== Alpine.js State Test ===');

// Check if Alpine.js is loaded
console.log('Alpine available:', !!window.Alpine);

// Find the Alpine component
const alpineContainer = document.querySelector('[x-data*="showMobile"]');
console.log('Alpine container found:', !!alpineContainer);

if (alpineContainer) {
    console.log('Container HTML:', alpineContainer.outerHTML.substring(0, 200));

    // Check Alpine data
    if (window.Alpine) {
        try {
            const data = window.Alpine.$data(alpineContainer);
            console.log('Alpine data:', data);
        } catch (e) {
            console.log('Error accessing Alpine data:', e.message);
        }
    }

    // Check mobile menu elements
    const backdrop = document.querySelector('div[x-show="showMobile"]:first-child');
    const panel = document.querySelector('div[x-show="showMobile"]:last-child');

    console.log('Backdrop element:', !!backdrop);
    console.log('Panel element:', !!panel);

    if (backdrop) {
        const backdropStyles = window.getComputedStyle(backdrop);
        console.log('Backdrop display:', backdropStyles.display);
        console.log('Backdrop opacity:', backdropStyles.opacity);
        console.log('Backdrop visibility:', backdropStyles.visibility);
    }

    if (panel) {
        const panelStyles = window.getComputedStyle(panel);
        console.log('Panel display:', panelStyles.display);
        console.log('Panel transform:', panelStyles.transform);
        console.log('Panel visibility:', panelStyles.visibility);
    }
}

// Test manual state change
console.log('Testing manual state change...');
setTimeout(() => {
    if (alpineContainer && window.Alpine) {
        try {
            // Try to manually set showMobile to false
            const data = window.Alpine.$data(alpineContainer);
            console.log('Before change - showMobile:', data.showMobile);
            data.showMobile = false;
            console.log('After setting false - showMobile:', data.showMobile);

            setTimeout(() => {
                const backdrop = document.querySelector('div[x-show="showMobile"]:first-child');
                const panel = document.querySelector('div[x-show="showMobile"]:last-child');
                console.log('After change - Backdrop display:', backdrop ? window.getComputedStyle(backdrop).display : 'not found');
                console.log('After change - Panel display:', panel ? window.getComputedStyle(panel).display : 'not found');
            }, 100);
        } catch (e) {
            console.log('Error testing state change:', e.message);
        }
    }
}, 1000);