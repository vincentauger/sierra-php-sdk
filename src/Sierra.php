<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk;

use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\Traits\OAuth2\ClientCredentialsGrant;

final class Sierra extends Connector
{
    use ClientCredentialsGrant;

    /**
     * @param  string  $baseUrl  The base URL for the API, e.g., 'https://api.example.com'
     * @param  string  $clientKey  The client key for authentication, e.g., 'your-client-key'
     * @param  string  $clientSecret  The client secret for authentication, e.g., 'your-client-secret'
     * @return void
     */
    public function __construct(
        private string $baseUrl,
        private string $clientKey,
        private string $clientSecret,
    ) {}

    /**
     * Get the base URL for the API.
     */
    public function resolveBaseUrl(): string
    {
        if (str_ends_with($this->baseUrl, '/')) {
            $this->baseUrl = rtrim($this->baseUrl, '/');
        }

        return $this->baseUrl;
    }

    protected function defaultOauthConfig(): OAuthConfig
    {

        $config = OAuthConfig::make();
        $config->setClientId($this->clientKey);
        $config->setClientSecret($this->clientSecret);
        $config->setTokenEndpoint('/token');
        $config->setRequestModifier(function (Request $request): void {
            // we need Basic authentication for the token endpoint
            $request->headers()->add('Authorization', 'Basic '.base64_encode($this->clientKey.':'.$this->clientSecret));
        });

        return $config;

    }
}
