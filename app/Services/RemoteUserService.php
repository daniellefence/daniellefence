<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class RemoteUserService
{
    /**
     * AES encryption key (shared with remote server)
     */
    private string $sharedKey;

    /**
     * Authentication key for API access
     */
    private string $authKey;

    /**
     * Base URL for the remote API
     */
    private string $apiBaseUrl;

    /**
     * Protected system/staff emails that should not be modified
     */
    private array $protectedEmails = [
        'admin@local.test',
        'admin@yourdomain.com',
        'sbarron@daniellefence.net',
    ];

    public function __construct()
    {
        // Initialize from config or environment variables
        $this->sharedKey = base64_decode(config('services.remote_users.shared_key', 'cJ7nEpn8S3eCzXpiBqvNvmLd7ntrz8RZSGbtL9iQgIM='));
        $this->authKey = config('services.remote_users.auth_key', 'uD3rA9XqLp6YzbNf');
        $this->apiBaseUrl = config('services.remote_users.api_url', 'https://it.daniellehub.com');
    }

    /**
     * Fetch and decrypt remote users from the API
     *
     * @return array|null Array of user data or null on failure
     * @throws Exception
     */
    public function fetchRemoteUsers(): ?array
    {
        try {
            // Build the API URL
            $apiUrl = "{$this->apiBaseUrl}/useroutput/{$this->authKey}";

            Log::info('Fetching remote users from: ' . $apiUrl);

            // Fetch encrypted payload
            $response = Http::timeout(30)->get($apiUrl);

            if (!$response->successful()) {
                Log::error('Failed to fetch remote users', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new Exception("Failed to fetch encrypted payload. Status: " . $response->status());
            }

            $parsed = $response->json();

            // Validate response structure
            if (!isset($parsed['iv'], $parsed['data'])) {
                Log::error('Malformed encrypted data received', ['response' => $parsed]);
                throw new Exception("Malformed encrypted data: missing 'iv' or 'data' fields");
            }

            // Decrypt the payload
            $decryptedData = $this->decryptPayload($parsed['iv'], $parsed['data']);

            if (!$decryptedData) {
                throw new Exception("Failed to decrypt user data");
            }

            Log::info('Successfully fetched and decrypted ' . count($decryptedData) . ' users');

            return $decryptedData;

        } catch (Exception $e) {
            Log::error('Error fetching remote users: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            // Re-throw if in debug mode, otherwise return null
            if (config('app.debug')) {
                throw $e;
            }

            return null;
        }
    }

    /**
     * Decrypt the encrypted payload from the API
     *
     * @param string $ivBase64 Base64 encoded initialization vector
     * @param string $encryptedData Encrypted data string
     * @return array|null Decrypted data array or null on failure
     */
    private function decryptPayload(string $ivBase64, string $encryptedData): ?array
    {
        try {
            // Decode the IV
            $iv = base64_decode($ivBase64);

            // Decrypt using AES-256-CBC
            $decryptedJson = openssl_decrypt(
                $encryptedData,
                'AES-256-CBC',
                $this->sharedKey,
                0,
                $iv
            );

            if ($decryptedJson === false) {
                Log::error('OpenSSL decryption failed');
                return null;
            }

            // Parse JSON
            $data = json_decode($decryptedJson, true);

            if (!is_array($data)) {
                Log::error('Decrypted data is not valid JSON', [
                    'decrypted' => substr($decryptedJson, 0, 100) . '...'
                ]);
                return null;
            }

            return $data;

        } catch (Exception $e) {
            Log::error('Decryption error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Sync remote users with local database
     *
     * @param array $remoteUsers Array of remote user data
     * @param bool $updateExisting Whether to update existing users
     * @param bool $createNew Whether to create new users
     * @return array Statistics about the sync operation
     */
    public function syncUsers(array $remoteUsers, bool $updateExisting = true, bool $createNew = true): array
    {
        $stats = [
            'total' => count($remoteUsers),
            'created' => 0,
            'updated' => 0,
            'skipped' => 0,
            'errors' => 0,
            'protected' => 0,
        ];

        foreach ($remoteUsers as $remoteUser) {
            try {
                // Skip if email is protected
                if ($this->isProtectedEmail($remoteUser['email'] ?? '')) {
                    $stats['protected']++;
                    Log::info("Skipped protected email: " . $remoteUser['email']);
                    continue;
                }

                // Check if user exists
                $existingUser = \App\Models\User::where('email', $remoteUser['email'])->first();

                if ($existingUser) {
                    if ($updateExisting) {
                        // Update existing user
                        $this->updateUser($existingUser, $remoteUser);
                        $stats['updated']++;
                        Log::info("Updated user: " . $remoteUser['email']);
                    } else {
                        $stats['skipped']++;
                    }
                } else {
                    if ($createNew) {
                        // Create new user
                        $this->createUser($remoteUser);
                        $stats['created']++;
                        Log::info("Created user: " . $remoteUser['email']);
                    } else {
                        $stats['skipped']++;
                    }
                }

            } catch (Exception $e) {
                $stats['errors']++;
                Log::error("Error syncing user: " . ($remoteUser['email'] ?? 'unknown'), [
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $stats;
    }

    /**
     * Check if an email is in the protected list
     *
     * @param string $email
     * @return bool
     */
    public function isProtectedEmail(string $email): bool
    {
        return in_array(strtolower($email), array_map('strtolower', $this->protectedEmails));
    }

    /**
     * Update an existing user with remote data
     *
     * @param \App\Models\User $user
     * @param array $remoteData
     * @return void
     */
    private function updateUser(\App\Models\User $user, array $remoteData): void
    {
        // Update user fields (customize based on your needs)
        $user->update([
            'name' => $remoteData['name'] ?? $user->name,
            'phone' => $remoteData['phone'] ?? $user->phone,
            // Add other fields as needed
            'remote_id' => $remoteData['id'] ?? null,
            'synced_at' => now(),
        ]);
    }

    /**
     * Create a new user from remote data
     *
     * @param array $remoteData
     * @return \App\Models\User
     */
    private function createUser(array $remoteData): \App\Models\User
    {
        return \App\Models\User::create([
            'name' => $remoteData['name'] ?? 'Unknown User',
            'email' => $remoteData['email'],
            'password' => bcrypt(\Str::random(16)), // Generate random password
            'phone' => $remoteData['phone'] ?? null,
            'remote_id' => $remoteData['id'] ?? null,
            'synced_at' => now(),
            // Add other fields as needed
        ]);
    }

    /**
     * Get the list of protected emails
     *
     * @return array
     */
    public function getProtectedEmails(): array
    {
        return $this->protectedEmails;
    }

    /**
     * Add an email to the protected list
     *
     * @param string $email
     * @return void
     */
    public function addProtectedEmail(string $email): void
    {
        if (!in_array($email, $this->protectedEmails)) {
            $this->protectedEmails[] = $email;
        }
    }
}