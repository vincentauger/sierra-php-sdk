<?php

declare(strict_types=1);

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

    $sierra = $this->getClient();
    $authenticator = $sierra->getAuthenticator();

    expect($authenticator->getAccessToken())->toBeString();
    expect($authenticator->getExpiresAt())->toBeInstanceOf(DateTimeImmutable::class);
    expect($authenticator->hasExpired())->toBeFalse();
})->skip(true, 'This test hits the real API and requires valid credentials.');

it('can get a list of bibs', function (): void {

    $mockClient = new MockClient([
        GetList::class => MockResponse::fixture('getlist'),
    ]);

    $sierra = $this->getClient();

    $sierra->withMockClient($mockClient);
    $response = $sierra->send(new GetList()->deleted(false));

    $dto = $response->dto();

    expect($response->status())->toBe(200);
    expect($response->json())->toBeArray();
    expect($response->json())->toHaveKey('entries');

    expect($dto)->toBeInstanceOf(\VincentAuger\SierraSdk\Data\BibResultSet::class);
    expect($dto->total)->toBe(50);
    expect($dto->start)->toBe(0);
    expect($dto->entries)->toBeArray()->toHaveCount(50);
    expect($dto->entries[0])->toBeInstanceOf(\VincentAuger\SierraSdk\Data\BibObject::class);

});
