<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Saloon\Contracts\Authenticator;

class BaseTest extends TestCase
{
    private ?Authenticator $authenticator = null;

    protected function setUp(): void
    {
        parent::setUp();

        // load environment variables for testing against the real API
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__.'/../');
        $dotenv->load();

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
        $key = $_ENV['SIERRA_CLIENT_KEY'];
        $secret = $_ENV['SIERRA_CLIENT_SECRET'];
        $baseUrl = $_ENV['SIERRA_API_URL'];

        return new \VincentAuger\SierraSdk\Sierra(
            baseUrl: $baseUrl,
            clientKey: $key,
            clientSecret: $secret
        );
    }
}
