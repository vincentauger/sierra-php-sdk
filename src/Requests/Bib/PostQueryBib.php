<?php

declare(strict_types=1);

namespace VincentAuger\SierraSdk\Requests\Bib;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\CreatesDtoFromResponse;
use VincentAuger\SierraSdk\Data\Query\Query;
use VincentAuger\SierraSdk\Data\QueryResultSet;

final class PostQueryBib extends Request
{
    use CreatesDtoFromResponse;

    protected Method $method = Method::POST;

    public function __construct(
        public Query $searchQuery,
        public ?int $limit = null,
        public ?int $offset = null,
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
        $query = [];

        if ($this->limit !== null) {
            $query['limit'] = $this->limit;
        }

        if ($this->offset !== null) {
            $query['offset'] = $this->offset;
        }

        return $query;
    }

    /**
     * @return array<string, mixed>
     */
    public function defaultBody(): array
    {
        return $this->searchQuery->toArray();
    }
}
