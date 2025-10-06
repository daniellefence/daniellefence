<script>
/**
 * ChatGPT Integration for Filament Rich Editor
 */

function openChatGPTModal(fieldName) {
    // Create a simple prompt dialog
    const prompt = window.prompt("Enter your ChatGPT prompt:", "Write professional content for this field...");

    if (prompt) {
        generateChatGPTContent(fieldName, prompt);
    }
}

async function generateChatGPTContent(fieldName, prompt) {
    try {
        const response = await fetch('/api/chatgpt-generate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                prompt: prompt,
                tone: 'professional',
                length: 'medium'
            })
        });

        if (response.ok) {
            const data = await response.json();
            let updated = false;

            // Wait for DOM to be ready
            await new Promise(resolve => setTimeout(resolve, 200));

            // Strategy 1: Find the TipTap editor using the ProseMirror class
            const allEditors = document.querySelectorAll('.ProseMirror');

            for (let editorElement of allEditors) {
                try {
                    // Try to find the Alpine component
                    let alpineEl = editorElement.closest('[x-data]');

                    if (alpineEl && window.Alpine) {
                        // Get Alpine data
                        const alpineData = window.Alpine.$data(alpineEl);

                        if (alpineData && alpineData.editor && typeof alpineData.editor.commands !== 'undefined') {
                            // Update via TipTap editor commands
                            alpineData.editor.commands.setContent(data.content);

                            // Also update the state if it exists
                            if (typeof alpineData.state !== 'undefined') {
                                alpineData.state = data.content;
                            }

                            updated = true;
                            break;
                        }
                    }
                } catch (e) {
                    console.log('Editor update attempt failed:', e);
                    continue;
                }
            }

            // Strategy 2: Try using Livewire's wire:model
            if (!updated) {
                try {
                    // Find the form element
                    const formElement = document.querySelector('form');
                    if (formElement && window.Livewire) {
                        const livewireComponent = window.Livewire.find(formElement.closest('[wire\\:id]')?.getAttribute('wire:id'));

                        if (livewireComponent && livewireComponent.set) {
                            livewireComponent.set('data.' + fieldName, data.content);
                            updated = true;
                        }
                    }
                } catch (e) {
                    console.log('Livewire update failed:', e);
                }
            }

            if (updated) {
                // Show success message
                alert('✅ Content generated successfully!');
            } else {
                // Fallback: copy to clipboard
                const textContent = data.content.replace(/<[^>]*>/g, '');
                navigator.clipboard.writeText(textContent).then(() => {
                    alert('📋 Content copied to clipboard! Paste it into the editor (Ctrl/Cmd+V)');
                }).catch(() => {
                    alert('⚠️ Content generated but could not update editor automatically. Please copy manually:\n\n' + textContent.substring(0, 200) + '...');
                });
            }
        } else {
            const errorData = await response.json();
            throw new Error(errorData.error || 'Failed to generate content');
        }
    } catch (error) {
        alert('❌ Error: ' + error.message);
        console.error('ChatGPT Error:', error);
    }
}

// Make functions globally available
window.openChatGPTModal = openChatGPTModal;
window.generateChatGPTContent = generateChatGPTContent;

</script>