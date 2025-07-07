<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\TokenAuthenticator;

class BaseTest extends TestCase
{

    private ?Authenticator $authenticator = null;

    protected function setUp(): void
    {
        parent::setUp();

        // load environment variables for testing against the real API
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
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
     *
     * @return Authenticator
     */
    public function getAuthenticator(): Authenticator
    {

        if ($this->authenticator) {
            return $this->authenticator;
        }

        $key = $_ENV['SIERRA_CLIENT_KEY'];
        $secret = $_ENV['SIERRA_CLIENT_SECRET'];
        $baseUrl = $_ENV['SIERRA_API_URL'];

        $sierra = new \VincentAuger\SierraSdk\Sierra(
            baseUrl: $baseUrl,
            clientKey: $key,
            clientSecret: $secret
        );

        return $sierra->getAccessToken();
    }




}