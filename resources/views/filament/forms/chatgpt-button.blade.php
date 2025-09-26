<div class="mb-2">
    <button
        type="button"
        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
        onclick="openChatGPTModal('{{ $fieldName }}')"
    >
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
        </svg>
        Fill with ChatGPT
    </button>
</div>

<script>
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
</script>