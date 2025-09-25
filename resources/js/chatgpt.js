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
            console.log('ChatGPT response:', data);

            let updated = false;

            // Strategy 1: Use Filament's $getEditor() API (proper way)
            const richEditorComponent = document.querySelector('[x-data*="richEditorFormComponent"]');
            if (richEditorComponent && richEditorComponent.nodeType === Node.ELEMENT_NODE) {
                console.log('Found rich editor component:', richEditorComponent);

                // Try to access Alpine's $getEditor function
                if (richEditorComponent._x_dataStack && richEditorComponent._x_dataStack[0]) {
                    const alpineData = richEditorComponent._x_dataStack[0];

                    // Method 1: Direct $getEditor function call
                    if (typeof alpineData.$getEditor === 'function') {
                        console.log('Using $getEditor() API');
                        const editor = alpineData.$getEditor();
                        if (editor && editor.commands) {
                            editor.chain().focus().setContent(data.content).run();
                            console.log('Updated via Filament $getEditor API');
                            updated = true;
                        }
                    }

                    // Method 2: Update Alpine state and let Filament sync
                    if (!updated && alpineData.state !== undefined) {
                        console.log('Updating Alpine state property');
                        alpineData.state = data.content;

                        // Trigger Alpine reactivity
                        richEditorComponent.dispatchEvent(new CustomEvent('alpine:update', {
                            bubbles: true,
                            detail: { property: 'state', value: data.content }
                        }));

                        updated = true;
                        console.log('Updated via Alpine state property');
                    }
                }

                // Method 3: Use Alpine.js evaluate to call $getEditor
                if (!updated) {
                    try {
                        console.log('Trying Alpine evaluate with $getEditor');
                        const result = richEditorComponent._x_evaluate?.('$getEditor()?.chain().focus().setContent($content).run()', {
                            $content: data.content
                        });
                        if (result !== false) {
                            updated = true;
                            console.log('Updated via Alpine evaluate');
                        }
                    } catch (e) {
                        console.log('Alpine evaluate failed:', e.message);
                    }
                }
            }

            // Strategy 2: Update Livewire state and trigger editor refresh
            if (!updated) {
                console.log('Trying Livewire state update...');
                const livewireComponent = document.querySelector('[wire\\:id]');
                if (livewireComponent && livewireComponent.nodeType === Node.ELEMENT_NODE && window.Livewire) {
                    const componentId = livewireComponent.getAttribute('wire:id');
                    const component = window.Livewire.find(componentId);
                    if (component) {
                        try {
                            await component.set(`data.${fieldName}`, data.content);
                            console.log('Updated Livewire state');

                            // Force editor to refresh after state update
                            setTimeout(() => {
                                // Try to find and update any TipTap editor
                                const proseMirror = document.querySelector('.ProseMirror');
                                if (proseMirror && proseMirror.nodeType === Node.ELEMENT_NODE) {
                                    // Find parent Alpine component
                                    const alpineParent = proseMirror.closest('[x-data]');
                                    if (alpineParent && alpineParent.nodeType === Node.ELEMENT_NODE && alpineParent._x_dataStack) {
                                        const alpineData = alpineParent._x_dataStack[0];
                                        if (typeof alpineData.$getEditor === 'function') {
                                            const editor = alpineData.$getEditor();
                                            if (editor && editor.commands) {
                                                editor.chain().focus().setContent(data.content).run();
                                                updated = true;
                                                console.log('Updated TipTap editor after Livewire sync');
                                            }
                                        }
                                    }
                                }

                                // Fallback: Direct DOM manipulation
                                if (!updated && proseMirror) {
                                    proseMirror.innerHTML = data.content;
                                    proseMirror.dispatchEvent(new Event('input', { bubbles: true }));
                                    proseMirror.dispatchEvent(new Event('change', { bubbles: true }));
                                    updated = true;
                                    console.log('Updated via direct DOM manipulation');
                                }

                                if (updated) {
                                    alert('Content generated and inserted successfully!');
                                } else {
                                    console.warn('Content updated in Livewire state, but visual editor needs refresh');
                                    alert('Content generated! Please refresh the page to see the changes.');
                                }
                            }, 300);

                            return;
                        } catch (e) {
                            console.error('Livewire update failed:', e);
                        }
                    }
                }
            }

            // Strategy 3: Global TipTap editor search
            if (!updated) {
                console.log('Trying global editor search...');

                // Look for any TipTap editors on the page
                const allEditors = document.querySelectorAll('.ProseMirror');
                for (const editorEl of allEditors) {
                    if (editorEl && editorEl.nodeType === Node.ELEMENT_NODE) {
                        const alpineParent = editorEl.closest('[x-data]');
                        if (alpineParent && alpineParent.nodeType === Node.ELEMENT_NODE && alpineParent._x_dataStack) {
                            const alpineData = alpineParent._x_dataStack[0];
                            if (typeof alpineData.$getEditor === 'function') {
                                const editor = alpineData.$getEditor();
                                if (editor && editor.commands) {
                                    editor.chain().focus().setContent(data.content).run();
                                    updated = true;
                                    console.log('Updated via global editor search');
                                    break;
                                }
                            }
                        }
                    }
                }
            }

            // Final fallback: Show content in modal for manual copy
            if (!updated) {
                console.warn('Could not update editor automatically');
                showContentModal(data.content);
            } else {
                alert('Content generated and inserted successfully!');
            }

        } else {
            const errorData = await response.json();
            throw new Error(errorData.error || 'Failed to generate content');
        }
    } catch (error) {
        console.error('ChatGPT error:', error);
        alert('Error generating content: ' + error.message);
    }
}

function showContentModal(content) {
    const textarea = document.createElement('textarea');
    textarea.value = content;
    textarea.style.cssText = 'width: 100%; height: 200px; margin: 10px 0; padding: 10px; border: 1px solid #ccc; border-radius: 4px;';

    const modal = document.createElement('div');
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    `;

    const content_div = document.createElement('div');
    content_div.style.cssText = `
        background: white;
        padding: 20px;
        border-radius: 8px;
        max-width: 600px;
        width: 90%;
        max-height: 80%;
        overflow-y: auto;
    `;

    content_div.innerHTML = `
        <h3 style="margin-top: 0;">Generated Content</h3>
        <p>Content generated but could not update editor automatically. Please copy and paste:</p>
    `;

    content_div.appendChild(textarea);

    const buttonContainer = document.createElement('div');
    buttonContainer.style.cssText = 'margin-top: 15px; text-align: right;';

    const copyButton = document.createElement('button');
    copyButton.textContent = 'Copy to Clipboard';
    copyButton.style.cssText = 'margin-right: 10px; padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;';
    copyButton.onclick = () => {
        textarea.select();
        document.execCommand('copy');
        copyButton.textContent = 'Copied!';
        setTimeout(() => copyButton.textContent = 'Copy to Clipboard', 2000);
    };

    const closeButton = document.createElement('button');
    closeButton.textContent = 'Close';
    closeButton.style.cssText = 'padding: 10px 20px; background: #007cba; color: white; border: none; border-radius: 4px; cursor: pointer;';
    closeButton.onclick = () => modal.remove();

    buttonContainer.appendChild(copyButton);
    buttonContainer.appendChild(closeButton);
    content_div.appendChild(buttonContainer);
    modal.appendChild(content_div);
    document.body.appendChild(modal);

    textarea.select();
}

// Make functions globally available
window.openChatGPTModal = openChatGPTModal;
window.generateChatGPTContent = generateChatGPTContent;

// Log that functions are loaded
console.log('ChatGPT functions loaded:', { openChatGPTModal, generateChatGPTContent });