<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Saloon\Contracts\Authenticator;
use Saloon\Http\Faking\MockClient;
use VincentAuger\SierraSdk\Sierra;

class BaseTest extends TestCase
{
    private ?Authenticator $authenticator = null;

    private ?Sierra $sierra = null;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        // check if the .env file exists and load it
        $envExists = file_exists(__DIR__.'/../.env');

        // load environment variables for testing against the real API
        if ($envExists) {
            $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__.'/../');
            $dotenv->load();
            echo "Loaded .env file\n";
        } else {
            echo "Skipped .env loading\n";
        }

    }

    protected function setUp(): void
    {
        parent::setUp();
        // MockClient::destroyGlobal();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Get a configured Sierra client instance.
     *
     * This method retrieves the client key, secret, and base URL from environment variables,
     * then creates and returns a new instance of the Sierra SDK.
     */
    public function getClient(): \VincentAuger\SierraSdk\Sierra
    {

        if ($this->sierra instanceof \VincentAuger\SierraSdk\Sierra) {
            return $this->sierra;
        }

        $key = $_ENV['SIERRA_CLIENT_KEY'] ?? 'your-client-key';
        $secret = $_ENV['SIERRA_CLIENT_SECRET'] ?? 'your-client-secret';
        $baseUrl = $_ENV['SIERRA_API_URL'] ?? 'https://api.example.com';

        $this->sierra = new \VincentAuger\SierraSdk\Sierra(
            baseUrl: $baseUrl,
            clientKey: $key,
            clientSecret: $secret
        );

        if ($this->allowAuth()) {
            echo "Authenticating Sierra client in test environment.\n";
            $this->authenticator = $this->sierra->getAccessToken();
            $this->sierra->authenticate($this->authenticator);
        }

        return $this->sierra;
    }

    public function allowAuth(): bool
    {
        // Check if the environment variable is set to true
        return isset($_ENV['ENABLE_IN_TESTS']) && $_ENV['ENABLE_IN_TESTS'] === 'true';
    }

    public function getAuthenticator(): ?Authenticator
    {
        return $this->authenticator;
    }
}
