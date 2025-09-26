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

            // Multiple strategies to find and update the editor
            let updated = false;

            // Strategy 1: Find by field name using Alpine.js directive
            const fieldWrapper = document.querySelector(`[x-data][x-data*="${fieldName}"]`) ||
                                document.querySelector(`[data-field-wrapper="${fieldName}"]`);

            if (fieldWrapper) {

                // Look for TipTap editor
                const proseMirror = fieldWrapper.querySelector('.ProseMirror');
                if (proseMirror) {

                    // Try to get editor instance
                    if (proseMirror.__editor) {
                        proseMirror.__editor.commands.setContent(data.content);
                        updated = true;
                    } else if (window.editor) {
                        window.editor.commands.setContent(data.content);
                        updated = true;
                    }
                }
            }

            // Strategy 2: Use Livewire to update the field directly
            if (!updated) {
                const livewireComponent = document.querySelector('[wire\\:id]');
                if (livewireComponent && window.Livewire) {
                    const componentId = livewireComponent.getAttribute('wire:id');
                    const component = window.Livewire.find(componentId);
                    if (component) {
                        component.set(fieldName, data.content);
                        updated = true;
                    }
                }
            }

            // Strategy 3: Try Alpine.js if available
            if (!updated && window.Alpine) {
                const alpineComponent = document.querySelector(`[x-data]`);
                if (alpineComponent && alpineComponent._x_dataStack) {
                    const alpineData = alpineComponent._x_dataStack[0];
                    if (alpineData && typeof alpineData[fieldName] !== 'undefined') {
                        alpineData[fieldName] = data.content;
                        updated = true;
                    }
                }
            }

            if (updated) {
                alert('Content generated successfully!');
            } else {
                alert('Content generated, but could not update editor automatically. Please paste manually: ' + data.content);
            }
        } else {
            const errorData = await response.json();
            throw new Error(errorData.error || 'Failed to generate content');
        }
    } catch (error) {
        alert('Error generating content: ' + error.message);
    }
}

// Make functions globally available
window.openChatGPTModal = openChatGPTModal;
window.generateChatGPTContent = generateChatGPTContent;

</script>