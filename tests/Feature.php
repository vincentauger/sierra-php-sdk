<?php

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
        baseUrl: $baseUrl,
        clientKey: $key,
        clientSecret: $secret
    );

    $authenticator = $sierra->getAccessToken();

    expect($authenticator->getAccessToken())->toBeString();
    expect($authenticator->getExpiresAt())->toBeInstanceOf(DateTimeImmutable::class);
    expect($authenticator->hasExpired())->toBeFalse();

}); // ->skip('This test hits the real API and requires valid credentials.');

// it('can get a list of bibs', function (): void {

//     $authenticator = $this->getAuthenticator();

//     $sierra = new \VincentAuger\SierraSdk\Sierra(
//         baseUrl: $_ENV[ 'SIERRA_API_URL' ],
//         clientKey: $_ENV[ 'SIERRA_CLIENT_KEY' ],
//         clientSecret: $_ENV[ 'SIERRA_CLIENT_SECRET' ]
//     );

//     $sierra->authenticate($authenticator);

//     $response = $sierra->send(new GetList);

//     dd($response->json());

//     expect($response->status())->toBe(200);
//     expect($response->json())->toBeArray();
//     expect($response->json())->toHaveKey('bibs');

// });
