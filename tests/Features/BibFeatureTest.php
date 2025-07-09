<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use VincentAuger\SierraSdk\Requests\Bib\GetBib;
use VincentAuger\SierraSdk\Requests\Bib\GetList;

/**
 * Only run this test if the environment variables are set and you want to test against the real API.
 */
it('can get a token from the API', function (): void {

    $baseUrl = $_ENV['SIERRA_API_URL'];

    echo "Using API URL: $baseUrl\n";

    $sierra = $this->getClient();
    $authenticator = $sierra->getAuthenticator();

    expect($authenticator->getAccessToken())->toBeString();
    expect($authenticator->getExpiresAt())->toBeInstanceOf(DateTimeImmutable::class);
    expect($authenticator->hasExpired())->toBeFalse();
})->skip(false, 'This test hits the real API and requires valid credentials.');

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

it('can query a single bib resource', function (): void {

    $mockClient = new MockClient([
        GetBib::class => MockResponse::fixture('getbib.with-fields'),
    ]);

    $sierra = $this->getClient();
    $sierra->withMockClient($mockClient);

    $response = $sierra->send(
        new GetBib(4128733)->withFields([
            'id',
            'title',
            'author',
            'marc',
        ]));

    $dto = $response->dto();

    expect($response->status())->toBe(200);
    expect($response->json())->toBeArray();
    expect($dto)->toBeInstanceOf(\VincentAuger\SierraSdk\Data\BibObject::class);

});
