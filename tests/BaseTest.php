<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Saloon\Contracts\Authenticator;
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

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Get an Authenticator instance for the Sierra API.
     *
     * This method retrieves the client key, secret, and base URL from environment variables,
     * then creates a new instance of the Sierra SDK and returns its access token authenticator.
     */
    public function getAuthenticator(): Authenticator
    {

        if ($this->authenticator instanceof \Saloon\Contracts\Authenticator) {
            return $this->authenticator;
        }

        $sierra = $this->getClient();

        return $sierra->getAccessToken();
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

        return $this->sierra;
    }
}
