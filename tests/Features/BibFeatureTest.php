<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use VincentAuger\SierraSdk\Requests\Bib\GetBib;
use VincentAuger\SierraSdk\Requests\Bib\GetList;
use VincentAuger\SierraSdk\Requests\Bib\GetSearchBib;
use VincentAuger\SierraSdk\Requests\Bib\PostQueryBib;

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

    $requets = new GetBib(4128733)->withFields([
        'id',
        'title',
        'author',
        'marc',
    ]);

    $response = $sierra->send($requets);

    $dto = $requets->createDtoFromResponse($response);

    expect($response->status())->toBe(200);
    expect($response->json())->toBeArray();
    expect($dto)->toBeInstanceOf(\VincentAuger\SierraSdk\Data\BibObject::class);

});

it('can search for bibs', function (): void {

    $mockClient = new MockClient([
        GetSearchBib::class => MockResponse::fixture('getsearchbib'),
    ]);

    $sierra = $this->getClient();
    $sierra->withMockClient($mockClient);

    $request = new GetSearchBib('doi.org');
    $response = $sierra->send($request);

    $dto = $request->createDtoFromResponse($response);

    expect($response->status())->toBe(200);
    expect($response->json())->toBeArray();
    expect($dto)->toBeInstanceOf(\VincentAuger\SierraSdk\Data\BibSearchResultSet::class);
    expect($dto->count)->toBe(50);
    expect($dto->total)->toBe(109);
    expect($dto->start)->toBe(0);
    expect($dto->entries)->toBeArray()->toHaveCount(50);

});

it('can search for bibs with a speficic doi', function (): void {

    $mockClient = new MockClient([
        GetSearchBib::class => MockResponse::fixture('getsearchbib.doi'),
    ]);

    $sierra = $this->getClient();
    $sierra->withMockClient($mockClient);

    $request = new GetSearchBib('https://doi.org/10.60825/xd80-gb65');
    $response = $sierra->send($request);

    $dto = $request->createDtoFromResponse($response);

    expect($response->status())->toBe(200);
    expect($response->json())->toBeArray();
    expect($dto)->toBeInstanceOf(\VincentAuger\SierraSdk\Data\BibSearchResultSet::class);
    expect($dto->count)->toBe(1);
    expect($dto->total)->toBe(1);
    expect($dto->start)->toBe(0);
    expect($dto->entries)->toBeArray()->toHaveCount(1);

});

it('can query the bibs endpoint with a simple query', function (): void {

    $mockClient = new MockClient([
        \VincentAuger\SierraSdk\Requests\Bib\PostQueryBib::class => MockResponse::fixture('postquerybib'),
    ]);

    $sierra = $this->getClient();
    $sierra->withMockClient($mockClient);

    $query = \VincentAuger\SierraSdk\Data\Query\QueryFactory::bib()
        ->field('t')
        ->has('scallop');

    $request = new PostQueryBib($query);

    $response = $sierra->send($request);

    $dto = $request->createDtoFromResponse($response);

    expect($response->status())->toBe(200);
    expect($response->json())->toBeArray();
    expect($dto)->toBeInstanceOf(\VincentAuger\SierraSdk\Data\QueryResultSet::class);
    expect($dto->total)->toBe(10);
    expect($dto->start)->toBe(0);
    expect($dto->entries)->toBeArray()->toHaveCount(10);
    expect($dto->entries[0])->toBeInstanceOf(\VincentAuger\SierraSdk\Data\QueryEntry::class);
    expect($dto->entries[0]->getId())->toBe(1141180);

});

it('can query the bibs endpoint with a complex query', function (): void {

    $mockClient = new MockClient([
        \VincentAuger\SierraSdk\Requests\Bib\PostQueryBib::class => MockResponse::fixture('postquerybib.complex'),
    ]);

    $sierra = $this->getClient();
    $sierra->withMockClient($mockClient);

    // query for title that contains "scallop" and author that contains "smith" or "sameoto"
    $titleQuery = \VincentAuger\SierraSdk\Data\Query\QueryFactory::bib()
        ->field('t')
        ->has('scallop');
    $authorQuery2 = \VincentAuger\SierraSdk\Data\Query\QueryFactory::bib()
        ->field('a')
        ->has('sameoto');

    $query = \VincentAuger\SierraSdk\Data\Query\QueryFactory::and(
       $titleQuery,
       $authorQuery2
    );

    $request = new PostQueryBib($query);
    $response = $sierra->send($request);
    $dto = $request->createDtoFromResponse($response);
    expect($response->status())->toBe(200);
    expect($response->json())->toBeArray();
    expect($dto)->toBeInstanceOf(\VincentAuger\SierraSdk\Data\QueryResultSet::class);
    expect($dto->total)->toBe(7);
});

it('can query the bibs endpoint with a MARC field query', function (): void {

    $mockClient = new MockClient([
        \VincentAuger\SierraSdk\Requests\Bib\PostQueryBib::class => MockResponse::fixture('postquerybib.marc'),
        \VincentAuger\SierraSdk\Requests\Bib\GetBib::class => MockResponse::fixture('postquerybib.marc.getbib'),
    ]);

    $sierra = $this->getClient();
    $sierra->withMockClient($mockClient);

    $query = \VincentAuger\SierraSdk\Data\Query\QueryFactory::bib()
        ->marcField('024', null, null, 'a')
        ->equals('https://doi.org/10.60825/dmzw-we44');

    $request = new PostQueryBib($query);

    $response = $sierra->send($request);

    $dto = $request->createDtoFromResponse($response);
    expect($response->status())->toBe(200);
    expect($response->json())->toBeArray();
    expect($dto)->toBeInstanceOf(\VincentAuger\SierraSdk\Data\QueryResultSet::class);
    expect($dto->total)->toBe(1);
    expect($dto->start)->toBe(0);
    expect($dto->entries)->toBeArray()->toHaveCount(1);
    expect($dto->entries[0])->toBeInstanceOf(\VincentAuger\SierraSdk\Data\QueryEntry::class);
    expect($dto->entries[0]->getId())->toBe(4128448);

    $request = new GetBib(4128448)->withFields([
        'id',
        'title',
        'author',
        'marc',
    ]);
    $response = $sierra->send($request);

    $bibDto = $request->createDtoFromResponse($response);
    expect($response->status())->toBe(200);

    expect($bibDto->marc->getFieldsByTag('024'))->toBeArray()->toHaveCount(1);
    $fields024 = $bibDto->marc->getFieldsByTag('024');
    $field024 = $fields024 !== [] ? $fields024[array_key_first($fields024)] : null;
    expect($field024->getSubfieldDataByCode('a'))->toBe('https://doi.org/10.60825/dmzw-we44');

});
