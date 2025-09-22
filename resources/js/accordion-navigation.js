// Accordion navigation - only one group open at a time
document.addEventListener('DOMContentLoaded', function() {
    // Wait for Livewire to load
    document.addEventListener('livewire:navigated', setupAccordion);
    setupAccordion();
});

function setupAccordion() {
    // Find all collapsible navigation group headers
    const groupToggles = document.querySelectorAll('[x-data] [x-on\\:click]');

    groupToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            // Small delay to let Filament's own toggle logic run first
            setTimeout(() => {
                const currentGroup = this.closest('[x-data*="group"]');
                if (!currentGroup) return;

                // Check if this group was just opened
                const isExpanded = currentGroup.querySelector('[x-show]')?.style.display !== 'none';

                if (isExpanded) {
                    // Close all other groups
                    const allGroups = document.querySelectorAll('[x-data*="group"]');
                    allGroups.forEach(group => {
                        if (group !== currentGroup) {
                            const groupContent = group.querySelector('[x-show]');
                            const groupButton = group.querySelector('[x-on\\:click]');

                            if (groupContent && groupButton) {
                                // Trigger the Alpine.js close behavior
                                groupButton.click();
                            }
                        }
                    });
                }
            }, 10);
        });
    });
}