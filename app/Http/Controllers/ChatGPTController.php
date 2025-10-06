<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class ChatGPTController extends Controller
{
    public function generate(Request $request): JsonResponse
    {
        $request->validate([
            'prompt' => 'required|string|max:1000',
            'tone' => 'string|in:professional,friendly,technical,marketing,casual',
            'length' => 'string|in:short,medium,long'
        ]);

        $prompt = $request->input('prompt');
        $tone = $request->input('tone', 'professional');
        $length = $request->input('length', 'medium');

        // Enhance the prompt with tone and length instructions
        $enhancedPrompt = "Write {$length} content in a {$tone} tone. {$prompt}";

        $apiKey = config('services.openai.api_key');

        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'error' => 'OpenAI API key not configured'
            ], 500);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a professional content writer for Danielle Fence, a fencing and outdoor living company. Write clear, engaging, and informative content that helps customers understand products and services.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $enhancedPrompt
                    ]
                ],
                'max_tokens' => 1000,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $content = $response->json('choices.0.message.content');

                // Format the content as HTML paragraphs
                $formattedContent = '<p>' . str_replace("\n\n", '</p><p>', trim($content)) . '</p>';

                return response()->json([
                    'success' => true,
                    'content' => $formattedContent
                ]);
            } else {
                throw new Exception('ChatGPT API error: ' . $response->body());
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to generate content: ' . $e->getMessage()
            ], 500);
        }
    }

    public function autofill(Request $request): JsonResponse
    {
        // Keep existing autofill method for backward compatibility
        $request->validate([
            'prompt' => 'required|string',
            'context' => 'string|nullable'
        ]);

        $apiKey = config('services.openai.api_key');

        if (!$apiKey) {
            return response()->json([
                'error' => 'OpenAI API key not configured'
            ], 500);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a professional content writer for Danielle Fence, a fencing and outdoor living company. Generate high-quality, engaging content that is appropriate for business use.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $request->prompt . ($request->context ? ' Context: ' . $request->context : '')
                    ]
                ],
                'max_tokens' => 500,
                'temperature' => 0.7
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['choices'][0]['message']['content'] ?? '';

                return response()->json([
                    'content' => trim($content)
                ]);
            } else {
                return response()->json([
                    'error' => 'Failed to generate content from OpenAI'
                ], 500);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error connecting to OpenAI: ' . $e->getMessage()
            ], 500);
        }
    }
}