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

function showContentModal(content) {
    // Create modal HTML
    const modalHtml = `
        <div id="chatgpt-modal" class="fixed inset-0 z-[99999] flex items-center justify-center bg-black/50" style="position: fixed;">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[80vh] flex flex-col">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Generated Content</h3>
                    <button onclick="closeChatGPTModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-4 overflow-y-auto flex-1">
                    <div class="prose prose-sm max-w-none">${content}</div>
                </div>
                <div class="flex items-center justify-end gap-2 p-4 border-t bg-gray-50">
                    <button onclick="copyModalContent()" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                        Copy to Clipboard
                    </button>
                    <button onclick="closeChatGPTModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                        Close
                    </button>
                </div>
            </div>
        </div>
    `;

    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHtml);

    // Store content for copying
    window.chatgptModalContent = content;
}

function closeChatGPTModal() {
    const modal = document.getElementById('chatgpt-modal');
    if (modal) {
        modal.remove();
    }
    delete window.chatgptModalContent;
}

function copyModalContent() {
    if (window.chatgptModalContent) {
        const textContent = window.chatgptModalContent.replace(/<[^>]*>/g, '');
        navigator.clipboard.writeText(textContent).then(() => {
            alert('✅ Content copied to clipboard! Paste it into the editor (Ctrl/Cmd+V)');
            closeChatGPTModal();
        }).catch(() => {
            alert('❌ Failed to copy to clipboard');
        });
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

            // Strategy 1: Try Filament's $wire (Livewire v3) - find the edit/create form component
            try {
                // Look for the form component specifically (EditRecord or CreateRecord)
                const allWireComponents = document.querySelectorAll('[wire\\:id]');
                for (let wireEl of allWireComponents) {
                    const wireId = wireEl.getAttribute('wire:id');
                    const component = window.Livewire.find(wireId);

                    // Check if this component has a 'data' property (form components do)
                    if (component && component.$wire && typeof component.$wire.data !== 'undefined') {
                        try {
                            await component.$wire.set('data.' + fieldName, data.content);
                            updated = true;
                            console.log('Updated via Livewire $wire component');
                            break;
                        } catch (err) {
                            console.log('Component does not have data property, trying next...', err);
                            continue;
                        }
                    }
                }
            } catch (e) {
                console.log('Livewire strategy failed:', e);
            }

            // Strategy 2: Find the TipTap editor using the ProseMirror class
            if (!updated) {
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
                                console.log('Updated via TipTap editor');
                                break;
                            }
                        }
                    } catch (e) {
                        console.log('Editor update attempt failed:', e);
                        continue;
                    }
                }
            }

            if (updated) {
                // Show success message
                alert('✅ Content generated and inserted successfully!');
            } else {
                // Show modal with full content
                showContentModal(data.content);
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
window.closeChatGPTModal = closeChatGPTModal;
window.copyModalContent = copyModalContent;

</script>