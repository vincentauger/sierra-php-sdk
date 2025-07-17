<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Requests\Bib;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Request\CreatesDtoFromResponse;
use VincentAuger\SierraSdk\Data\Query\Query;
use VincentAuger\SierraSdk\Data\QueryResultSet;

final class PostQueryBib extends Request implements HasBody
{
    use CreatesDtoFromResponse;
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        public Query $searchQuery,
        public ?int $limit = 10,
        public ?int $offset = 0,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/bibs/query';
    }

    public function createDtoFromResponse(Response $response): QueryResultSet
    {
        $data = $response->json();

        return QueryResultSet::fromArray($data);
    }

    public function defaultQuery(): array
    {
        return ['limit' => $this->limit, 'offset' => $this->offset];
    }

    /**
     * @return array<string, mixed>
     */
    public function defaultBody(): array
    {
        return $this->searchQuery->toArray();
    }
}
