<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChatGPTIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Set a mock API key for testing
        Config::set('services.openai.api_key', 'test-api-key');
    }

    public function test_generate_endpoint_requires_authentication(): void
    {
        // Arrange & Act
        $response = $this->postJson('/api/chatgpt-generate', [
            'prompt' => 'Test prompt',
        ]);

        // Assert
        $response->assertStatus(401);
    }

    public function test_autofill_endpoint_requires_authentication(): void
    {
        // Arrange & Act
        $response = $this->postJson('/api/chatgpt-autofill', [
            'prompt' => 'Test prompt',
        ]);

        // Assert
        $response->assertStatus(401);
    }

    public function test_generate_endpoint_validates_required_fields(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->postJson('/api/chatgpt-generate', []);

        // Assert
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['prompt']);
    }

    public function test_generate_endpoint_validates_prompt_max_length(): void
    {
        // Arrange
        $user = User::factory()->create();
        $longPrompt = str_repeat('a', 1001);

        // Act
        $response = $this->actingAs($user)->postJson('/api/chatgpt-generate', [
            'prompt' => $longPrompt,
        ]);

        // Assert
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['prompt']);
    }

    public function test_generate_endpoint_validates_tone_enum(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->postJson('/api/chatgpt-generate', [
            'prompt' => 'Test prompt',
            'tone' => 'invalid-tone',
        ]);

        // Assert
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['tone']);
    }

    public function test_generate_endpoint_validates_length_enum(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->postJson('/api/chatgpt-generate', [
            'prompt' => 'Test prompt',
            'length' => 'invalid-length',
        ]);

        // Assert
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['length']);
    }

    public function test_generate_endpoint_returns_error_when_api_key_not_configured(): void
    {
        // Arrange
        Config::set('services.openai.api_key', null);
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->postJson('/api/chatgpt-generate', [
            'prompt' => 'Test prompt',
        ]);

        // Assert
        $response->assertStatus(500);
        $response->assertJson([
            'success' => false,
            'error' => 'OpenAI API key not configured'
        ]);
    }

    public function test_generate_endpoint_successful_content_generation(): void
    {
        // Arrange
        $user = User::factory()->create();

        Http::fake([
            'api.openai.com/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => "This is a test response.\n\nSecond paragraph."
                        ]
                    ]
                ]
            ], 200)
        ]);

        // Act
        $response = $this->actingAs($user)->postJson('/api/chatgpt-generate', [
            'prompt' => 'Write about fence installation',
            'tone' => 'professional',
            'length' => 'medium',
        ]);

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'content' => '<p>This is a test response.</p><p>Second paragraph.</p>'
        ]);

        // Verify the HTTP request was made with correct parameters
        Http::assertSent(function ($request) {
            $body = $request->data();
            return $request->url() === 'https://api.openai.com/v1/chat/completions' &&
                   $body['model'] === 'gpt-3.5-turbo' &&
                   $body['max_tokens'] === 1000 &&
                   $body['temperature'] === 0.7 &&
                   count($body['messages']) === 2 &&
                   $body['messages'][0]['role'] === 'system' &&
                   $body['messages'][1]['role'] === 'user' &&
                   str_contains($body['messages'][1]['content'], 'Write medium content in a professional tone');
        });
    }

    public function test_generate_endpoint_handles_openai_api_errors(): void
    {
        // Arrange
        $user = User::factory()->create();

        Http::fake([
            'api.openai.com/*' => Http::response(['error' => 'Invalid API key'], 401)
        ]);

        // Act
        $response = $this->actingAs($user)->postJson('/api/chatgpt-generate', [
            'prompt' => 'Test prompt',
        ]);

        // Assert
        $response->assertStatus(500);
        $response->assertJson([
            'success' => false,
        ]);
        $response->assertJsonStructure(['error']);
    }

    public function test_generate_endpoint_handles_network_errors(): void
    {
        // Arrange
        $user = User::factory()->create();

        Http::fake([
            'api.openai.com/*' => Http::response(null, 500)
        ]);

        // Act
        $response = $this->actingAs($user)->postJson('/api/chatgpt-generate', [
            'prompt' => 'Test prompt',
        ]);

        // Assert
        $response->assertStatus(500);
        $response->assertJson([
            'success' => false,
        ]);
    }

    public function test_autofill_endpoint_validates_required_fields(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->postJson('/api/chatgpt-autofill', []);

        // Assert
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['prompt']);
    }

    public function test_autofill_endpoint_returns_error_when_api_key_not_configured(): void
    {
        // Arrange
        Config::set('services.openai.api_key', null);
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->postJson('/api/chatgpt-autofill', [
            'prompt' => 'Test prompt',
        ]);

        // Assert
        $response->assertStatus(500);
        $response->assertJsonPath('error', 'OpenAI API key not configured');
    }

    public function test_autofill_endpoint_successful_content_generation(): void
    {
        // Arrange
        $user = User::factory()->create();

        Http::fake([
            'api.openai.com/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'This is autofill content'
                        ]
                    ]
                ]
            ], 200)
        ]);

        // Act
        $response = $this->actingAs($user)->postJson('/api/chatgpt-autofill', [
            'prompt' => 'Generate content about fencing',
            'context' => 'residential fencing',
        ]);

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'content' => 'This is autofill content'
        ]);

        // Verify the HTTP request was made with correct parameters
        Http::assertSent(function ($request) {
            $body = $request->data();
            return $request->url() === 'https://api.openai.com/v1/chat/completions' &&
                   $body['model'] === 'gpt-3.5-turbo' &&
                   $body['max_tokens'] === 500 &&
                   $body['temperature'] === 0.7 &&
                   str_contains($body['messages'][1]['content'], 'Generate content about fencing Context: residential fencing');
        });
    }

    public function test_autofill_endpoint_works_without_context(): void
    {
        // Arrange
        $user = User::factory()->create();

        Http::fake([
            'api.openai.com/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Content without context'
                        ]
                    ]
                ]
            ], 200)
        ]);

        // Act
        $response = $this->actingAs($user)->postJson('/api/chatgpt-autofill', [
            'prompt' => 'Generate content',
        ]);

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'content' => 'Content without context'
        ]);
    }

    public function test_content_formatting_converts_paragraphs_to_html(): void
    {
        // Arrange
        $user = User::factory()->create();

        Http::fake([
            'api.openai.com/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => "First paragraph.\n\nSecond paragraph.\n\nThird paragraph."
                        ]
                    ]
                ]
            ], 200)
        ]);

        // Act
        $response = $this->actingAs($user)->postJson('/api/chatgpt-generate', [
            'prompt' => 'Test prompt',
        ]);

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'content' => '<p>First paragraph.</p><p>Second paragraph.</p><p>Third paragraph.</p>'
        ]);
    }

    public function test_system_message_includes_danielle_fence_context(): void
    {
        // Arrange
        $user = User::factory()->create();

        Http::fake([
            'api.openai.com/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Test content'
                        ]
                    ]
                ]
            ], 200)
        ]);

        // Act
        $this->actingAs($user)->postJson('/api/chatgpt-generate', [
            'prompt' => 'Test prompt',
        ]);

        // Assert - Verify system message contains company context
        Http::assertSent(function ($request) {
            $body = $request->data();
            $systemMessage = $body['messages'][0]['content'];
            return str_contains($systemMessage, 'Danielle Fence') &&
                   str_contains($systemMessage, 'fencing and outdoor living company');
        });
    }

    public function test_tone_and_length_parameters_enhance_prompt(): void
    {
        // Arrange
        $user = User::factory()->create();

        Http::fake([
            'api.openai.com/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Enhanced content'
                        ]
                    ]
                ]
            ], 200)
        ]);

        // Act
        $this->actingAs($user)->postJson('/api/chatgpt-generate', [
            'prompt' => 'Write about fences',
            'tone' => 'friendly',
            'length' => 'long',
        ]);

        // Assert
        Http::assertSent(function ($request) {
            $body = $request->data();
            $userMessage = $body['messages'][1]['content'];
            return str_contains($userMessage, 'Write long content in a friendly tone') &&
                   str_contains($userMessage, 'Write about fences');
        });
    }
}