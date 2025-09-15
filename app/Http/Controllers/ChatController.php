<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->input('message');

        try {
            // Call Zapier AI Agent
            $response = $this->callZapierAgent($userMessage);

            return response()->json([
                'success' => true,
                'response' => $response,
                'timestamp' => now()->toISOString(),
            ]);

        } catch (\Exception $e) {
            Log::error('Chat AI Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'response' => "I'm having trouble connecting right now. Please try again or contact our team at (863) 425-3182 for immediate assistance.",
                'timestamp' => now()->toISOString(),
            ], 500);
        }
    }

    private function callZapierAgent(string $message): string
    {
        $zapierWebhookUrl = config('services.zapier.webhook_url');

        if (!$zapierWebhookUrl) {
            // Fallback to contextual responses if Zapier isn't configured
            return $this->getContextualResponse($message);
        }

        $response = Http::timeout(30)->post($zapierWebhookUrl, [
            'message' => $message,
            'user_id' => session()->getId(), // For conversation tracking
            'timestamp' => now()->toISOString(),
            'company' => 'Danielle Fence & Outdoor Living',
            'context' => [
                'website' => 'daniellefence.com',
                'phone' => '(863) 425-3182',
                'phone2' => '(813) 681-6181',
                'email' => 'info@daniellefence.net',
                'established' => '1976',
                'service_areas' => ['Lakeland', 'Winter Haven', 'Tampa Bay', 'Polk County'],
                'services' => ['Residential Fencing', 'Commercial Fencing', 'Pool Fencing', 'DIY Materials', 'Fence Repair'],
            ]
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Zapier webhook responses can vary in format, adapt as needed
            if (isset($data['response'])) {
                return $data['response'];
            } elseif (isset($data['message'])) {
                return $data['message'];
            } elseif (is_string($data)) {
                return $data;
            } else {
                return 'I received your message! Let me help you with your fencing questions.';
            }
        }

        throw new \Exception('Zapier webhook call failed');
    }

    private function getContextualResponse(string $message): string
    {
        $message = strtolower($message);

        // Pricing/Cost questions
        if (str_contains($message, 'cost') || str_contains($message, 'price') || str_contains($message, 'expensive') || str_contains($message, 'budget')) {
            return "Great question about pricing! Fence costs vary based on material, height, length, and site conditions. For the most accurate estimate, I'd recommend getting a free quote from our team. You can call us at (863) 425-3182 or request a quote online. What type of fence project are you considering?";
        }

        // Material questions
        if (str_contains($message, 'material') || str_contains($message, 'vinyl') || str_contains($message, 'aluminum') || str_contains($message, 'wood')) {
            return "We offer several excellent fence materials! Vinyl is low-maintenance and great for privacy, aluminum is perfect for pool areas and looks elegant, and wood gives that classic natural look. All our materials are American-made for quality you can trust. What's your main goal for the fence - privacy, security, decoration, or pool safety?";
        }

        // Service area questions
        if (str_contains($message, 'area') || str_contains($message, 'location') || str_contains($message, 'lakeland') || str_contains($message, 'tampa') || str_contains($message, 'florida')) {
            return "We proudly serve Central Florida! Our main service areas include Lakeland, Winter Haven, Tampa Bay area, and all of Polk County. We've been serving these communities for nearly 50 years. Where is your project located? I can confirm if we service your area!";
        }

        // DIY questions
        if (str_contains($message, 'diy') || str_contains($message, 'install') || str_contains($message, 'myself')) {
            return "We love DIY projects! We offer professional-grade materials perfect for do-it-yourself installation. We also provide installation guides and can offer advice to help ensure your project goes smoothly. Have you done fence installation before, or would this be your first project?";
        }

        // Company/experience questions
        if (str_contains($message, 'experience') || str_contains($message, 'company') || str_contains($message, 'family') || str_contains($message, 'disney')) {
            return "We're proud to be a 3rd generation family-owned business with nearly 50 years of experience in Central Florida! We've had the honor of working with Disney World, SeaWorld, Universal Studios, and thousands of homeowners. Our experience and commitment to quality really shows in every project. What type of fence project are you planning?";
        }

        // General/greeting responses
        return "Hello! I'm Grillbert, and I'm here to help with all your fencing questions! Whether you're looking for residential fencing, commercial projects, or DIY materials, our team at Danielle Fence has nearly 50 years of experience to help you. What can I help you with today?";
    }
}