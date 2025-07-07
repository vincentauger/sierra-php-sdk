<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use VincentAuger\SierraSdk\Requests\Bib\GetList;

/**
 * Only run this test if the environment variables are set and you want to test against the real API.
 */
it('can get a token from the API', function (): void {

    $key = $_ENV['SIERRA_CLIENT_KEY'];
    $secret = $_ENV['SIERRA_CLIENT_SECRET'];
    $baseUrl = $_ENV['SIERRA_API_URL'];

    echo "Using API URL: $baseUrl\n";

    $sierra = new \VincentAuger\SierraSdk\Sierra(
        baseUrl: $baseUrl ?? 'https://api.example.com',
        clientKey: $key ?? 'your-client',
        clientSecret: $secret ?? 'your-client-secret'
    );

    $authenticator = $sierra->getAccessToken();

    expect($authenticator->getAccessToken())->toBeString();
    expect($authenticator->getExpiresAt())->toBeInstanceOf(DateTimeImmutable::class);
    expect($authenticator->hasExpired())->toBeFalse();

})->skip('This test hits the real API and requires valid credentials.');

it('can get a list of bibs', function (): void {

    $mockClient = new MockClient([
        GetList::class => MockResponse::fixture('getlist'),
    ]);

    $sierra = $this->getClient();

    $sierra->withMockClient($mockClient);

    // If you want to test against the real API, uncomment the following lines
    // and delete the json response fixture.
    // $authenticator = $this->getAuthenticator();
    // $sierra->authenticate($authenticator);

    $response = $sierra->send(new GetList()->deleted(false));

    expect($response->status())->toBe(200);
    expect($response->json())->toBeArray();
    expect($response->json())->toHaveKey('entries');

});
