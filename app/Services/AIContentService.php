<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIContentService
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key', '');
    }

    /**
     * Generate a complete blog post about fencing topics
     */
    public function generateBlogPost(array $options = []): array
    {
        try {
            if (empty($this->apiKey)) {
                return [
                    'success' => false,
                    'message' => 'OpenAI API key not configured. Please set OPENAI_API_KEY in your environment file.',
                ];
            }

            $topic = $options['topic'] ?? $this->getRandomFencingTopic();
            $style = $options['style'] ?? 'informative';
            $length = $options['length'] ?? 'medium';

            $prompt = $this->buildBlogPrompt($topic, $style, $length);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(60)->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a content writer for Danielle Fence, a professional fence installation company with 49 years of experience serving Central Florida. Write engaging, informative blog posts that showcase expertise and help customers make informed decisions about fencing.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => $this->getTokenLimit($length),
                'temperature' => 0.7,
            ]);

            if (!$response->successful()) {
                throw new \Exception('OpenAI API request failed: ' . $response->body());
            }

            $data = $response->json();
            $content = $data['choices'][0]['message']['content'] ?? '';

            if (empty($content)) {
                throw new \Exception('No content generated from OpenAI');
            }

            return $this->parseGeneratedContent($content, $topic);

        } catch (\Exception $e) {
            Log::error('AI Blog Generation Failed', [
                'error' => $e->getMessage(),
                'options' => $options
            ]);

            return [
                'success' => false,
                'message' => 'Failed to generate blog post: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Build the prompt for blog generation
     */
    protected function buildBlogPrompt(string $topic, string $style, string $length): string
    {
        $lengthInstructions = match($length) {
            'short' => '800-1200 words',
            'medium' => '1200-1800 words', 
            'long' => '1800-2500 words',
            default => '1200-1800 words'
        };

        $styleInstructions = match($style) {
            'informative' => 'educational and informative tone, focusing on practical advice',
            'promotional' => 'promotional but helpful tone, subtly highlighting Danielle Fence services',
            'how-to' => 'step-by-step instructional tone with actionable advice',
            'comparison' => 'analytical tone comparing different options and solutions',
            default => 'informative and helpful tone'
        };

        return "Write a comprehensive blog post about '{$topic}' for Danielle Fence's website. 

REQUIREMENTS:
- Length: {$lengthInstructions}
- Style: {$styleInstructions}
- Include a compelling title
- Write a 150-200 character meta description/excerpt
- Structure with clear headings and subheadings
- Include practical tips and expert insights
- Mention Central Florida climate/conditions when relevant
- Naturally incorporate Danielle Fence's 49 years of experience
- End with a call-to-action encouraging readers to contact for quotes

FORMAT YOUR RESPONSE EXACTLY LIKE THIS:
TITLE: [Blog post title]
EXCERPT: [Meta description/excerpt]
CONTENT: [Full blog post content with proper HTML formatting including <h2>, <h3>, <p>, <ul>, <li> tags]

Focus on providing genuine value to readers while positioning Danielle Fence as the local fencing experts.";
    }

    /**
     * Parse the generated content into structured data
     */
    protected function parseGeneratedContent(string $content, string $topic): array
    {
        $lines = explode("\n", $content);
        $title = '';
        $excerpt = '';
        $postContent = '';
        $currentSection = '';

        foreach ($lines as $line) {
            $line = trim($line);
            
            if (str_starts_with($line, 'TITLE:')) {
                $title = trim(substr($line, 6));
                $currentSection = 'title';
            } elseif (str_starts_with($line, 'EXCERPT:')) {
                $excerpt = trim(substr($line, 8));
                $currentSection = 'excerpt';
            } elseif (str_starts_with($line, 'CONTENT:')) {
                $currentSection = 'content';
            } elseif ($currentSection === 'content' && !empty($line)) {
                $postContent .= $line . "\n";
            }
        }

        // Fallback if parsing fails
        if (empty($title)) {
            $title = $this->generateTitleFromTopic($topic);
        }
        if (empty($excerpt)) {
            $excerpt = $this->generateExcerptFromContent($postContent, $topic);
        }
        if (empty($postContent)) {
            $postContent = $content; // Use entire content as fallback
        }

        return [
            'success' => true,
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'excerpt' => $excerpt,
            'content' => trim($postContent),
            'topic' => $topic,
        ];
    }

    /**
     * Get a random fencing topic for blog generation
     */
    protected function getRandomFencingTopic(): string
    {
        $topics = [
            'Aluminum vs Vinyl Fencing: Which is Best for Florida Homes',
            'How to Choose the Right Fence Height for Your Property',
            'Fence Maintenance Tips for Central Florida Weather',
            'Pool Fence Safety Requirements in Florida',
            'Privacy Fence Options for Backyard Spaces',
            'Commercial Fencing Solutions for Businesses',
            'Hurricane-Resistant Fencing for Florida Properties',
            'DIY Fence Installation: Is It Right for You?',
            'Garden Fence Ideas to Protect Your Landscaping',
            'Security Fencing Options for Property Protection',
            'Decorative Fence Styles to Enhance Curb Appeal',
            'Fence Permit Requirements in Central Florida',
            'Cost Factors When Planning a New Fence Installation',
            'Chain Link vs Privacy Fence: Pros and Cons',
            'Fence Repair vs Replacement: When to Choose Each',
        ];

        return $topics[array_rand($topics)];
    }

    /**
     * Generate title from topic if parsing fails
     */
    protected function generateTitleFromTopic(string $topic): string
    {
        return $topic;
    }

    /**
     * Generate excerpt from content if parsing fails
     */
    protected function generateExcerptFromContent(string $content, string $topic): string
    {
        $excerpt = strip_tags($content);
        $excerpt = \Illuminate\Support\Str::limit($excerpt, 200);
        return $excerpt ?: "Learn about {$topic} from Central Florida's trusted fencing experts with 49 years of experience.";
    }

    /**
     * Get token limit based on length
     */
    protected function getTokenLimit(string $length): int
    {
        return match($length) {
            'short' => 1500,
            'medium' => 2500,
            'long' => 3500,
            default => 2500
        };
    }
}